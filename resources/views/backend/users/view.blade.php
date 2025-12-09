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

        <!-- Profile Card -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar avatar-xl mb-3 mx-auto">
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar-img rounded-circle">
                            @else
                            <div class="avatar-initial bg-primary rounded-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            @endif
                        </div>
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} mb-2">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                        <p class="text-sm text-muted mb-0">Member since: {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Total Earnings</div>
                                <div class="h4 mb-0">${{ number_format($user->settlements()->sum('amount'), 2) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Jobs Posted</div>
                                <div class="h4 mb-0">{{ $jobsPosted->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Jobs Done</div>
                                <div class="h4 mb-0">{{ $jobsDone->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Avg Rating</div>
                                <div class="h4 mb-0">{{ $averageWorkerRating ? number_format($averageWorkerRating, 1) : 'N/A' }}/5</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Subscription</div>
                                <div class="h6 mb-0">{{ $currentSubscription ? $currentSubscription->booster->name : 'None' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Wallet Status</div>
                                <span class="badge bg-{{ $walletFrozen ? 'danger' : 'success' }}">{{ $walletFrozen ? 'Frozen' : 'Active' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-muted small">Task Ban Status</div>
                                <span class="badge bg-{{ $user->is_banned_from_tasks ? 'danger' : 'success' }}">{{ $user->is_banned_from_tasks ? 'Banned' : 'Allowed' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <form action="{{ route('admin.users.suspend') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} btn-sm">
                                    <i class="ri-{{ $user->is_active ? 'pause' : 'play' }}-line me-1"></i>{{ $user->is_active ? 'Suspend' : 'Enable' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.users.wallet.toggle') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-{{ $walletFrozen ? 'success' : 'secondary' }} btn-sm">
                                    <i class="ri-{{ $walletFrozen ? 'lock' : 'lock' }}-unlock-line me-1"></i>{{ $walletFrozen ? 'Unfreeze Wallet' : 'Freeze Wallet' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.users.ban-from-tasks') }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $user->is_banned_from_tasks ? 'Unban' : 'Ban' }} this user from tasks?');">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-{{ $user->is_banned_from_tasks ? 'success' : 'danger' }} btn-sm">
                                    <i class="ri-{{ $user->is_banned_from_tasks ? 'check' : 'forbid' }}-line me-1"></i>{{ $user->is_banned_from_tasks ? 'Unban from Tasks' : 'Ban from Tasks' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user? This action cannot be undone.');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="ri-delete-bin-line me-1"></i>Delete
                                </button>
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
                            <li class="nav-item"><a class="nav-link active" href="#tab-verification" data-toggle="tab" role="tab">Verification & Bank</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-tasks" data-toggle="tab" role="tab">Tasks Doing</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-jobs" data-toggle="tab" role="tab">Jobs Posted</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-earnings" data-toggle="tab" role="tab">Earnings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-payments" data-toggle="tab" role="tab">Payments</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-subscriptions" data-toggle="tab" role="tab">Subscriptions</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-ratings" data-toggle="tab" role="tab">Ratings</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Verification & Bank Tab -->
                        <div class="tab-pane fade show active" id="tab-verification" role="tabpanel">
                            <div class="card-body">
                                <!-- Bank Account Details -->
                                <h5 class="mb-3">Bank Account Details</h5>
                                @if($user->bank_account && !empty($user->bank_account->details) && $bankAccountFields->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Gateway</th>
                                                <th>Account Details</th>
                                                <th>Verification</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $bankAccount = $user->bank_account;
                                            $moderation = $bankAccount->moderations->last();
                                            $status = $moderation ? $moderation->status : 'pending';
                                            @endphp
                                            <tr>
                                                <td>{{ $bankAccount->gateway->name ?? 'Unknown' }}</td>
                                                <td>
                                                    @foreach(array_filter($bankAccount->details) as $slug => $detail)
                                                    {{$bankAccountFields->firstWhere('slug',$slug)['title']}}: {{ $detail }} <br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($bankAccount->verified_at)
                                                    <span class="badge bg-success">
                                                        Verified
                                                    </span>
                                                    @elseif($bankAccount->moderations->last())
                                                        @if($bankAccount->moderations->last()->status == 'rejected')
                                                            <span class="badge bg-danger"> Rejected  </span>
                                                            <br><small class="text-danger">{{ $bankAccount->moderations->last()->notes }}</small>
                                                        @endif
                                                    @else
                                                    <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($bankAccount->moderations->last() && $bankAccount->moderations->last()->status === 'pending')
                                                    <div class="btn-group btn-group-sm">
                                                        <form action="{{ route('admin.users.bank-account.approve') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                                <i class="ri-check-line"></i> Approve
                                                            </button>
                                                        </form>
                                                        <button class="btn btn-danger btn-sm" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectBankAccount">
                                                            <i class="ri-close-line"></i> Reject
                                                        </button>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-info">This user has no bank accounts.</div>
                                @endif

                                <!-- User Verifications -->
                                <h5 class="mb-3 mt-4">User Verifications</h5>
                                @if($user->userVerifications->count())
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Document</th>
                                                <th>Document Name</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->userVerifications as $verification)
                                            @php
                                            $moderation = $verification->moderations->last();
                                            $status = $moderation ? $moderation->status : 'pending';
                                            @endphp
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $verification->document)) }}</td>
                                                <td>
                                                    @if($verification->document_name)
                                                    {{ ucfirst(str_replace('_', ' ', $verification->document_name)) }}
                                                    @if($verification->file_path)
                                                    <br><a href="{{ Storage::url($verification->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        <i class="ri-file-line me-1"></i>View Document
                                                    </a>
                                                    @endif
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($moderation)
                                                    <span class="badge bg-{{ $status === 'approved' ? 'success' : ($status === 'rejected' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($status) }}
                                                    </span>
                                                    @if($status === 'rejected' && $moderation->notes)
                                                    <br><small class="text-danger">{{ $moderation->notes }}</small>
                                                    @endif
                                                    @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($status === 'pending')
                                                    <div class="btn-group btn-group-sm">
                                                        <form action="{{ route('admin.users.verifications.approve') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="verification_id" value="{{ $verification->id }}">
                                                            <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                                <i class="ri-check-line"></i> Approve
                                                            </button>
                                                        </form>
                                                        <button class="btn btn-danger btn-sm" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectVerificationModal{{ $verification->id }}">
                                                            <i class="ri-close-line"></i> Reject
                                                        </button>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-info">This user has no verification documents.</div>
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
                                        <tr>
                                            <td colspan="5" class="text-center">No tasks found.</td>
                                        </tr>
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
                                        <tr>
                                            <td colspan="4" class="text-center">No jobs found.</td>
                                        </tr>
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
                                        <tr>
                                            <td colspan="5" class="text-center">No earnings found.</td>
                                        </tr>
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
                                        @forelse($user->payments->where('status','success') as $payment)
                                        <tr>
                                            <td>{{ $payment->reference }}</td>
                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->currency }}</td>
                                            <td>{{ ucfirst($payment->status) }}</td>
                                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No payments found.</td>
                                        </tr>
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
                                            <th>Booster</th>
                                            <th>Status</th>
                                            <th>Started</th>
                                            <th>Expires</th>
                                            <th>Auto Renew</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subscriptions as $sub)
                                        <tr>
                                            <td>{{ $sub->booster->name ?? '-' }}</td>
                                            <td>{{ ucfirst($sub->status) }}</td>
                                            <td>{{ $sub->starts_at ? $sub->starts_at->format('M d, Y') : '-' }}</td>
                                            <td>{{ $sub->expires_at ? $sub->expires_at->format('M d, Y') : '-' }}</td>
                                            <td>{{ $sub->auto_renew ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No subscriptions found.</td>
                                        </tr>
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
                                    @foreach($job->taskWorkers as $worker)
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

        <!-- Modals for Rejection -->

        @php
        $bankAccount = $user->bank_account;
        $moderation = $bankAccount->moderations->last();
        $status = $moderation ? $moderation->status : 'pending';
        @endphp
        @if(!$moderation || $status === 'pending')
        <div class="modal fade" id="rejectBankAccount" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Bank Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.users.bank-account.reject') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="bankaccount_notes" class="form-label">Rejection Reason</label>
                                <textarea class="form-control" id="bankaccount_notes" name="notes" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif


        @foreach($user->userVerifications as $verification)
        @php $moderation = $verification->moderations->last(); $status = $moderation ? $moderation->status : 'pending'; @endphp
        @if(!$moderation || $status === 'pending')
        <div class="modal fade" id="rejectVerificationModal{{ $verification->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Verification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.users.verifications.reject') }}" method="POST">
                        @csrf
                        <input type="hidden" name="verification_id" value="{{ $verification->id }}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="remarks{{ $verification->id }}" class="form-label">Rejection Reason</label>
                                <textarea class="form-control" id="remarks{{ $verification->id }}" name="remarks" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('a[data-toggle="tab"]'));
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>
@endpush