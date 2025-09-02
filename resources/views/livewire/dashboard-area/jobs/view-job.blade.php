<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">{{ $task->title }}</h1>
                <div class="d-flex align-items-center gap-3 text-muted">
                    <span><i class="fa fa-clock me-1"></i>Posted {{ $task->created_at->diffForHumans() }}</span>
                    @if($task->expiry_date)
                    <span><i class="fa fa-calendar me-1"></i>Expires {{ $task->expiry_date->diffForHumans() }}</span>
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2">
                @if(!$task->is_active)
                <button class="btn btn-secondary">Draft</button>
                @elseif($task->workers->count() >= $task->number_of_people)
                <button class="btn btn-warning">Completed</button>
                @elseif($task->workers->count() > 0)
                <button class="btn btn-info">In Progress</button>
                @else
                <button class="bg-success bg-gradient border-0 text-white rounded" disabled>Active</button>
                @endif
                <a href="{{ route('jobs.edit', $task) }}" class="btn btn-outline-secondary">
                    <i class="ri-edit-line me-1"></i> Edit Job
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Current Workers</h6>
                        <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="ri-user-3-line text-primary"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['total_workers'] }}/{{ $task->number_of_people }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Submissions</h6>
                        <span class="bg-info bg-opacity-10 rounded-circle p-2"><i class="ri-file-text-line text-info"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['submissions'] }}/{{ $stats['total_workers'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Completed</h6>
                        <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="ri-check-double-line text-success"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['completed'] }}/{{ $stats['total_workers'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Amount Disbursed</h6>
                        <span class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="ri-money-dollar-circle-line text-warning"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">
                        {{ $task->user->country->currency_symbol }}{{ number_format($stats['amount_disbursed'], 2) }}
                        <span class="text-sm text-muted">/ {{ $task->user->country->currency_symbol }}{{ number_format($stats['total_budget'], 2) }}</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Invitees Stats Cards -->
    @if($stats['total_invitees'] > 0)
    <div class="row g-3 mb-4">
        <div class="col-12">
            <h5 class="mb-3">
                <i class="ri-user-add-line me-2 text-primary"></i>
                Invitees Statistics
            </h5>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Total Invitees</h6>
                        <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="ri-user-add-line text-primary"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['total_invitees'] }}</h3>
                    <small class="text-muted">Total invitations sent</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Accepted Invitations</h6>
                        <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="ri-check-line text-success"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['accepted_invitees'] }}</h3>
                    <small class="text-muted">{{ $stats['total_invitees'] > 0 ? round(($stats['accepted_invitees'] / $stats['total_invitees']) * 100, 1) : 0 }}% acceptance rate</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Pending Invitations</h6>
                        <span class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="ri-time-line text-warning"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['pending_invitees'] }}</h3>
                    <small class="text-muted">Awaiting response</small>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Job Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Job Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Description</h6>
                        <p class="mb-0">{{ $task->description }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Budget per Person</h6>
                            <p class="fw-semibold mb-0">{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_person, 2) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Total Budget</h6>
                            <p class="fw-semibold mb-0">{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_person * $task->number_of_people, 2) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Expected Completion Time</h6>
                            <p class="fw-semibold mb-0">{{ $task->expected_completion_minutes }} minutes</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Number of People Required</h6>
                            <p class="fw-semibold mb-0">{{ $task->number_of_people }}</p>
                        </div>
                    </div>

                    @if($task->files)
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Attached Files</h6>
                        <div class="row g-2">
                            @foreach($task->files as $file)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <div class="me-3">
                                        @if(str_starts_with($file['mime_type'], 'image/'))
                                        <i class="ri-image-line text-primary fs-4"></i>
                                        @elseif(str_starts_with($file['mime_type'], 'application/pdf'))
                                        <i class="ri-file-pdf-line text-danger fs-4"></i>
                                        @elseif(str_starts_with($file['mime_type'], 'application/msword') || str_starts_with($file['mime_type'], 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))
                                        <i class="ri-file-word-line text-primary fs-4"></i>
                                        @elseif(str_starts_with($file['mime_type'], 'application/vnd.ms-excel') || str_starts_with($file['mime_type'], 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
                                        <i class="ri-file-excel-line text-success fs-4"></i>
                                        @else
                                        <i class="ri-file-line text-muted fs-4"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="{{ asset($file['path']) }}" target="_blank" class="text-decoration-none fw-medium">
                                            {{ $file['name'] }}
                                        </a>
                                        <div class="text-muted small">{{ number_format($file['size'] / 1024, 2) }} KB</div>
                                    </div>
                                    <a href="{{ asset($file['path']) }}" target="_blank" class="text-muted">
                                        <i class="ri-download-line"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($task->requirements)
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Requirements</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($task->requirements as $requirement)
                            <li class="mb-2">
                                <i class="ri-check-line text-success me-2"></i>
                                {{ $requirement }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Monitoring Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Monitoring Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Monitoring Type</h6>
                            <p class="fw-semibold mb-0">{{ ucfirst($task->monitoring_type) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Monitoring Frequency</h6>
                            <p class="fw-semibold mb-0">{{ ucfirst($task->monitoring_frequency) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Restricted Countries</h6>
                            <p class="fw-semibold mb-0">
                                @if($task->restricted_countries)
                                {{ implode(', ', $task->restricted_countries) }}
                                @else
                                No restrictions
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Visibility</h6>
                            <p class="fw-semibold mb-0">{{ $task->is_private ? 'Private' : 'Public' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotions -->
            @if($task->promotions->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Active Promotions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($task->promotions as $promotion)
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ $promotion->title }}</h6>
                                        <p class="text-muted small mb-2">{{ $promotion->description }}</p>
                                        <small class="text-muted">Expires: {{ $promotion->expires_at->format('M d, Y') }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ $promotion->type }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Invite Workers -->
            @if($task->visibility)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Invite Workers</h5>
                </div>
                <div class="card-body">
                    <button data-bs-toggle="modal" data-bs-target="#inviteModal" class="btn btn-primary w-100">
                        <i class="ri-user-add-line me-1"></i> Invite Worker
                    </button>
                </div>
            </div>
            @endif

            <!-- Quick Stats -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="fw-bold text-primary mb-1">{{ $stats['total_workers'] }}</h4>
                                <small class="text-muted">Workers</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="fw-bold text-info mb-1">{{ $stats['submissions'] }}</h4>
                                <small class="text-muted">Submissions</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="fw-bold text-success mb-1">{{ $stats['completed'] }}</h4>
                                <small class="text-muted">Completed</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="fw-bold text-warning mb-1">{{ $task->user->country->currency_symbol }}{{ number_format($stats['amount_disbursed'], 0) }}</h4>
                                <small class="text-muted">Paid Out</small>
                            </div>
                        </div>
                        @if($stats['total_invitees'] > 0)
                        <div class="col-12">
                            <hr class="my-2">
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="fw-bold text-primary mb-1">{{ $stats['total_invitees'] }}</h4>
                                <small class="text-muted">Invitees</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="fw-bold text-success mb-1">{{ $stats['accepted_invitees'] }}</h4>
                                <small class="text-muted">Accepted</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Workers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Workers</h5>
            <div class="d-flex gap-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search workers..."
                        class="form-control">
                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Worker</th>
                            <th>Joined</th>
                            <th>Status</th>

                            <th>Payment</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workers as $worker)
                        <tr wire:key="{{$worker->id}}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-3" src="{{ $worker->user->image }}" alt="{{ $worker->user->username }}" width="40" height="40">
                                    <div>
                                        <div class="fw-medium">{{ $worker->user->username }}</div>
                                        <div class="text-muted small">{{ $worker->user->country->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ $worker->created_at->format('M d, Y') }}</div>
                            </td>
                            <td>
                                @if($worker->rejected_at)
                                <span class="badge bg-danger">Rejected</span>
                                @elseif($worker->taskSubmissions->count() == 0)
                                <span class="badge bg-secondary">Pending Submissions</span>
                                @else
                                <span class="badge bg-primary">{{ $worker->taskSubmissions->count() }} {{ Str::plural('Submission', $worker->taskSubmissions->count()) }}</span>
                                @endif
                            </td>

                            <td>
                                @php
                                // Count the number of submissions for this worker where paid_at is not null
                                $paidSubmissionsCount = $worker->taskSubmissions->whereNotNull('paid_at')->count();
                                $totalPaid = $paidSubmissionsCount * $task->budget_per_person;
                                $currency = $task->user->country->currency_symbol ?? '$';
                                @endphp

                                <span class="text-success">
                                    <i class="ri-check-line me-1"></i>
                                    Paid: <strong>{{ $currency }}{{ number_format($totalPaid, 2) }}</strong>
                                </span>


                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="ri-user-line display-4 mb-2"></i>
                                <p>No workers found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing <span class="fw-semibold">{{ $workers->firstItem() }}</span> to <span class="fw-semibold">{{ $workers->lastItem() }}</span> of <span class="fw-semibold">{{ $workers->total() }}</span> results
                </div>
                <div>
                    {{ $workers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions Table -->
    @if($stats['submissions'] > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ri-file-text-line me-2 text-info"></i>
                Submissions
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Worker</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Review Status</th>
                            <th>Payment Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($task->taskSubmissions as $submission)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($submission->task_worker && $submission->task_worker->user)
                                    <img class="rounded-circle me-3" src="{{ $submission->task_worker->user->image }}" alt="{{ $submission->task_worker->user->username }}" width="40" height="40">
                                    <div>
                                        <div class="fw-medium">{{ $submission->task_worker->user->username }}</div>
                                        <div class="text-muted small">{{ $submission->task_worker->user->country->name ?? 'N/A' }}</div>
                                    </div>
                                    @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="ri-user-line text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Unknown Worker</div>
                                        <div class="text-muted small">Worker data unavailable</div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ $submission->created_at->format('M d, Y H:i') }}</div>
                            </td>
                            <td>
                                @if($submission->completed_at)
                                <span class="badge bg-success">Completed</span>
                                @elseif($submission->disputed_at)
                                @if($submission->resolved_at)
                                <span class="badge bg-info">Dispute Resolved</span>
                                @else
                                <span class="badge bg-warning">Disputed</span>
                                @endif
                                @else
                                <span class="badge bg-primary">Submitted</span>
                                @endif
                            </td>
                            <td>
                                @if($submission->reviewed_at)
                                <span class="badge bg-success">Reviewed</span>
                                @elseif($submission->disputed_at)
                                <span class="badge bg-warning">Needs Review</span>
                                @else
                                <span class="badge bg-info">Pending Review</span>
                                @endif
                            </td>
                            <td>
                                @if($submission->paid_at)
                                <span class="badge bg-success">Paid</span>
                                @elseif($submission->completed_at && !$submission->paid_at)
                                <span class="badge bg-warning">Pending Payment</span>
                                @else
                                <span class="badge bg-secondary">Not Eligible</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button wire:click="viewSubmissionDetails({{ $submission->id }})" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-eye-line me-1"></i> Review
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Invitees List -->
    @if($stats['total_invitees'] > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ri-user-add-line me-2 text-primary"></i>
                Invitees List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Invited By</th>
                            <th>Invited Date</th>
                            <th>Expires</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($task->referrals as $referral)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="ri-mail-line text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $referral->email }}</div>
                                        @if($referral->invitee)
                                        <div class="text-muted small">{{ $referral->invitee->username }}</div>
                                        @else
                                        <div class="text-muted small">Not registered yet</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($referral->status === 'accepted')
                                <span class="badge bg-success">Accepted</span>
                                @elseif($referral->status === 'invited')
                                <span class="badge bg-warning">Pending</span>
                                @else
                                <span class="badge bg-secondary">{{ ucfirst($referral->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($referral->referrer)
                                    <img class="rounded-circle me-2" src="{{ $referral->referrer->image }}" alt="{{ $referral->referrer->username }}" width="24" height="24">
                                    <span class="small">{{ $referral->referrer->username }}</span>
                                    @else
                                    <span class="text-muted small">System</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ $referral->created_at->format('M d, Y H:i') }}</div>
                            </td>
                            <td>
                                @if($referral->expire_at)
                                <div class="text-muted small">
                                    @if($referral->expire_at->isPast())
                                    <span class="text-danger">Expired</span>
                                    @else
                                    {{ $referral->expire_at->diffForHumans() }}
                                    @endif
                                </div>
                                @else
                                <span class="text-muted small">No expiry</span>
                                @endif
                            </td>
                            {{-- <td>
                                @if($referral->invitee && $referral->invitee->taskWorkers->where('task_id', $task->id)->count() > 0)
                                <span class="badge bg-info">Working</span>
                                @elseif($referral->status === 'invited' && $referral->expire_at && $referral->expire_at->isFuture())
                                <span class="badge bg-warning">Active</span>
                                @else
                                <span class="text-muted small">-</span>
                                @endif
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Invite Modal -->
    <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inviteModalLabel">Invite Worker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="inviteEmail" class="form-label">Email Addresses</label>
                        <textarea id="inviteEmail" wire:model="inviteEmail" rows="3" placeholder="Enter one or more emails, separated by commas or new lines" class="form-control"></textarea>
                        @error('inviteEmail') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        @if($inviteSummary)
                        <div class="alert alert-info mt-2 mb-0">
                            {{ $inviteSummary }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="inviteUser" wire:loading.attr="disabled" wire:target="inviteUser" class="btn btn-primary">
                        <span wire:loading.remove wire:target="inviteUser">Send Invitation</span>
                        <span wire:loading wire:target="inviteUser">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Sending...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disburse Confirmation Modal -->
    <div class="modal fade" id="disburseModal" tabindex="-1" aria-labelledby="disburseModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disburseModalLabel">Confirm Payment Disbursement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="ri-money-dollar-circle-line text-warning display-4"></i>
                    </div>
                    <p class="text-center">
                        Are you sure you want to disburse payment of <strong>{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_person, 2) }}</strong> to <strong>{{ $selectedWorker->user->username ?? '' }}</strong>?
                    </p>
                    <p class="text-muted small text-center">
                        This action will create a settlement record and mark the task as paid for this worker.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="disbursePayment({{ $selectedWorker->id ?? '' }})" class="btn btn-success">Yes, Disburse Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Submission Details Modal -->
    <div class="modal fade" id="submissionDetailsModal" tabindex="-1" aria-labelledby="submissionDetailsModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submissionDetailsModalLabel">Submission Details</h5>
                    <button type="button" class="btn-close" wire:click="closeSubmissionDetailsModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if($selectedSubmission)
                    <!-- Worker Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Worker</h6>
                            @if($selectedSubmission->task_worker && $selectedSubmission->task_worker->user)
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle me-3" src="{{ $selectedSubmission->task_worker->user->image }}" alt="{{ $selectedSubmission->task_worker->user->username }}" width="50" height="50">
                                <div>
                                    <div class="fw-semibold">{{ $selectedSubmission->task_worker->user->username }}</div>
                                    <div class="text-muted small">{{ $selectedSubmission->task_worker->user->country->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                            @else
                            <p class="text-muted">Worker information unavailable</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Submission Info</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted">Submitted:</small>
                                    <div class="fw-semibold">{{ $selectedSubmission->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Status:</small>
                                    <div>
                                        @if($selectedSubmission->completed_at)
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($selectedSubmission->disputed_at)
                                        @if($selectedSubmission->resolved_at)
                                        <span class="badge bg-info">Dispute Resolved</span>
                                        @else
                                        <span class="badge bg-warning">Disputed</span>
                                        @endif
                                        @else
                                        <span class="badge bg-primary">Submitted</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Data -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Submission Data</h6>
                        @if($selectedSubmission->submissions && is_array($selectedSubmission->submissions))
                        <div class="row g-3">
                            @foreach($selectedSubmission->submissions as $field => $value)
                            <div class="col-12">
                                <h6 class="fw-medium mb-2">{{ ucfirst(str_replace('_', ' ', $field)) }}</h6>
                                @if(is_array($value))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($value as $item)
                                    <span class="badge bg-light text-dark">{{ $item }}</span>
                                    @endforeach
                                </div>
                                @elseif(str_starts_with($value, 'storage/') || str_starts_with($value, 'public/'))
                                <a href="{{ Storage::url(str_replace(['storage/', 'public/'], '', $value)) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-file-line me-1"></i> View File
                                </a>
                                @else
                                <div class="p-3 bg-light rounded">{{ $value }}</div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            No submission data available
                        </div>
                        @endif
                    </div>

                    <!-- Review Section -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Review & Approval</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Review Status</h6>
                                @if($selectedSubmission->reviewed_at)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2">Reviewed</span>
                                    <small class="text-muted">{{ $selectedSubmission->reviewed_at->format('M d, Y H:i') }}</small>
                                </div>
                                @elseif($selectedSubmission->disputed_at)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning me-2">Needs Review</span>
                                    <small class="text-muted">Disputed on {{ $selectedSubmission->disputed_at->format('M d, Y H:i') }}</small>
                                </div>
                                @else
                                <span class="badge bg-info">Pending Review</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Payment Status</h6>
                                @if($selectedSubmission->paid_at)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2">Paid</span>
                                    <small class="text-muted">{{ $selectedSubmission->paid_at->format('M d, Y H:i') }}</small>
                                </div>
                                @elseif($selectedSubmission->completed_at && !$selectedSubmission->paid_at)
                                <span class="badge bg-warning">Pending Payment</span>
                                @else
                                <span class="badge bg-secondary">Not Eligible</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Review Submission</h6>
                        @if($selectedSubmission->reviewed_at)
                        <!-- Existing Review -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-check-line me-2 text-success"></i>
                                <strong>Reviewed on {{ $selectedSubmission->reviewed_at->format('M d, Y H:i') }}</strong>
                            </div>
                            @if($selectedSubmission->review)
                            <p class="mb-1"><strong>Review:</strong></p>
                            <p class="mb-0">{{ $selectedSubmission->review }}</p>
                            @endif
                            @if($selectedSubmission->review_reason)
                            <p class="mb-0 mt-2">
                                <strong>Reason:</strong>
                                @switch($selectedSubmission->review_reason)
                                @case(1)
                                <span class="badge bg-success">Approved</span>
                                @break
                                @case(2)
                                <span class="badge bg-warning">Needs Revision</span>
                                @break
                                @case(3)
                                <span class="badge bg-danger">Rejected</span>
                                @break
                                @default
                                <span class="badge bg-secondary">Unknown</span>
                                @endswitch
                            </p>
                            @endif

                            @if($selectedSubmission->review_reason == 2)
                            <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                <h6 class="text-warning mb-2">
                                    <i class="ri-error-warning-line me-2"></i>
                                    Revision Required
                                </h6>
                                <p class="mb-2">This submission has been marked for revision. The worker should review the feedback and resubmit their work.</p>
                                <button wire:click="resetSubmissionForRevision({{ $selectedSubmission->id }})" class="btn btn-warning btn-sm">
                                    <i class="ri-refresh-line me-1"></i> Reset for Revision
                                </button>
                            </div>
                            @endif
                        </div>
                        @else
                        <!-- Review Form -->
                        <form wire:submit="reviewSubmission">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="reviewReason" class="form-label">Review Decision</label>
                                    <select id="reviewReason" wire:model="reviewReason" class="form-select @error('reviewReason') is-invalid @enderror" required>
                                        <option value="">Select decision</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Needs Revision</option>
                                        <option value="3">Reject</option>
                                    </select>
                                    @error('reviewReason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="reviewText" class="form-label">Review Comments</label>
                                    <textarea id="reviewText" wire:model="reviewText" rows="4" class="form-control @error('reviewText') is-invalid @enderror" placeholder="Provide feedback on the submission..."></textarea>
                                    @error('reviewText') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="reviewSubmission">
                                        <span wire:loading.remove wire:target="reviewSubmission">
                                            <i class="ri-send-plane-line me-1"></i> Submit Review
                                        </span>
                                        <span wire:loading wire:target="reviewSubmission">
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Submitting...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if(!$selectedSubmission->paid_at && $selectedSubmission->task_worker)
                    <div class="text-center">
                        @if($selectedSubmission->completed_at)
                        <button wire:click="disbursePaymentFromSubmission({{ $selectedSubmission->id }})" class="btn btn-success" wire:loading.attr="disabled" wire:target="disbursePaymentFromSubmission">
                            <span wire:loading.remove wire:target="disbursePaymentFromSubmission">
                                <i class="ri-money-dollar-circle-line me-1"></i> Disburse Payment
                            </span>
                            <span wire:loading wire:target="disbursePaymentFromSubmission">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Processing...
                            </span>
                        </button>
                        @else
                        <div class="alert alert-warning mb-0">
                            <i class="ri-information-line me-2"></i>
                            Submission must be approved before payment can be disbursed.
                        </div>
                        @endif
                    </div>
                    @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('openInviteModal', () => {
            new bootstrap.Modal(document.getElementById('inviteModal')).show();
        });

        Livewire.on('closeInviteModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('inviteModal')).hide();
        });

        Livewire.on('openDisburseModal', () => {
            new bootstrap.Modal(document.getElementById('disburseModal')).show();
        });

        Livewire.on('closeDisburseModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('disburseModal')).hide();
        });

        Livewire.on('openWorkerDetailsModal', () => {
            new bootstrap.Modal(document.getElementById('workerDetailsModal')).show();
        });

        Livewire.on('closeWorkerDetailsModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('workerDetailsModal')).hide();
        });

        Livewire.on('openSubmissionDetailsModal', () => {
            new bootstrap.Modal(document.getElementById('submissionDetailsModal')).show();
        });

        Livewire.on('closeSubmissionDetailsModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('submissionDetailsModal')).hide();
        });
    });
</script>
@endpush