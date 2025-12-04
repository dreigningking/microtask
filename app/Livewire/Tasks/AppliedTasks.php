<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class AppliedTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all'; // 'all', 'accepted', 'saved', 'submitted', 'completed', 'cancelled'
    public $sortBy = 'latest';
    public $user;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount()
    {
        $this->user = Auth::user();
        // Set status based on the current route
        $routeName = request()->route()->getName();
        switch ($routeName) {
            case 'tasks.ongoing':
                $this->status = 'accepted';
                break;
            case 'tasks.completed':
                $this->status = 'completed';
                break;
            case 'tasks.submitted':
                $this->status = 'submitted';
                break;
            case 'tasks.saved':
                $this->status = 'saved';
                break;
            default:
                $this->status = 'all';
                break;
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
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
            'status',
            'sortBy',
        ]);
        $this->resetPage();
    }

    public function getTasksQuery()
    {
        $query = Task::with(['user.country', 'platform', 'platformTemplate'])->whereHas('taskWorkers',function($workers){
            $workers->where('user_id', $this->user->id);
        });
                           

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        switch ($this->status) {
            case 'accepted':
                $query->whereDoesntHave('taskSubmissions', function($q) {
                          $q->where('user_id',$this->user->id)->whereNotNull('paid_at');
                      });
                break;
            case 'submitted':
                $query->whereHas('taskSubmissions', function($q) {
                          $q->where('user_id',$this->user->id)->whereNull('paid_at');
                      });
                break;
            case 'completed':
                $query->whereHas('taskSubmissions', function($q) {
                    $q->where('user_id',$this->user->id)->whereNotNull('paid_at');
                });
                break;
            case 'cancelled':
                // Cancelled tasks are soft deleted records, so we need to include them
                $query->whereHas('taskWorkers',function($cancelled){
                    $cancelled->withTrashed()->where('user_id',$this->user->id)->whereNotNull('deleted_at');
                });
                break;
            case 'all':
            default:
                // No additional status filter for 'all'
                break;
        }

        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'budget_desc':
                $query->orderBy(Task::select('budget_per_submission')->whereColumn('tasks.id', 'taskWorkers.task_id'), 'desc');
                break;
            case 'budget_asc':
                $query->orderBy(Task::select('budget_per_submission')->whereColumn('tasks.id', 'taskWorkers.task_id'), 'asc');
                break;
        }

        return $query;
    }

    public function render()
    {
        $tasks = $this->getTasksQuery()->get();
        // Get stats using the new TaskSubmission structure
        $totalTasks = TaskWorker::where('user_id', $this->user->id)->count();
        
        $acceptedTasks = TaskWorker::where('user_id', $this->user->id)
            
            ->whereDoesntHave('taskSubmissions', function($q) {
                $q->whereNotNull('paid_at');
            })
            ->count();
            
        $submittedTasks = TaskWorker::where('user_id', $this->user->id)
            ->whereHas('taskSubmissions', function($q) {
                $q->whereNull('paid_at');
            })
            ->count();
            
        $completedTasks = TaskWorker::where('user_id', $this->user->id)
            ->whereHas('taskSubmissions', function($q) {
                $q->whereNotNull('paid_at');
            })
            ->count();
            
        $cancelledTasks = TaskWorker::where('user_id', $this->user->id)
            ->withTrashed()
            ->whereNotNull('deleted_at')
            ->count();

        $stats = [
            'total' => $totalTasks,
            'accepted' => $acceptedTasks,
            
            'submitted' => $submittedTasks,
            'completed' => $completedTasks,
            'cancelled' => $cancelledTasks,
        ];

        return view('livewire.tasks.applied-tasks', [
            'tasks' => $tasks,
            'stats' => $stats,
        ]);
    }
}
