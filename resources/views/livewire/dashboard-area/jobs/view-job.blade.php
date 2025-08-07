<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">{{ $task->title }}</h1>
                <p class="text-muted mb-0">Posted {{ $task->created_at->diffForHumans() }}</p>
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
                    <button wire:click="openInviteModal" class="btn btn-primary w-100">
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
                            <th>Submission</th>
                            <th>Payment</th>
                            <th class="text-end">Actions</th>
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
                                @if($worker->completed_at)
                                <span class="badge bg-success">Completed</span>
                                @elseif($worker->submitted_at)
                                <span class="badge bg-warning">Submitted</span>
                                @else
                                <span class="badge bg-info">In Progress</span>
                                @endif
                            </td>
                            <td>
                                @if($worker->submitted_at)
                                <button wire:click="viewSubmission({{ $worker->id }})" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-eye-line me-1"></i> View
                                    </button>
                                @else
                                <span class="text-muted small">No submission yet</span>
                                @endif
                            </td>
                            <td>
                                @if($worker->paid_at)
                                <span class="text-success">
                                    <i class="ri-check-line me-1"></i> Paid
                                    </span>
                                @elseif($worker->submitted_at)
                                <button wire:click="confirmDisburse({{ $worker->id }})" class="btn btn-sm btn-outline-success">
                                    <i class="ri-money-dollar-circle-line me-1"></i> Disburse
                                    </button>
                                @else
                                <span class="text-muted small">Not eligible</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button wire:click="viewWorkerDetails({{ $worker->id }})" class="btn btn-sm btn-outline-secondary">
                                    <i class="ri-more-2-fill"></i>
                                </button>
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

    <!-- Invite Modal -->
    <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inviteModalLabel">Invite Worker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                    <button type="button" wire:click="inviteUser" class="btn btn-primary">Send Invitation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disburse Confirmation Modal -->
    <div class="modal fade" id="disburseModal" tabindex="-1" aria-labelledby="disburseModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
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

    <!-- Submission Modal -->
    <div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submissionModalLabel">Submission Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedWorker)
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle me-3" src="{{ $selectedWorker->user->profile_photo_url }}" alt="{{ $selectedWorker->user->username }}" width="50" height="50">
                                <div>
                                <h6 class="mb-1">{{ $selectedWorker->user->username }}</h6>
                                <small class="text-muted">Submitted {{ $selectedWorker->submitted_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Accepted At</h6>
                            <p class="mb-0">{{ $selectedWorker->accepted_at ? $selectedWorker->accepted_at->format('M d, Y H:i') : 'Not accepted yet' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Submitted At</h6>
                            <p class="mb-0">{{ $selectedWorker->submitted_at ? $selectedWorker->submitted_at->format('M d, Y H:i') : 'Not submitted yet' }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Submission Data</h6>
                        <div class="row g-3">
                                    @foreach($selectedWorker->submissions as $field => $value)
                            <div class="col-12">
                                <h6 class="fw-medium mb-2">{{ ucfirst($field) }}</h6>
                                            @if(is_array($value))
                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($value as $item)
                                    <span class="badge bg-light text-dark">{{ $item }}</span>
                                                    @endforeach
                                                </div>
                                            @elseif(str_starts_with($value, 'storage/'))
                                <a href="{{ Storage::url(str_replace('storage/', '', $value)) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-file-line me-1"></i> View File
                                                </a>
                                            @else
                                <div class="p-3 bg-light rounded">{{ $value }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(!$selectedWorker->paid_at)
                    <div class="text-center">
                        <button wire:click="confirmDisburse({{ $selectedWorker->id }})" class="btn btn-success">
                            <i class="ri-money-dollar-circle-line me-1"></i> Disburse Payment
                                    </button>
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

    <!-- Worker Details Modal -->
    <div class="modal fade" id="workerDetailsModal" tabindex="-1" aria-labelledby="workerDetailsModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workerDetailsModalLabel">Worker Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedWorker)
                    <div class="text-center mb-4">
                        <img class="rounded-circle mb-3" src="{{ $selectedWorker->user->profile_photo_url }}" alt="{{ $selectedWorker->user->username }}" width="80" height="80">
                        <h5 class="mb-1">{{ $selectedWorker->user->username }}</h5>
                        <p class="text-muted mb-0">{{ $selectedWorker->user->country->name }}</p>
                            </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Joined</h6>
                            <p class="mb-0">{{ $selectedWorker->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Status</h6>
                            <p class="mb-0">
                                            @if($selectedWorker->completed_at)
                                <span class="badge bg-success">Completed</span>
                                            @elseif($selectedWorker->submitted_at)
                                <span class="badge bg-warning">Submitted</span>
                                            @else
                                <span class="badge bg-info">In Progress</span>
                                            @endif
                                        </p>
                                    </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Accepted At</h6>
                            <p class="mb-0">{{ $selectedWorker->accepted_at ? $selectedWorker->accepted_at->format('M d, Y H:i') : 'Not accepted yet' }}</p>
                                    </div>
                                    @if($selectedWorker->submitted_at)
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Submitted At</h6>
                            <p class="mb-0">{{ $selectedWorker->submitted_at->format('M d, Y H:i') }}</p>
                                        </div>
                                    @endif
                                    @if($selectedWorker->paid_at)
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Paid At</h6>
                            <p class="mb-0">{{ $selectedWorker->paid_at->format('M d, Y H:i') }}</p>
                                        </div>
                                    @endif
                            </div>

                            @if($selectedWorker->submitted_at && !$selectedWorker->paid_at)
                    <div class="text-center mt-4">
                        <button wire:click="confirmDisburse({{ $selectedWorker->id }})" class="btn btn-success">
                            <i class="ri-money-dollar-circle-line me-1"></i> Disburse Payment
                                    </button>
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

        Livewire.on('openSubmissionModal', () => {
            new bootstrap.Modal(document.getElementById('submissionModal')).show();
        });

        Livewire.on('closeSubmissionModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('submissionModal')).hide();
        });

        Livewire.on('openWorkerDetailsModal', () => {
            new bootstrap.Modal(document.getElementById('workerDetailsModal')).show();
        });

        Livewire.on('closeWorkerDetailsModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('workerDetailsModal')).hide();
        });
    });
</script>
@endpush