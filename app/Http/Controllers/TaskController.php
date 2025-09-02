<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Country;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Models\TaskPromotion;
use App\Notifications\JobApprovedNotification;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Handle export request
        if ($request->has('export') && $request->export === 'csv') {
            return $this->exportTasks($request);
        }

        $query = Task::query();

        // Apply localization scope (country filter for non-super admins)
        $query->localize();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Country filter (only for super admins)
        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        // Platform filter
        if ($request->filled('platform_id')) {
            $query->where('platform_id', $request->platform_id);
        }

        // Monitoring type filter
        if ($request->filled('monitoring_type')) {
            $query->where('monitoring_type', $request->monitoring_type);
        }

        // Status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', 1);
                    break;
                case 'inactive':
                    $query->where('is_active', 0);
                    break;
                case 'pending_approval':
                    $query->where('is_active', 0)->whereNull('approved_at');
                    break;
                case 'approved':
                    $query->where('is_active', 1)->whereNotNull('approved_at');
                    break;
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Budget range filter
        if ($request->filled('budget_min')) {
            $query->where('budget_per_person', '>=', $request->budget_min);
        }
        if ($request->filled('budget_max')) {
            $query->where('budget_per_person', '<=', $request->budget_max);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate(25)->withQueryString();

        // Get filter data for the view
        $countries = Country::where('is_active', 1)->orderBy('name')->get();
        $platforms = Platform::where('is_active', 1)->orderBy('name')->get();
        $monitoringTypes = [
            'self_monitoring' => 'Self Monitoring',
            'admin_monitoring' => 'Admin Monitoring',
            'system_monitoring' => 'System Monitoring'
        ];

        return view('backend.tasks.list', compact(
            'tasks', 
            'countries', 
            'platforms', 
            'monitoringTypes'
        ));
    }

    /**
     * Export tasks to CSV
     */
    private function exportTasks(Request $request)
    {
        $query = Task::query();

        // Apply localization scope (country filter for non-super admins)
        $query->localize();

        // Apply all the same filters as the index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        if ($request->filled('platform_id')) {
            $query->where('platform_id', $request->platform_id);
        }

        if ($request->filled('monitoring_type')) {
            $query->where('monitoring_type', $request->monitoring_type);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', 1);
                    break;
                case 'inactive':
                    $query->where('is_active', 0);
                    break;
                case 'pending_approval':
                    $query->where('is_active', 0)->whereNull('approved_at');
                    break;
                case 'approved':
                    $query->where('is_active', 1)->whereNotNull('approved_at');
                    break;
            }
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        if ($request->filled('budget_min')) {
            $query->where('budget_per_person', '>=', $request->budget_min);
        }
        if ($request->filled('budget_max')) {
            $query->where('budget_per_person', '<=', $request->budget_max);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->with(['user', 'platform'])->get();

        $filename = 'tasks_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($tasks) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Title', 'Description', 'Owner', 'Country', 'Platform', 
                'Monitoring Type', 'Status', 'Workers', 'Budget Per Person', 
                'Currency', 'Posted Date', 'Approved Date', 'Expiry Date'
            ]);

            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->user->name ?? 'N/A',
                    $task->user->country->name ?? 'N/A',
                    $task->platform->name ?? 'N/A',
                    $task->monitoring_type ?? 'N/A',
                    $task->is_active ? 'Active' : 'Inactive',
                    $task->number_of_people,
                    $task->budget_per_person,
                    $task->currency,
                    $task->created_at->format('Y-m-d H:i:s'),
                    $task->approved_at ? $task->approved_at->format('Y-m-d H:i:s') : 'N/A',
                    $task->expiry_date ? $task->expiry_date->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('backend.tasks.view', compact('task'));
    }

    /**
     * Approve a task (set is_active = true)
     */
    public function approve(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);
        $task = Task::findOrFail($request->task_id);
        $task->approved_at = now();
        $task->approved_by = Auth::id();
        $task->save();
        $task->user->notify(new JobApprovedNotification($task));
        return back()->with('success', 'Task approved successfully.');
    }

    /**
     * Disapprove a task (set is_active = false)
     */
    public function disapprove(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);
        $task = Task::findOrFail($request->task_id);
        $task->approved_at = null;
        $task->approved_by = Auth::id();
        $task->save();
        return back()->with('success', 'Task disapproved successfully.');
    }

    /**
     * Delete a task
     */
    public function delete(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);
        $task = Task::findOrFail($request->task_id);
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }
}
