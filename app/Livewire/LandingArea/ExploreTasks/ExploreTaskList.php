<?php

namespace App\Livewire\LandingArea\ExploreTasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\Platform;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;

#[Layout('components.layouts.landing')]
class ExploreTaskList extends Component
{
    use WithPagination, GeoLocationTrait;

    public $search = '';
    public $selectedPlatforms = [];
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $selectedDurations = [];
    public $sortBy = 'latest';
    public $showModal = false;
    public $showSearch = false;
    public $showFilters = false;
    public $selectedTask = null;
    public $platforms;
    public $countryId;

    protected $listeners = ['showTaskDetails'];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedPlatforms' => ['except' => []],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'selectedDurations' => ['except' => []],
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount()
    {
        $this->platforms = Platform::all();
        if (Auth::check()) {
            $this->countryId = Auth::user()->country_id;
        } else {
            $location = $this->getLocation();
            $this->countryId = $location ? $location->country_id : null;
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedPlatforms()
    {
        // dd($this->selectedPlatforms);
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
    }

    public function updatedSelectedDurations()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'selectedPlatforms',
            'minPrice',
            'maxPrice',
            'selectedDurations',
            'sortBy'
        ]);
        $this->resetPage();
    }

    public function showTaskDetails($taskId)
    {
        $this->selectedTask = Task::with(['user.country', 'platform', 'template', 'workers'])->findOrFail($taskId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedTask = null;
    }

    public function getTasksQuery()
    {
        $countryId = $this->countryId;
        $query = Task::query()
            ->with(['user.country', 'platform', 'template', 'workers'])
            ->where('is_active', true)
            ->where('visibility', 'public')
            ->whereNotNull('approved_at')
            ->where(function($q) {
                $q->where('expiry_date', '>', now())
                  ->orWhereNull('expiry_date');
            })
            ->where(function($q) use ($countryId) {
                $q->whereNull('restricted_countries')
                  ->orWhereRaw('JSON_LENGTH(restricted_countries) = 0')
                  ->orWhereRaw('NOT JSON_CONTAINS(restricted_countries, ?)', [json_encode($countryId)]);
            })
            ->where(function($q) {
                $q->whereRaw('number_of_people > (SELECT COUNT(*) FROM task_workers WHERE task_workers.task_id = tasks.id AND accepted_at IS NOT NULL)')
                  ->orWhereRaw('number_of_people > (SELECT COUNT(*) FROM task_workers WHERE task_workers.task_id = tasks.id AND submitted_at IS NOT NULL)');
            })
            // Filter out tasks from banned users
            ->whereHas('user', function($q) {
                $q->where('is_banned_from_tasks', false)
                  ->orWhereNull('is_banned_from_tasks');
            });

        // Filter out tasks hidden by the current user
        if (Auth::check()) {
            $query->whereDoesntHave('hiddenByUsers', function($q) {
                $q->where('user_id', Auth::id());
            });
        }

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Platforms
        if (!empty($this->selectedPlatforms)) {
            $query->whereIn('platform_id', $this->selectedPlatforms);
        }

        // Price Range
        $query->whereBetween('budget_per_person', [$this->minPrice, $this->maxPrice]);

        // Duration
        if (!empty($this->selectedDurations)) {
            $query->where(function($q) {
                foreach ($this->selectedDurations as $duration) {
                    switch ($duration) {
                        case 'less_than_1_hour':
                            $q->orWhere('expected_completion_minutes', '<', 60);
                            break;
                        case '1_3_hours':
                            $q->orWhereBetween('expected_completion_minutes', [60, 180]);
                            break;
                        case '3_6_hours':
                            $q->orWhereBetween('expected_completion_minutes', [180, 360]);
                            break;
                        case '6_plus_hours':
                            $q->orWhere('expected_completion_minutes', '>', 360);
                            break;
                    }
                }
            });
        }

        // Sorting
        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'popular':
                $query->withCount('applications')->orderByDesc('applications_count');
                break;
            case 'highest_paid':
                $query->orderByDesc('budget_per_person');
                break;
            case 'shortest_time':
                $query->orderBy('expected_completion_minutes');
                break;
        }

        return $query;
    }

    public function hideTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to hide tasks.');
            return;
        }

        $task = Task::find($taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        // Add task to user's hidden tasks
        Auth::user()->hiddenTasks()->sync($taskId);
        
        session()->flash('message', 'Task hidden successfully.');
        $this->dispatch('task-hidden');
    }

    public function unhideTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to unhide tasks.');
            return;
        }

        $task = Task::find($taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        // Remove task from user's hidden tasks
        Auth::user()->hiddenTasks()->detach($taskId);
        
        session()->flash('message', 'Task unhidden successfully.');
        $this->dispatch('task-unhidden');
    }

    public function reportTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to report tasks.');
            return;
        }

        $this->dispatch('open-report-modal', taskId: $taskId);
    }

    public function render()
    {
        $query = $this->getTasksQuery();
        $tasks = $query->paginate(10);
        
        return view('livewire.landing-area.explore-tasks.explore-task-list', [
            'tasks' => $tasks,
            'totalTasks' => $tasks->total()
        ]);
    }
}
