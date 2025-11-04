<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\TaskWorker;
use App\Models\UserVerification;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::whereDoesntHave('roles');

        // Apply filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'suspended') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('task_ban')) {
            if ($request->task_ban === 'banned') {
                $query->where('is_banned_from_tasks', true);
            } elseif ($request->task_ban === 'allowed') {
                $query->where('is_banned_from_tasks', false);
            }
        }

        if ($request->filled('member_since')) {
            $query->whereDate('created_at', '>=', $request->member_since);
        }

        // Country filter for super-admin users
        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Get countries for super-admin filter
        $countries = null;
        if (Auth::user()->first_role->name === 'super-admin') {
            $countries = Country::orderBy('name')->get();
        }

        $users = $query->orderBy('id', 'desc')->paginate(20);

        // Calculate additional data for each user
        foreach ($users as $user) {
            // Tasks completed: TaskSubmission where user_id = user, paid_at not null
            $tasksCompleted = $user->taskSubmissions()->whereNotNull('paid_at')->count();
            // Tasks on hand: TaskWorker where user_id = user (all tasks assigned)
            $tasksOnHand = $user->task_workers()->count();
            $user->tasks_completed = $tasksCompleted;
            $user->tasks_on_hand = $tasksOnHand;

            // Jobs completed: Tasks posted by user where all required workers have completed
            $jobsPosted = $user->tasks()->count();
            $jobsCompleted = $user->tasks()->whereHas('workers', function($q) {
                $q->whereHas('taskSubmissions', function($subQ) {
                    $subQ->whereNotNull('paid_at');
                });
            })->get()->filter(function($task) {
                // A job is completed if number of workers with completed submissions >= number_of_submissions
                return $task->workers()->whereHas('taskSubmissions', function($q) {
                    $q->whereNotNull('paid_at');
                })->count() >= $task->number_of_submissions;
            })->count();
            $user->jobs_completed = $jobsCompleted;
            $user->jobs_posted = $jobsPosted;
        }

        return view('backend.users.list', compact('users', 'countries'));
    }

    public function verifications(){
        $verifications = UserVerification::with('user')->latest()->get();
        return view('backend.users.verifications', compact('verifications'));
    }

    /**
     * Display subscriptions
     */
    public function subscriptions(Request $request)
    {
        $query = \App\Models\Subscription::with('user', 'booster')->localize();

        // Apply filters
        if ($request->filled('user_email')) {
            $user = User::where('email', $request->user_email)->first();
            if ($user) {
                $query->where('user_id', $user->id);
            } else {
                $query->where('user_id', -1); // No matches if user not found
            }
        }

        if ($request->filled('booster_id')) {
            $query->where('booster_id', $request->booster_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('billing_cycle')) {
            $query->where('billing_cycle', $request->billing_cycle);
        }

        // Get available boosters for filter
        $boosters = \App\Models\Booster::where('is_active', 1)->get();

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backend.users.subscriptions', compact('subscriptions', 'boosters'));
    }

    /**
     * Display the specified subscription.
     */
    public function subscription_view(\App\Models\Subscription $subscription)
    {
        $subscription->load('user', 'booster');

        return view('backend.users.subscription_view', compact('subscription'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load([
            'wallets',
            'tasks', // jobs posted
            'task_workers.task', // jobs done
            'settlements', // earnings
        ]);

        // Sum of earnings (settlements)
        $totalEarnings = $user->settlements()->sum('amount');

        // Jobs posted (tasks created by user)
        $jobsPosted = $user->tasks()->withCount('workers')->get();

        // Jobs done (tasks user worked on)
        $jobsDone = $user->task_workers()->with('task')->get();

        // Payments made
        $payments = Payment::where('user_id', $user->id)->latest()->get();

        // Earnings (settlements)
        $earnings = $user->settlements()->with('settlementable')->latest()->get();

        // Subscriptions (current/active)
        $subscriptions = \App\Models\Subscription::where('user_id', $user->id)->orderByDesc('starts_at')->get();
        $currentSubscription = $subscriptions->where('status', 'active')->first();

        // Ratings (as worker and as job poster)
        $workerRatings = $user->task_workers()->whereNotNull('task_rating')->pluck('task_rating');
        $averageWorkerRating = $workerRatings->avg();
        $posterRatings = TaskWorker::whereHas('task', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->whereNotNull('task_rating')->pluck('task_rating');
        $averagePosterRating = $posterRatings->avg();

        // Wallet freeze status (if available)
        $wallets = $user->wallets;
        $walletFrozen = $wallets->first() && isset($wallets->first()->is_frozen) ? $wallets->first()->is_frozen : false;

        return view('backend.users.view', compact(
            'user',
            'totalEarnings',
            'jobsPosted',
            'jobsDone',
            'payments',
            'earnings',
            'subscriptions',
            'currentSubscription',
            'averageWorkerRating',
            'averagePosterRating',
            'walletFrozen'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function suspend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', $user->is_active ? 'User enabled.' : 'User suspended.');
    }

    public function banFromTasks(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->is_banned_from_tasks = !$user->is_banned_from_tasks;
        $user->save();
        return back()->with('success', $user->is_banned_from_tasks ? 'User banned from tasks.' : 'User unbanned from tasks.');
    }

    public function enable(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->is_active = true;
        $user->save();
        return back()->with('success', 'User enabled.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function wallet(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $wallets = $user->wallets;
        foreach ($wallets as $wallet) {
            $wallet->is_frozen = !$wallet->is_frozen;
            $wallet->save();
        }
        return back()->with('success', $wallets->first() && $wallets->first()->is_frozen ? 'Wallet(s) frozen.' : 'Wallet(s) unfrozen.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function approveVerification(Request $request)
    {
        $request->validate(['verification_id' => 'required|exists:user_verifications,id']);

        $verification = UserVerification::findOrFail($request->verification_id);
        $verification->update([
            'status' => 'approved',
            'remarks' => null,
        ]);

        return back()->with('success', 'Verification approved successfully.');
    }

    public function rejectVerification(Request $request)
    {
        $request->validate([
            'verification_id' => 'required|exists:user_verifications,id',
            'remarks' => 'required|string|max:500'
        ]);

        $verification = UserVerification::findOrFail($request->verification_id);
        $verification->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
        ]);
        
        return back()->with('success', 'Verification rejected successfully.');
    }
}
