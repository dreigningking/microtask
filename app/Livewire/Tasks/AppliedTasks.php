<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\TaskWorker;
use App\Models\TaskSubmission;
use App\Models\Platform;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class AppliedTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $filterSubmissions = '';
    public $filterPlatforms = '';
    public $filterStatus = '';
    public $user;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterSubmissions' => ['except' => ''],
        'filterPlatforms' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterSubmissions()
    {
        $this->resetPage();
    }

    public function updatedFilterPlatforms()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'filterSubmissions',
            'filterPlatforms',
            'filterStatus',
        ]);
        $this->resetPage();
    }

    public function getTasksQuery()
    {
        $query = Task::with(['user.country', 'platform', 'platformTemplate', 'taskWorkers', 'taskSubmissions'])->whereHas('taskWorkers',function($workers){
            $workers->where('user_id', $this->user->id);
        });


        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterSubmissions == 'no_submissions') {
            $query->whereDoesntHave('taskSubmissions', function($q) {
                $q->where('user_id', $this->user->id);
            });
        } elseif ($this->filterSubmissions == 'have_submissions') {
            $query->whereHas('taskSubmissions', function($q) {
                $q->where('user_id', $this->user->id);
            });
        }

        if ($this->filterPlatforms) {
            $query->where('platform_id', $this->filterPlatforms);
        }

        if ($this->filterStatus == 'ongoing') {
            $query->whereDoesntHave('taskSubmissions', function($q) {
                $q->where('user_id', $this->user->id)->whereNotNull('paid_at');
            });
        } elseif ($this->filterStatus == 'completed') {
            $query->whereHas('taskSubmissions', function($q) {
                $q->where('user_id', $this->user->id)->whereNotNull('paid_at');
            });
        }

        $query->latest();

        return $query;
    }

    public function render()
    {
        $tasks = $this->getTasksQuery()->paginate(10);

        // Get stats
        $total = TaskWorker::where('user_id', $this->user->id)->count();
        $submitted = TaskSubmission::where('user_id', $this->user->id)->count();
        $completed = TaskSubmission::where('user_id', $this->user->id)->whereNotNull('paid_at')->count();
        $cancelled = TaskWorker::where('user_id', $this->user->id)->withTrashed()->whereNotNull('deleted_at')->count();

        $stats = [
            'total' => $total,
            'submitted' => $submitted,
            'completed' => $completed,
            'cancelled' => $cancelled,
        ];

        $platforms = Platform::where('is_active', true)->get();

        return view('livewire.tasks.applied-tasks', [
            'tasks' => $tasks,
            'stats' => $stats,
            'platforms' => $platforms,
        ]);
    }
}
