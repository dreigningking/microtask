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
    public $activeTab = 'active';
    public $stats = [
        'total' => 0,
        'in_progress' => 0,
        'pending_review' => 0,
        'rejected' => 0,
        'drafts' => 0,
        'completed' => 0
    ];

    protected $queryString = [
        'activeTab' => ['except' => 'active'],
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();

        // Get all tasks for the user with necessary relationships
        $tasks = Task::where('user_id', $userId)
            ->with(['taskWorkers', 'taskSubmissions', 'latestModeration'])
            ->get();

        $this->stats['total'] = $tasks->count();
        $this->stats['drafts'] = $tasks->where('is_active', false)->count();

        // Calculate stats based on moderation status and completion
        foreach ($tasks as $task) {
            if (!$task->is_active) {
                // Already counted as draft
                continue;
            }

            $moderation = $task->latestModeration;

            if (!$moderation) {
                // No moderation yet, treat as draft
                $this->stats['drafts']++;
                continue;
            }

            switch ($moderation->status) {
                case 'approved':
                    // Check if completed
                    if ($task->completed_at !== null) {
                        $this->stats['completed']++;
                    } else {
                        $this->stats['in_progress']++;
                    }
                    break;
                case 'pending':
                    $this->stats['pending_review']++;
                    break;
                case 'rejected':
                    $this->stats['rejected']++;
                    break;
            }
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::id();
        $baseQuery = Task::where('user_id', $userId)
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->with(['platform', 'taskWorkers', 'taskSubmissions', 'latestModeration']);

        switch($this->activeTab) {
            case 'active':
                $tasks = $baseQuery->where('is_active', true)->where('completed_at', null)
                    ->whereHas('latestModeration', function($q) {
                        $q->where('status', 'approved');
                    })
                    ->latest()
                    ->paginate(10);
                break;

            case 'pending':
                $tasks = $baseQuery->where('is_active', true)
                    ->whereHas('latestModeration', function($q) {
                        $q->where('status', 'pending');
                    })
                    ->latest()
                    ->paginate(10);
                break;

            case 'completed':
                $tasks = $baseQuery->where('is_active', true)->whereNotNull('completed_at')
                    ->whereHas('latestModeration', function($q) {
                        $q->where('status', 'approved');
                    })->latest()
                    ->paginate(10);
                break;

            case 'drafts':
                $tasks = $baseQuery->where('is_active', false)
                    ->latest()
                    ->paginate(10);
                break;

            case 'rejected':
                $tasks = $baseQuery->where('is_active', true)
                    ->whereHas('latestModeration', function($q) {
                        $q->where('status', 'rejected');
                    })
                    ->with(['latestModeration']) // Ensure we load the moderation for rejection reason
                    ->latest()
                    ->paginate(10);
                break;

            default:
                $tasks = $baseQuery->where('is_active', true)->whereNotNull('completed_at')
                    ->whereHas('latestModeration', function($q) {
                        $q->where('status', 'approved');
                    })
                    ->latest()
                    ->paginate(10);
        }

        return view('livewire.tasks.posted-tasks', [
            'tasks' => $tasks
        ]);
    }
}
