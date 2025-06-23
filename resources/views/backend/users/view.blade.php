@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                User Details
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>

        <!-- User Summary Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ $user->name }} <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></h4>
                            <div class="mb-2 text-muted">{{ $user->email }}</div>
                            <div class="mb-2">Member since: {{ $user->created_at->format('M d, Y') }}</div>
                            <div class="mb-2">Total Earnings: <strong>${{ number_format($totalEarnings, 2) }}</strong></div>
                            <div class="mb-2">Jobs Posted: <strong>{{ $jobsPosted->count() }}</strong></div>
                            <div class="mb-2">Jobs Done: <strong>{{ $jobsDone->count() }}</strong></div>
                            <div class="mb-2">Current Subscription: <strong>{{ $currentSubscription ? $currentSubscription->plan->name : 'None' }}</strong></div>
                            <div class="mb-2">Wallet Status: <span class="badge bg-{{ $walletFrozen ? 'danger' : 'success' }}">{{ $walletFrozen ? 'Frozen' : 'Active' }}</span></div>
                            <div class="mb-2">Avg. Worker Rating: <strong>{{ $averageWorkerRating ? number_format($averageWorkerRating, 2) : 'N/A' }}/5</strong></div>
                            <div class="mb-2">Avg. Poster Rating: <strong>{{ $averagePosterRating ? number_format($averagePosterRating, 2) : 'N/A' }}/5</strong></div>
                        </div>
                        <div class="text-end">
                            <form action="{{ $user->is_active ? route('admin.users.suspend') : route('admin.users.enable') }}" method="POST" class="d-inline-block mb-2">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} btn-sm">{{ $user->is_active ? 'Suspend' : 'Enable' }}</button>
                            </form>
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline-block mb-2" onsubmit="return confirm('Delete this user? This action cannot be undone.');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <form action="{{ route('admin.users.wallet.toggle') }}" method="POST" class="d-inline-block mb-2">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-{{ $walletFrozen ? 'success' : 'secondary' }} btn-sm">{{ $walletFrozen ? 'Unfreeze Wallet' : 'Freeze Wallet' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs for User Data -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#tab-overview" data-toggle="tab" role="tab">Overview</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-tasks" data-toggle="tab" role="tab">Tasks Doing</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-jobs" data-toggle="tab" role="tab">Jobs Posted</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-earnings" data-toggle="tab" role="tab">Earnings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-payments" data-toggle="tab" role="tab">Payments</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-subscriptions" data-toggle="tab" role="tab">Subscriptions</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-ratings" data-toggle="tab" role="tab">Ratings</a></li>
                    </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                            <div class="card-body">
                                <h5>User Info</h5>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item">Name: {{ $user->name }}</li>
                                    <li class="list-group-item">Email: {{ $user->email }}</li>
                                    <li class="list-group-item">Status: <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></li>
                                    <li class="list-group-item">Member since: {{ $user->created_at->format('M d, Y') }}</li>
                                    <li class="list-group-item">Current Subscription: {{ $currentSubscription ? $currentSubscription->plan->name : 'None' }}</li>
                                </ul>
                                <h5>Wallets</h5>
                                @if($user->wallets->count())
                                <table class="table table-bordered mb-3">
                                    <thead>
                                        <tr>
                                            <th>Currency</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->wallets as $wallet)
                                            <tr>
                                                <td>{{ $wallet->currency }}</td>
                                                <td>{{ number_format($wallet->balance, 2) }}</td>
                                                <td><span class="badge bg-{{ isset($wallet->is_frozen) && $wallet->is_frozen ? 'danger' : 'success' }}">{{ isset($wallet->is_frozen) && $wallet->is_frozen ? 'Frozen' : 'Active' }}</span></td>
                                            </tr>
                                                @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <div class="alert alert-info mb-3">This user does not have any wallets yet.</div>
                                                @endif
                            </div>
                        </div>
                        <!-- Tasks Doing Tab -->
                        <div class="tab-pane fade" id="tab-tasks" role="tabpanel">
                            <div class="card-body">
                                <h5>Tasks the User is Doing</h5>
                                <table class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th>Task</th>
                                                <th>Status</th>
                                            <th>Started</th>
                                                <th>Completed</th>
                                            <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($jobsDone as $worker)
                                            <tr>
                                                <td>{{ $worker->task->title ?? '-' }}</td>
                                                <td>{{ $worker->status }}</td>
                                                    <td>{{ $worker->accepted_at ? $worker->accepted_at->format('M d, Y') : '-' }}</td>
                                                    <td>{{ $worker->completed_at ? $worker->completed_at->format('M d, Y') : '-' }}</td>
                                                <td>{{ $worker->rating ?? '-' }}</td>
                                                </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">No tasks found.</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                    </div>
                        <!-- Jobs Posted Tab -->
                        <div class="tab-pane fade" id="tab-jobs" role="tabpanel">
                                                    <div class="card-body">
                                <h5>Jobs Posted by User</h5>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Created</th>
                                            <th>Workers</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jobsPosted as $job)
                                            <tr>
                                                <td>{{ $job->title }}</td>
                                                <td>{{ $job->created_at->format('M d, Y') }}</td>
                                                <td>{{ $job->workers_count }}</td>
                                                <td><span class="badge bg-{{ $job->is_active ? 'success' : 'danger' }}">{{ $job->is_active ? 'Active' : 'Inactive' }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center">No jobs found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                                                </div>
                                                            </div>
                        <!-- Earnings Tab -->
                        <div class="tab-pane fade" id="tab-earnings" role="tabpanel">
                            <div class="card-body">
                                <h5>Earnings (Settlements)</h5>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>Amount</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($earnings as $settlement)
                                            <tr>
                                                <td>{{ $settlement->settlementable->title ?? '-' }}</td>
                                                <td>${{ number_format($settlement->amount, 2) }}</td>
                                                <td>{{ $settlement->currency }}</td>
                                                <td>{{ ucfirst($settlement->status) }}</td>
                                                <td>{{ $settlement->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">No earnings found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Payments Tab -->
                        <div class="tab-pane fade" id="tab-payments" role="tabpanel">
                            <div class="card-body">
                                <h5>Payments Made</h5>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                            <th>Reference</th>
                                            <th>Amount</th>
                                            <th>Currency</th>
                                                        <th>Status</th>
                                            <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        @forelse($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->reference }}</td>
                                                <td>${{ number_format($payment->amount, 2) }}</td>
                                                <td>{{ $payment->currency }}</td>
                                                <td>{{ ucfirst($payment->status) }}</td>
                                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                                        </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">No payments found.</td></tr>
                                        @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                            </div>
                        <!-- Subscriptions Tab -->
                        <div class="tab-pane fade" id="tab-subscriptions" role="tabpanel">
                                            <div class="card-body">
                                <h5>Subscriptions</h5>
                                <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                            <th>Plan</th>
                                            <th>Status</th>
                                            <th>Started</th>
                                            <th>Expires</th>
                                            <th>Auto Renew</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                        @forelse($subscriptions as $sub)
                                            <tr>
                                                <td>{{ $sub->plan->name ?? '-' }}</td>
                                                <td>{{ ucfirst($sub->status) }}</td>
                                                <td>{{ $sub->starts_at ? $sub->starts_at->format('M d, Y') : '-' }}</td>
                                                <td>{{ $sub->expires_at ? $sub->expires_at->format('M d, Y') : '-' }}</td>
                                                <td>{{ $sub->auto_renew ? 'Yes' : 'No' }}</td>
                                                                </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">No subscriptions found.</td></tr>
                                        @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                        <!-- Ratings Tab -->
                        <div class="tab-pane fade" id="tab-ratings" role="tabpanel">
                                            <div class="card-body">
                                <h5>Ratings as Worker</h5>
                                <ul class="list-group mb-3">
                                    @forelse($jobsDone as $worker)
                                        @if($worker->rating)
                                            <li class="list-group-item">Task: {{ $worker->task->title ?? '-' }} - Rating: {{ $worker->rating }}/5</li>
                                        @endif
                                    @empty
                                        <li class="list-group-item">No ratings as worker.</li>
                                    @endforelse
                                </ul>
                                <h5>Ratings as Job Poster</h5>
                                <ul class="list-group">
                                    @forelse($jobsPosted as $job)
                                        @foreach($job->workers as $worker)
                                            @if($worker->rating)
                                                <li class="list-group-item">Worker: {{ $worker->user->name ?? '-' }} - Task: {{ $job->title }} - Rating: {{ $worker->rating }}/5</li>
                                            @endif
                                        @endforeach
                                    @empty
                                        <li class="list-group-item">No ratings as job poster.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('a[data-toggle="tab"]'));
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>
@endpush