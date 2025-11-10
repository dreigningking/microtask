<?php

namespace App\Livewire;

use App\Models\Booster;
use App\Models\Task;
use Livewire\Component;
use App\Models\Platform;
use App\Models\Settlement;
use App\Models\TaskWorker;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskSubmission;


class Dashboard extends Component
{
    public $activeView; // Will be set from user preference
    public $userData;
    public $completedTasks;
    public $ongoingTasks;
    public $savedTasks;
    public $availableTasks;
    public $postedJobs;
    public $recentApplications;
    public $earnings;
    public $referralEarnings = 0;
    public $earningsSummary;
    public $savedItems;
    public $trendingPlatforms;
    public $jobStats;
    public $recentSubmissions;
    public $workerSubscription;
    public $taskmasterSubscription;
    public $workerUpgradeSuggestion;
    public $taskmasterUpgradeSuggestion;
    public $workerPendingSubscription;
    public $taskmasterPendingSubscription;

    public function mount()
    {
        // $this->userData = Auth::user();
        // $this->activeView = $this->userData->dashboard_view ?? 'tasks';
        // $this->loadDashboardData();
        // $this->loadSubscriptionData();
    }

    public function loadDashboardData()
    {
        // Load tasks data (tasks the user is working on)
        $this->loadTasksData();
        
        // Load jobs data (tasks the user has posted)
        $this->loadJobsData();
        
        // Load common data for the sidebar
        $this->loadSidebarData();
    }

    public function loadTasksData()
    {
        $user = $this->userData;
        
        // Get completed tasks (TaskWorker entries where the user has completed tasks via TaskSubmission)
        $this->completedTasks = TaskWorker::where('user_id', $user->id)
            ->whereHas('taskSubmissions', function($query) {
                $query->whereNotNull('paid_at');
            })
            ->with(['task', 'taskSubmissions' => function($query) {
                $query->whereNotNull('paid_at')->latest();
            }])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get ongoing tasks (TaskWorker entries where the user has accepted tasks but not completed)
        $this->ongoingTasks = TaskWorker::where('user_id', $user->id)
            ->whereDoesntHave('taskSubmissions', function($query) {
                $query->whereNotNull('paid_at');
            })
            ->with(['task', 'taskSubmissions' => function($query) {
                $query->latest();
            }])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get saved tasks (TaskWorker entries where the user has saved tasks)
        $this->savedTasks = TaskWorker::where('user_id', $user->id)
            ->with('task')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get available tasks that the user could work on
        $this->availableTasks = Task::where('is_active', true)
            ->whereNotIn('user_id', [$user->id]) // Not created by the current user
            ->whereDoesntHave('taskWorkers', function($query) use ($user) {
                $query->where('user_id', $user->id); // Not already saved or accepted by user
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Calculate total earnings from completed submissions
        $this->earnings = TaskSubmission::join('tasks', 'task_submissions.task_id', '=', 'tasks.id')
            ->where('task_submissions.user_id', $user->id)
            ->whereNotNull('task_submissions.paid_at')
            ->sum('tasks.budget_per_submission');

        // Calculate referral earnings from settlements
        $this->referralEarnings = Settlement::where('user_id', $user->id)
            ->where('settlementable_type', 'App\Models\Referral')
            ->sum('amount');
    }

    public function loadJobsData()
    {
        $user = $this->userData;
        
        // Get posted jobs (Tasks created by the user)
        $this->postedJobs = Task::where('user_id', $user->id)
            ->withCount('taskWorkers')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get recent submissions to user's jobs from TaskSubmission table
        $this->recentSubmissions = TaskSubmission::whereHas('task', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['user', 'task', 'task_worker'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get job statistics
        $totalJobs = Task::where('user_id', $user->id)->count();
        $completedJobs = Task::where('user_id', $user->id)
            ->whereHas('taskSubmissions', function($query) {
                $query->whereNotNull('paid_at');
            }, '>=', DB::raw('number_of_submissions'))
            ->count();
        
        // Calculate average rating from TaskWorker reviews
        $averageRating = TaskSubmission::where('user_id', $user->id)
            ->where('accepted',true)->count();
        
        // Calculate total spent from completed and paid submissions
        $totalSpent = TaskSubmission::join('tasks', 'task_submissions.task_id', '=', 'tasks.id')
            ->where('tasks.user_id', $user->id)
            ->whereNotNull('task_submissions.paid_at')
            ->sum('tasks.budget_per_submission');
        
        // Get active jobs count (jobs with accepted workers but not completed)
        $activeJobs = Task::where('user_id', $user->id)
            ->where('is_active', true)
            ->has('taskWorkers')
            ->whereDoesntHave('taskSubmissions', function($query) {
                $query->whereNotNull('paid_at');
            }, '>=', DB::raw('number_of_submissions'))
            ->count();
        
        // Get total workers count (workers who have accepted the task)
        $totalWorkers = TaskWorker::whereHas('task', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();
        
        $this->jobStats = [
            'total' => $totalJobs,
            'completion_rate' => $totalJobs > 0 ? ($completedJobs / $totalJobs) * 100 : 0,
            'average_rating' => $averageRating,
            'avg_completion_time' => 2.3, // This would need actual calculation based on timestamps
            'total_spent' => $totalSpent,
            'active_jobs' => $activeJobs,
            'total_applicants' => $totalWorkers,
        ];
        
        // Monthly jobs data for chart - count of tasks created per month
        $this->jobStats['monthly'] = Task::where('user_id', $user->id)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count')
            ->toArray();
    }

    public function loadSidebarData()
    {
        $user = $this->userData;
        
        // Get earnings summary from completed and paid TaskSubmissions
        $this->earningsSummary = TaskSubmission::join('tasks', 'task_submissions.task_id', '=', 'tasks.id')
            ->where('task_submissions.user_id', $user->id)
            ->whereNotNull('task_submissions.paid_at')
            ->select('task_submissions.*', 'tasks.title', 'tasks.budget_per_submission')
            ->orderBy('task_submissions.paid_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($submission) {
                return (object)[
                    'description' => $submission->title,
                    'amount' => $submission->budget_per_submission,
                    'created_at' => $submission->paid_at,
                    'icon' => 'ri-file-text-line',
                    'icon_color' => 'blue',
                ];
            });
            
        // Get saved items (combining saved tasks for display)
        $this->savedItems = $this->savedTasks;
            
        // Get trending platforms
        $this->trendingPlatforms = Platform::withCount(['tasks' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('tasks_count', 'desc')
            ->limit(4)
            ->get()
            ->map(function($platform, $index) {
                $colors = ['blue', 'purple', 'green', 'yellow'];
                $icons = [
                    'ri-pen-nib-line', 
                    'ri-database-2-line', 
                    'ri-customer-service-line', 
                    'ri-palette-line'
                ];
                
                return [
                    'name' => $platform->name,
                    'icon' => $icons[$index % count($icons)],
                    'color' => $colors[$index % count($colors)],
                    'count' => $platform->tasks_count
                ];
            })
            ->toArray();
            
        // If no platforms exist yet, provide fallback data
        if (empty($this->trendingPlatforms)) {
            $this->trendingPlatforms = [
                ['name' => 'Content Writing', 'icon' => 'ri-pen-nib-line', 'color' => 'blue', 'count' => 132],
                ['name' => 'Data Entry', 'icon' => 'ri-database-2-line', 'color' => 'purple', 'count' => 98],
                ['name' => 'Virtual Assistant', 'icon' => 'ri-customer-service-line', 'color' => 'green', 'count' => 87],
                ['name' => 'Graphic Design', 'icon' => 'ri-palette-line', 'color' => 'yellow', 'count' => 76],
            ];
        }
    }

    public function loadSubscriptionData()
    {
        $activeSubscriptions = $this->userData->activeSubscriptions()->with('booster')->get();
        $pendingSubscriptions = $this->userData->pendingSubscriptions()->with('booster')->get();

        $this->workerSubscription = $activeSubscriptions->firstWhere('booster.is_status', 'worker');
        $this->taskmasterSubscription = $activeSubscriptions->firstWhere('booster.type', 'taskmaster');

        $this->workerPendingSubscription = $pendingSubscriptions->firstWhere('booster.type', 'worker');
        $this->taskmasterPendingSubscription = $pendingSubscriptions->firstWhere('booster.type', 'taskmaster');

        // Suggest worker upgrade
        if ($this->workerSubscription) {
            // Find the next booster up for workers
            $this->workerUpgradeSuggestion = Booster::where('id', '!=', $this->workerSubscription->booster_id)
                ->where('is_active', true)
                ->orderBy('id') // A simple way to get a different booster
                ->first();
        } else {
            // Suggest the first worker booster if none is active
            $this->workerUpgradeSuggestion = Booster::where('is_active', true)->orderBy('id')->first();
        }

        // Suggest taskmaster upgrade
        if ($this->taskmasterSubscription) {
            // Find the next booster up for taskmasters
            $this->taskmasterUpgradeSuggestion = Booster::
                where('id', '!=', $this->taskmasterSubscription->booster_id)
                ->where('is_active', true)
                ->orderBy('id')
                ->first();
        } else {
            // Suggest the first taskmaster booster if none is active
            $this->taskmasterUpgradeSuggestion = Booster::where('is_active', true)->orderBy('id')->first();
        }
    }

    public function switchView($view)
    {
        $this->activeView = $view;
        $this->userData->dashboard_view = $view;
        $this->userData->save();
    }
    
    public function render()
    {
        return view('livewire.dashboard');
    }
}
