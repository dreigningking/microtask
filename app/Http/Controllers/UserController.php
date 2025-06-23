<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\TaskWorker;
use App\Models\UserVerification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereDoesntHave('roles')->orderBy('id', 'desc')->get();
        foreach ($users as $user) {
            // Tasks completed: TaskWorker where user_id = user, completed_at not null
            $tasksCompleted = $user->task_workers()->whereNotNull('completed_at')->count();
            // Tasks on hand: TaskWorker where user_id = user (all tasks assigned)
            $tasksOnHand = $user->task_workers()->count();
            $user->tasks_completed = $tasksCompleted;
            $user->tasks_on_hand = $tasksOnHand;

            // Jobs completed: Tasks posted by user where all required workers have completed
            $jobsPosted = $user->tasks()->count();
            $jobsCompleted = $user->tasks()->whereHas('workers', function($q) {
                $q->whereNotNull('completed_at');
            })->get()->filter(function($task) {
                // A job is completed if number of workers with completed_at >= number_of_people
                return $task->workers()->whereNotNull('completed_at')->count() >= $task->number_of_people;
            })->count();
            $user->jobs_completed = $jobsCompleted;
            $user->jobs_posted = $jobsPosted;
        }
        return view('backend.users.list', compact('users'));
    }

    public function verifications(){
        $verifications = UserVerification::with('user')->latest()->get();
        return view('backend.users.verifications', compact('verifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $jobsDone = $user->task_workers()->with('task')->whereNotNull('accepted_at')->get();

        // Payments made
        $payments = Payment::where('user_id', $user->id)->latest()->get();

        // Earnings (settlements)
        $earnings = $user->settlements()->with('settlementable')->latest()->get();

        // Subscriptions (current/active)
        $subscriptions = \App\Models\Subscription::where('user_id', $user->id)->orderByDesc('starts_at')->get();
        $currentSubscription = $subscriptions->where('status', 'active')->first();

        // Ratings (as worker and as job poster)
        $workerRatings = $user->task_workers()->whereNotNull('rating')->pluck('rating');
        $averageWorkerRating = $workerRatings->avg();
        $posterRatings = TaskWorker::whereHas('task', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->whereNotNull('rating')->pluck('rating');
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
