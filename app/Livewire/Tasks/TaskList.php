<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\Platform;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;

class TaskList extends Component
{
    use WithPagination, GeoLocationTrait;

    public $search = '';
    public $selectedPlatforms = [];
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $selectedDurations = [];
    public $selectedDeadline = '';
    public $sortBy = 'latest';
    public $platforms;
    public $countryId;
    public $hasActiveFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedPlatforms' => ['except' => []],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'selectedDurations' => ['except' => []],
        'selectedDeadline' => ['except' => ''],
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
        
        // Check for any active filters on mount
        $this->checkActiveFilters();
    }

    /**
     * Check if any filters are active
     */
    public function checkActiveFilters()
    {
        $this->hasActiveFilters = !empty($this->search)
            || !empty($this->selectedPlatforms)
            || $this->minPrice > 0
            || $this->maxPrice < 1000
            || !empty($this->selectedDurations)
            || !empty($this->selectedDeadline);
    }

    /**
     * Apply all filters and reload results
     */
    public function applyFilters()
    {
        $this->checkActiveFilters();
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
            'selectedDeadline',
            'sortBy'
        ]);
        $this->hasActiveFilters = false;
        $this->resetPage();
    }

    /**
     * Handle search button click
     */
    public function searchTasks()
    {
        $this->applyFilters();
    }

    public function getTasksQuery()
    {
        $countryId = $this->countryId;
        $query = Task::query()
            ->with(['user.country', 'platform','latestModeration'])
            ->listable($countryId);

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
        $query->whereBetween('budget_per_submission', [$this->minPrice, $this->maxPrice]);

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

        // Deadline
        if (!empty($this->selectedDeadline)) {
            $now = now();
            switch ($this->selectedDeadline) {
                case '24_hours':
                    $query->where('expiry_date', '<=', $now->addDay());
                    break;
                case '7_days':
                    $query->where('expiry_date', '<=', $now->addDays(7));
                    break;
                case '30_days':
                    $query->where('expiry_date', '<=', $now->addDays(30));
                    break;
                case '3_months':
                    $query->where('expiry_date', '<=', $now->addMonths(3));
                    break;
            }
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
                $query->orderByDesc('budget_per_submission');
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
        
        return view('livewire.tasks.task-list', [
            'tasks' => $tasks,
            'totalTasks' => $tasks->total()
        ]);
    }
}
