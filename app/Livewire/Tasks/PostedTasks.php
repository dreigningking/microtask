<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostedTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';
    public $stats = [
        'total' => 0,
        'active' => 0,
        'in_progress' => 0,
        'completed' => 0,
        'drafts' => 0,
        'total_workers' => 0,
        'total_spent' => 0
    ];

    public function mount()
    {
        // Set status based on the current route
        $routeName = request()->route()->getName();
        switch ($routeName) {
            case 'jobs.ongoing':
                $this->status = 'in_progress';
                break;
            case 'jobs.completed':
                $this->status = 'completed';
                break;
            case 'jobs.drafts':
                $this->status = 'drafts';
                break;
            default:
                $this->status = 'all';
                break;
        }
        
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();
        
        // Get all tasks for the user
        $tasks = Task::where('user_id', $userId)->get();
        $workers = TaskWorker::whereIn('task_id', $tasks->pluck('id')->toArray());
        $this->stats['total'] = $tasks->count();
        $this->stats['active'] = $tasks->where('is_active', true)->count();
        $this->stats['drafts'] = $tasks->where('is_active', false)->count();
        
        // Count in-progress tasks (tasks with accepted workers but not completed)
        $this->stats['in_progress'] = Task::where('user_id', $userId)
            ->where('is_active', true)
            ->whereHas('workers', function($query) {
                $query->whereNotNull('accepted_at');
            })
            ->whereDoesntHave('taskSubmissions', function($query) {
                $query->whereNotNull('paid_at');
            }, '>=', DB::raw('number_of_submissions'))
            ->count();
        
        // Calculate completed tasks
        $this->stats['completed'] = 0;
        foreach ($tasks as $task) {
            $workerCount = TaskWorker::where('task_id', $task->id)->count();
            
            if ($workerCount >= $task->number_of_submissions && $task->is_active) {
                $this->stats['completed']++;
            }
            
            // Count total applicants
            $this->stats['total_workers'] += $workerCount;
            
            // Calculate total spent (assuming each worker costs the task's budget)
            $this->stats['total_spent'] += ($workerCount * $task->budget);
        }
    }

    public function getJobsQuery()
    {
        $query = Task::where('user_id', Auth::id())
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== 'all', function($q) {
                switch($this->status) {
                    case 'active':
                        $q->where('is_active', true);
                        break;
                    case 'in_progress':
                        $q->where('is_active', true)
                          ->whereHas('workers', function($q) {
                              $q->whereNotNull('accepted_at');
                          })
                          ->whereDoesntHave('taskSubmissions', function($q) {
                              $q->whereNotNull('paid_at');
                          }, '>=', DB::raw('number_of_submissions'));
                        break;
                    case 'completed':
                        $q->where('is_active', true)
                          ->whereHas('taskSubmissions', function($q) {
                              $q->whereNotNull('paid_at');
                          }, '>=', DB::raw('number_of_submissions'));
                        break;
                    case 'drafts':
                        $q->where('is_active', false);
                        break;
                }
            });

        return $query;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jobs = $this->getJobsQuery()
            ->with(['platform', 'workers'])
            ->latest()
            ->paginate(10);

        return view('livewire.tasks.posted-tasks', [
            'jobs' => $jobs
        ]);
    }
}
