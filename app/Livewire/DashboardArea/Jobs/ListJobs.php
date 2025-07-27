<?php

namespace App\Livewire\DashboardArea\Jobs;

use App\Models\Task;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;


class ListJobs extends Component
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
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = auth()->id();
        
        // Get all tasks for the user
        $tasks = Task::where('user_id', $userId)->get();
        $workers = TaskWorker::whereIn('task_id', $tasks->pluck('id')->toArray());
        $this->stats['total'] = $tasks->count();
        $this->stats['active'] = $tasks->where('is_active', true)->count();
        $this->stats['drafts'] = $tasks->where('is_active', false)->count();
        $this->stats['in_progress'] = $workers->whereHas('task',function($query){
            $query->where('is_active',true);
        })->where('completed_at',null)->whereNotNull('accepted_at')->distinct('task_id')->count();
        
        // Calculate in progress and completed tasks
        foreach ($tasks as $task) {
            $workerCount = TaskWorker::where('task_id', $task->id)->count();
            
            if ($workerCount >= $task->number_of_people) {
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
        $query = Task::where('user_id', auth()->id())
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
                              $q->whereNull('completed_at')->whereNotNull('accepted_at');
                          });
                        break;
                    case 'completed':
                        $q->where('is_active', true)
                          ->whereHas('workers', function($q) {
                              $q->whereNotNull('completed_at')
                                ->groupBy('task_id')
                                ->havingRaw('COUNT(*) >= tasks.number_of_people');
                          });
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

        return view('livewire.dashboard-area.jobs.list-jobs', [
            'jobs' => $jobs
        ]);
    }
}
