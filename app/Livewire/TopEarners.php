<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskWorker;
use App\Models\TaskSubmission;
use App\Models\Platform;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TopEarners extends Component
{
    public function render()
    {
        // Get current user's currency
        $currency = 'USD'; // default
        if (Auth::check()) {
            $currency = Auth::user()->country->currency ?? 'USD';
        }

        // Get top 7 earners with wallets in the currency
        $topEarners = User::select('users.*')
            ->join('wallets', 'users.id', '=', 'wallets.user_id')
            ->where('wallets.currency', $currency)
            ->where('wallets.is_frozen', false)
            ->orderByRaw('CAST(wallets.balance AS DECIMAL(15,2)) DESC')
            ->limit(7)
            ->with(['wallets' => function($q) use ($currency) {
                $q->where('currency', $currency)->where('is_frozen', false);
            }])
            ->withCount('taskWorkers')
            ->get();

        // Get insights
        $totalTasks = Task::count();
        $totalTaskCompleted = TaskSubmission::where('accepted', true)->count();
        $totalWorkers = TaskWorker::distinct('user_id')->count('user_id');
        $totalCreators = Task::distinct('user_id')->count('user_id');

        // Get top earning categories (platforms with most tasks)
        $topCategoriesQuery = Platform::select('platforms.name')
            ->join('tasks', 'platforms.id', '=', 'tasks.platform_id')
            ->selectRaw('platforms.name, COUNT(tasks.id) as task_count')
            ->groupBy('platforms.id', 'platforms.name')
            ->orderBy('task_count', 'desc')
            ->limit(5)
            ->get();

        $totalTasksForCategories = $topCategoriesQuery->sum('task_count');

        $topCategories = $topCategoriesQuery->map(function($platform) use ($totalTasksForCategories) {
            $percentage = $totalTasksForCategories > 0 ? round(($platform->task_count / $totalTasksForCategories) * 100) : 0;
            return [
                'name' => $platform->name,
                'percentage' => $percentage,
            ];
        });

        return view('livewire.top-earners', [
            'topEarners' => $topEarners,
            'totalTasks' => $totalTasks,
            'totalTaskCompleted' => $totalTaskCompleted,
            'totalWorkers' => $totalWorkers,
            'totalCreators' => $totalCreators,
            'topCategories' => $topCategories,
            'currency' => $currency,
        ]);
    }
}
