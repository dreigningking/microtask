<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Country;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Models\TaskPromotion;
use App\Models\TaskSubmission;
use App\Models\Setting;
use App\Notifications\TaskMaster\TaskApprovedNotification;
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

        // Review type filter
        if ($request->filled('review_type')) {
            $query->where('review_type', $request->review_type);
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
            $query->where('budget_per_submission', '>=', $request->budget_min);
        }
        if ($request->filled('budget_max')) {
            $query->where('budget_per_submission', '<=', $request->budget_max);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate(25)->withQueryString();

        // Get filter data for the view
        $countries = Country::where('is_active', 1)->orderBy('name')->get();
        $platforms = Platform::where('is_active', 1)->orderBy('name')->get();
        $reviewTypes = [
            'self_review' => 'System Review',
            'admin_review' => 'Admin Review',
            'system_review' => 'System Review'
        ];

        return view('backend.tasks.list', compact(
            'tasks',
            'countries',
            'platforms',
            'reviewTypes'
        ));
    }

    /**
     * Display a listing of task submissions requiring admin review
     */
    public function submissions(Request $request)
    {
        $query = TaskSubmission::with(['task.user', 'task.platform', 'user', 'task_worker']);

        // Apply localization scope (country filter for non-super admins)
        $query->whereHas('task', function($q) {
            $q->localize();
        });

        // Search functionality (by task title, worker name, etc.)
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->get('search_type', 'all');

            $query->where(function($q) use ($search, $searchType) {
                if ($searchType === 'task' || $searchType === 'all') {
                    $q->whereHas('task', function($subQ) use ($search) {
                        $subQ->where('title', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
                    });
                }

                if ($searchType === 'worker' || $searchType === 'all') {
                    $q->whereHas('user', function($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            });
        }

        // Status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending_review':
                    $query->whereNull('reviewed_at')->whereNull('paid_at');
                    break;
                case 'overdue':
                    $deadlineHours = Setting::where('name', 'submission_review_deadline')->value('value') ?? 24;
                    $query->whereNull('reviewed_at')
                          ->whereNull('paid_at')
                          ->whereRaw('(TIMESTAMPDIFF(HOUR, created_at, NOW()) >= ?)', [$deadlineHours]);
                    break;
                case 'completed':
                    $query->whereNotNull('paid_at');
                    break;
                case 'reviewed':
                    $query->whereNotNull('reviewed_at');
                    break;
            }
        }

        // Sub filter by review type (for admin review)
        if ($request->filled('review_type')) {
            $query->whereHas('task', function($q) use ($request) {
                $q->where('review_type', $request->review_type);
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Priority filter: Admin-Monitored tasks first, then escalated self-monitored tasks
        if ($request->get('priority') === 'admin_first') {
            $query->join('tasks', 'task_submissions.task_id', '=', 'tasks.id')
                  ->orderByRaw("CASE WHEN tasks.review_type = 'admin_review' THEN 1 ELSE 2 END ASC")
                  ->orderBy('task_submissions.created_at', 'desc')
                  ->select('task_submissions.*');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $submissions = $query->paginate(25)->withQueryString();

        // Get counts for statistics
        $totalSubmissions = $submissions->total();
        $pendingReview = (clone $query)->whereNull('reviewed_at')->whereNull('paid_at')->count();
        $overdue = (clone $query)->whereNull('reviewed_at')->whereNull('paid_at')
                                ->whereRaw('(TIMESTAMPDIFF(HOUR, created_at, NOW()) >= ?)', [$deadlineHours ?? 24])->count();
        $thisPage = $submissions->count();

        // Get filter data for the view
        $countries = Country::where('is_active', 1)->orderBy('name')->get();
        $platforms = Platform::where('is_active', 1)->orderBy('name')->get();
        $reviewTypes = [
            'self_review' => 'System Review',
            'admin_review' => 'Admin Review',
            'system_review' => 'System Review'
        ];

        return view('backend.tasks.submissions', compact(
            'submissions',
            'totalSubmissions',
            'pendingReview',
            'overdue',
            'thisPage',
            'countries',
            'platforms',
            'reviewTypes',
            
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

        if ($request->filled('review_type')) {
            $query->where('review_type', $request->review_type);
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
            $query->where('budget_per_submission', '>=', $request->budget_min);
        }
        if ($request->filled('budget_max')) {
            $query->where('budget_per_submission', '<=', $request->budget_max);
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
                'Review Type', 'Status', 'Workers', 'Budget Per Person', 
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
                    $task->review_type ?? 'N/A',
                    $task->is_active ? 'Active' : 'Inactive',
                    $task->number_of_submissions,
                    $task->budget_per_submission,
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
        $task->user->notify(new TaskApprovedNotification($task));
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

    /**
     * Show review submission page
     */
    public function reviewSubmission(\App\Models\TaskSubmission $submission)
    {
        $submission->load(['task.user', 'task.platform', 'user']);
        return view('backend.tasks.review_submission', compact('submission'));
    }

    /**
     * Process review submission
     */
    public function processReviewSubmission(Request $request, \App\Models\TaskSubmission $submission)
    {
        $request->validate([
            'review_reason' => 'required|in:1,2,3', // 1=approve, 2=request revision, 3=reject
            'review' => 'nullable|string|max:1000'
        ]);

        $submission->review_reason = $request->review_reason;
        $submission->review = $request->review;
        $submission->reviewed_at = now();
        $submission->reviewed_by = Auth::id();

        if ($request->review_reason == 1) { // Approve
            $message = 'Submission approved successfully.';
        } 

        $submission->save();

        // Optional: Send notification to worker about the review

        return redirect()->route('admin.tasks.review_submission', $submission)->with('success', $message);
    }

    /**
     * Reset submission for revision
     */
    public function resetSubmissionForRevision(Request $request, \App\Models\TaskSubmission $submission)
    {
        $submission->reviewed_at = null;
        $submission->review_reason = null;
        $submission->review = null;
        $submission->save();

        return redirect()->route('admin.tasks.review_submission', $submission)->with('success', 'Submission reset for revision.');
    }

    /**
     * Disburse payment to worker
     */
    public function disbursePayment(Request $request, \App\Models\TaskSubmission $submission)
    {
        if ($submission->paid_at) {
            return redirect()->back()->with('error', 'This submission has already been paid.');
        }

        if (!$submission->reviewed_at) {
            return redirect()->back()->with('error', 'Submission must be reviewed before payment can be disbursed.');
        }

        $amount = $submission->task->budget_per_submission;

        // Create settlement record
        $settlement = \App\Models\Settlement::create([
            'user_id' => $submission->user_id,
            'task_id' => $submission->task_id,
            'task_submission_id' => $submission->id,
            'amount' => $amount,
            'currency' => $submission->task->currency,
            'type' => 'credit',
            'status' => 'completed',
            'description' => 'Task completion payment',
            'processed_at' => now(),
            'processed_by' => Auth::id(),
        ]);

        // Mark submission as paid
        $submission->paid_at = now();
        $submission->save();

        // Add to user's wallet
        $wallet = $submission->user->wallet ?? \App\Models\Wallet::create([
            'user_id' => $submission->user_id,
            'balance' => 0,
            'currency' => $submission->task->currency
        ]);

        $wallet->balance += $amount;
        $wallet->save();

        // Optional: Send payment notification to worker

        return redirect()->back()->with('success', 'Payment disbursed successfully.');
    }
}
