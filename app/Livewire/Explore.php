<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Platform;
use App\Models\TaskWorker;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;

class Explore extends Component
{
    use WithPagination, GeoLocationTrait;

    public $search = '';
    public $selectedPlatforms = [];
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $selectedDurations = [];
    public $selectedExperienceLevels = [];
    public $selectedSkills = [];
    public $sortBy = 'latest';
    public $showModal = false;
    public $showSearch = false;
    public $showFilters = false;
    public $selectedTask = null;
    public $platforms;
    public $skills;
    public $countryId;

    protected $listeners = ['showTaskDetails'];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedPlatforms' => ['except' => []],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'selectedDurations' => ['except' => []],
        'selectedExperienceLevels' => ['except' => []],
        'selectedSkills' => ['except' => []],
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount()
    {
        $this->platforms = Platform::all();
        $this->skills = [
            'Microsoft Excel',
            'Copywriting',
            'Photoshop',
            'HTML/CSS',
            'Social Media Management',
            'Data Entry',
            'Customer Service',
            'Project Management',
            'Content Writing',
            'Graphic Design'
        ];
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

    public function updatedSelectedExperienceLevels()
    {
        $this->resetPage();
    }

    public function updatedSelectedSkills()
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
            'selectedExperienceLevels',
            'selectedSkills',
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
            });

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

        // Experience Level
        if (!empty($this->selectedExperienceLevels)) {
            $query->whereIn('experience_level', $this->selectedExperienceLevels);
        }

        // Skills
        if (!empty($this->selectedSkills)) {
            $query->where(function($q) {
                foreach ($this->selectedSkills as $skill) {
                    $q->orWhere('required_skills', 'like', '%' . $skill . '%');
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

    public function render()
    {
        $query = $this->getTasksQuery();
        $tasks = $query->paginate(10);
        
        return view('livewire.explore', [
            'tasks' => $tasks,
            'totalTasks' => $tasks->total()
        ]);
    }
}
