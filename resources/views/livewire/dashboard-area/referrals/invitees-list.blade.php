<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">My Invitees</h1>
                <p class="text-muted mb-0">Track the status of people you've invited to tasks and the platform</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Total Invitees</h6>
                        <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="ri-user-add-line text-primary"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $referrals->total() }}</h3>
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
                    <h3 class="fw-bold mb-0">{{ $referrals->where('invitee_status', 'Completed')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Pending Completion</h6>
                        <span class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="ri-time-line text-warning"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $referrals->where('invitee_status', 'Pending Completion')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Pending Registration</h6>
                        <span class="bg-danger bg-opacity-10 rounded-circle p-2"><i class="ri-user-line text-danger"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $referrals->where('invitee_status', 'Pending Registration')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Invitees Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Invitees List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Email</th>
                            <th>Date Invited</th>
                            <th>Task Invited To</th>
                            <th>Expiry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $ref)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ri-mail-line text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $ref->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $ref->created_at ? $ref->created_at->format('M d, Y H:i') : '-' }}</small>
                                </td>
                                <td>
                                    @if($ref->task_id && $ref->task)
                                        <div class="fw-medium">{{ $ref->task->title }}</div>
                                        <small class="text-muted">Task ID: {{ $ref->task_id }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ref->expire_at)
                                        @php
                                            $expiryDate = \Carbon\Carbon::parse($ref->expire_at);
                                            $isExpired = $expiryDate->isPast();
                                        @endphp
                                        <div class="fw-semibold {{ $isExpired ? 'text-danger' : 'text-success' }}">
                                            {{ $expiryDate->format('M d, Y H:i') }}
                                        </div>
                                        <small class="text-muted">
                                            @if($isExpired)
                                                <i class="ri-time-line me-1"></i>Expired
                                            @else
                                                <i class="ri-time-line me-1"></i>{{ $expiryDate->diffForHumans() }}
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ref->invitee_status === 'Completed')
                                        <span class="badge bg-success">
                                            <i class="ri-check-double-line me-1"></i>Completed
                                        </span>
                                    @elseif($ref->invitee_status === 'Pending Completion')
                                        <span class="badge bg-warning">
                                            <i class="ri-time-line me-1"></i>Pending Completion
                                        </span>
                                    @elseif($ref->invitee_status === 'Pending Registration')
                                        <span class="badge bg-danger">
                                            <i class="ri-user-line me-1"></i>Pending Registration
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="ri-user-line me-1"></i>{{ $ref->invitee_status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="ri-user-add-line display-4 mb-2"></i>
                                    <p>No invitees found</p>
                                    <small class="text-muted">Start inviting people to tasks to see them here</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing <span class="fw-semibold">{{ $referrals->firstItem() }}</span> to <span class="fw-semibold">{{ $referrals->lastItem() }}</span> of <span class="fw-semibold">{{ $referrals->total() }}</span> results
                </div>
                <div>
                    {{ $referrals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

