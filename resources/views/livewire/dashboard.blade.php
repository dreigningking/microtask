<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Dashboard</h1>
                    <p class="mb-0">Welcome back, John! Here's your dual-role activity overview.</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
           
            <div class="row mb-4">
                <div class="col-lg-12 mb-4">
                    <div class="dashboard-card card">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-megaphone"></i> Announcements</h6>
                        </div>
                        <div class="card-body">
                            <div class="announcement-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-warning">Maintenance Scheduled</h6>
                                    <small class="text-muted">1 week ago</small>
                                </div>
                                <p class="mb-0 small text-muted">Scheduled maintenance on March 10th from 2-4 AM UTC. Platform may be briefly unavailable.</p>
                            </div>
                            <div class="announcement-item border rounded p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-success">Welcome Bonus Extended</h6>
                                    <small class="text-muted">2 weeks ago</small>
                                </div>
                                <p class="mb-0 small text-muted">New users now receive $25 welcome bonus instead of $10. Limited time offer!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Creator Dashboard (Left Column) -->
                <div class="col-lg-6">
                    <div class="dashboard-card card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-person-plus text-primary"></i> Creator Dashboard</h5>

                        </div>
                        <div class="card-body">
                            <!-- Creator Statistics -->
                            <div class="row g-3 mb-4">
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-list-check text-primary fs-1 mb-2"></i>
                                        <h3>{{ $creatorStats['posted'] ?? 15 }}</h3>
                                        <p class="mb-0">Tasks Posted</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                                        <h3>{{ $creatorStats['completed'] ?? 8 }}</h3>
                                        <p class="mb-0">Completed</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-hourglass-split text-warning fs-1 mb-2"></i>
                                        <h3>{{ $creatorStats['in_progress'] ?? 50 }}</h3>
                                        <p class="mb-0">In Progress</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-people text-info fs-1 mb-2"></i>
                                        <h3>{{ $creatorStats['rating'] ?? 4 }}</h3>
                                        <p class="mb-0">Active Workers</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-clock-history text-orange fs-1 mb-2"></i>
                                        <h3>{{ $creatorStats['pending_review'] ?? 4 }}</h3>
                                        <p class="mb-0">Review Pending</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-cash-coin text-danger fs-1 mb-2"></i>
                                        <h3>${{ $creatorStats['refundable'] ?? 2 }}</h3>
                                        <p class="mb-0">Refundables</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Creator Actions -->
                            <div class="d-grid gap-2 mb-3">
                                <a href="#" class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-2"></i>Create New Task
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="bi bi-gear me-2"></i>Manage Posted Tasks
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="bi bi-people me-2"></i>View Applications
                                </a>
                            </div>

                            <!-- Creator Quick Insights -->
                            <div class="border rounded p-3">
                                <h6 class="mb-2">Creator Insights</h6>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Avg. Completion Time:</span>
                                    <strong>2.5 days</strong>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Success Rate:</span>
                                    <strong>85%</strong>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span>Active Workers:</span>
                                    <strong>12</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Worker Dashboard (Right Column) -->
                <div class="col-lg-6">
                    <div class="dashboard-card card h-100">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-person-check text-success"></i> Worker Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <!-- Worker Statistics -->
                            <div class="row g-3 mb-4">
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-file-earmark-arrow-up text-info fs-1 mb-2"></i>
                                        <h3>{{ $workerStats['applied'] ?? 23 }}</h3>
                                        <p class="mb-0">Applied Tasks</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                                        <h3>{{ $workerStats['completed'] ?? 18 }}</h3>
                                        <p class="mb-0">Completed</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-lightning text-warning fs-1 mb-2"></i>
                                        <h3>{{ $workerStats['active'] ?? 0 }}</h3>
                                        <p class="mb-0">Active</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-send-fill text-success fs-1 mb-2"></i>
                                        <h3>{{ $workerStats['submissions'] }}</h3>
                                        <p class="mb-0">Submissions</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-hourglass-split text-orange fs-1 mb-2"></i>
                                        <h3>{{ $workerStats['pending_review'] }}</h3>
                                        <p class="mb-0">Pending Review</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-x-circle text-danger fs-1 mb-2"></i>
                                        <h3>{{ $workerStats['rejected'] ?? 0 }}</h3>
                                        <p class="mb-0">Rejected</p>
                                    </div>
                                </div>


                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button class="btn btn-info text-white">
                                    <i class="bi bi-search me-2"></i>Browse Tasks
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-clock me-2"></i>Track Applications
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-card-list me-2"></i>Task History
                                </button>
                            </div>

                            <!-- Worker Quick Insights -->
                            <div class="border rounded p-3">
                                <h6 class="mb-2">Worker Insights</h6>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Avg. Task Value:</span>
                                    <strong>$49</strong>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Response Time:</span>
                                    <strong>1.2 hours</strong>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span>Specialization:</span>
                                    <strong>Design & Writing</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Sections Row -->
            <div class="row mb-4">
                <!-- Subscription Status -->
                <div class="col-lg-12">
                    <!-- Booster Subscriptions -->
                    <div class="dashboard-card card mb-4 position-relative">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-rocket"></i> Active Subscriptions</h5>
                            <div class="text-end">
                                <a href="subscriptions.html" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="bi bi-gear"></i> Manage
                                </a>
                                <a href="boosters.html" class="btn btn-primary btn-sm">
                                    <i class="bi bi-arrow-up"></i> Upgrade
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                <div class="d-flex gap-3" style="min-width: min-content; padding-bottom: 0.5rem;">
                                    @forelse($activeSubscriptions as $subscription)
                                    <!-- Subscription Card -->
                                    <div style="flex: 0 0 calc(100% - 1rem); min-width: 300px;">
                                        <div class="border rounded p-3 h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0"><i class="bi bi-person-check text-success"></i> {{ $subscription['booster']['name'] ?? 'Subscription' }}</h6>
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                            <p class="text-muted small mb-2">{{ $subscription['booster']['description'] ?? 'Active subscription' }}</p>
                                            <div class="progress mb-2" style="height: 6px;">
                                                <div class="progress-bar bg-success" style="width: 70%"></div>
                                            </div>
                                            <div class="d-flex justify-content-between small">
                                                <span>Expires in:</span>
                                                <strong>{{ \Carbon\Carbon::parse($subscription['expires_at'])->diffInDays(now()) }} days</strong>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div style="flex: 0 0 100%; min-width: 300px;">
                                        <div class="border rounded p-3 text-center">
                                            <p class="text-muted small mb-2">No active subscriptions</p>
                                            <a href="#" class="btn btn-primary btn-sm">Browse Plans</a>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">
                            <div class="dashboard-card card">
                                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="bi bi-people"></i> Invitees & Referrals</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inviteesModal">View All & Invite</a>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="border rounded p-3">
                                                <h6 class="mb-3"><i class="bi bi-people-fill text-info"></i> Invitees Summary</h6>
                                                @php
                                                    $acceptedCount = count(array_filter($recentInvitees->toArray(), fn($inv) => $inv->status === 'accepted'));
                                                    $pendingCount = count(array_filter($recentInvitees->toArray(), fn($inv) => $inv->status === 'pending'));
                                                @endphp
                                                <div class="d-flex justify-content-between small mb-2">
                                                    <span>Total Invited:</span>
                                                    <strong>{{ $totalInvitations ?? 0 }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between small mb-2">
                                                    <span>Accepted:</span>
                                                    <strong class="text-success">{{ $acceptedCount }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between small">
                                                    <span>Pending:</span>
                                                    <strong class="text-warning">{{ $pendingCount }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between small">
                                                    <span>Earned from Referrals:</span>
                                                    <strong class="text-success">${{ $referralEarnings ?? 0 }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded p-3">
                                                <h6 class="mb-3"><i class="bi bi-gift text-success"></i> Earn Info</h6>
                                                <p class="small text-muted mb-2">Earn 10% of their first 10 task earnings!</p>
                                                <div class="d-flex justify-content-between small mb-2">
                                                    <span>Referral Link:</span>
                                                </div>
                                                <div class="input-group input-group-sm mb-2">
                                                    <input type="text" class="form-control" value="https://microtasker.com/ref/{{ $userData->username ?? 'user' }}" id="referralLink" readonly>
                                                    <button class="btn btn-outline-primary" type="button" id="copyLink" title="Copy to clipboard">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($recentInvitees->count() > 0)
                                    <h6 class="mb-2">Recent Invitees</h6>
                                    <div class="list-group list-group-flush">
                                        @foreach($recentInvitees as $invitee)
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <div>
                                                <i class="bi bi-person-plus text-info me-2"></i>
                                                <span class="small">{{ $invitee->email }}</span>
                                            </div>
                                            <small>
                                                @if($invitee->status === 'accepted')
                                                    <span class="badge bg-success">Accepted</span>
                                                @elseif($invitee->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $invitee->status }}</span>
                                                @endif
                                            </small>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-muted small mb-0">No invitees yet. Click "View All & Invite" to get started!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="dashboard-card card">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0"><i class="bi bi-headset"></i> Need Help?</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="support.html" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-question-circle"></i> Help Center
                                        </a>
                                        <a href="support.html?action=new" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-plus-circle"></i> Create Support Ticket
                                        </a>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between small">
                                            <span>Open Tickets:</span>
                                            <strong>2</strong>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>Open Dispute:</span>
                                            <strong>1</strong>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>Recent Response:</span>
                                            <span class="text-success">24 hours ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Invitees Modal -->
    <div class="modal fade" id="inviteesModal" tabindex="-1" aria-labelledby="inviteesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inviteesModalLabel">All Invitees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Invitee Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-center p-3">
                                <h4 class="text-primary mb-1">{{ count($allInvitees) }}</h4>
                                <small class="text-muted">Total Invited</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center p-3">
                                <h4 class="text-success mb-1">{{ count(array_filter($allInvitees->toArray(), fn($inv) => $inv['status'] === 'accepted')) }}</h4>
                                <small class="text-muted">Accepted</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center p-3">
                                <h4 class="text-warning mb-1">{{ count(array_filter($allInvitees->toArray(), fn($inv) => $inv['status'] === 'pending')) }}</h4>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center p-3">
                                <h4 class="text-danger mb-1">{{ count(array_filter($allInvitees->toArray(), fn($inv) => $inv['status'] === 'rejected')) }}</h4>
                                <small class="text-muted">Rejected</small>
                            </div>
                        </div>
                    </div>

                    <!-- Invite Users Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Send Invitations</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit="sendInvitations">
                                <div class="mb-3">
                                    <label class="form-label">Email Addresses</label>
                                    <div id="email-fields">
                                        @foreach($emails as $index => $email)
                                        <div class="input-group mb-2 email-field">
                                            <input type="email"
                                                wire:model="emails.{{ $index }}"
                                                class="form-control form-control-sm @error('emails.' . $index) is-invalid @enderror"
                                                placeholder="Enter email address"
                                                value="{{ $email }}">
                                            @if(count($emails) > 1)
                                            <button type="button" wire:click="removeEmailField({{ $index }})" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                            @endif
                                            @error('emails.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" wire:click="addEmailField" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i> Add Another Email
                                    </button>
                                </div>

                                @if (session()->has('message'))
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @error('general')
                                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror

                                <button type="submit" wire:loading.attr="disabled" wire:target="sendInvitations" class="btn btn-primary btn-sm">
                                    <span wire:loading.class="d-none" wire:target="sendInvitations" class="d-inline-flex">
                                        <i class="bi bi-send-fill me-1"></i> Send Invitations
                                    </span>
                                    <span wire:loading.class="d-inline-flex" wire:target="sendInvitations" class="" style="display: none;">
                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                        Sending...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Invitees Table -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Invitee List</h6>
                        </div>
                        <div class="card-body table-responsive">
                            @if(count($allInvitees) > 0)
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Invited Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allInvitees as $invitee)
                                    <tr>
                                        <td>
                                            <small>{{ $invitee->email }}</small>
                                        </td>
                                        <td>
                                            @if($invitee->status === 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                            @elseif($invitee->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @else
                                            <span class="badge bg-secondary">{{ ucfirst($invitee->status) }}</span>
                                            @endif
                                        </td>
                                        <td><small>{{ $invitee->created_at->format('M d, Y') }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-muted text-center py-4">No invitees yet. Send your first invitation above!</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
