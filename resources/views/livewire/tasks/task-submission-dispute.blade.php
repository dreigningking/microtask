<div>
    <!-- Dispute Header -->
    <section class="dispute-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">

                    <div class="d-flex align-items-center mb-2">
                        @if($dispute->resolved_at)
                        <span class="badge bg-success me-2">Resolved</span>
                        @else
                        <span class="badge bg-warning me-2">Under Review</span>
                        @endif
                        <span class="badge bg-dark me-2 text-light">Task: #{{ $taskSubmission->task_id }}</span>
                        <span class="badge bg-light text-dark">Submission: #{{ $taskSubmission->id }}</span>
                    </div>
                    <h1 class="h3 mb-2">Dispute Number: #{{ $taskSubmission->dispute->id }}</h1>
                    <p class="mb-0">Desired Outcome: {{ $taskSubmission->dispute->outcome }}</p>
                </div>
                <div class="col-md-4 d-flex justify-content-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.html" class="text-white">Dashboard</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Dispute Resolution</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Left Column - Dispute Details & Communication -->
                <div class="col-lg-8">
                    <!-- Task Details -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Task Details</h5>
                        </div>
                        <div class="card-body">
                            <h6>Task Title</h6>
                            <p>{{ $task->title }}</p>

                            <h6>Task Description</h6>
                            <p>{{ $task->description }}</p>

                            @if(is_array($task->requirements) && count($task->requirements))
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>Task Requirements</h6>
                                    <ul class="list-unstyled">
                                        @foreach($task->requirements as $requirement)
                                        <li><i class="bi bi-check-circle text-success me-2"></i> {{ $requirement }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif


                            @if($task->template_data && is_array($task->template_data) && count($task->template_data))
                            <div class="mt-4">
                                <h6>Task Fields</h6>
                                @foreach($task->template_data as $field)
                                <p class="">
                                <h6 class="fw-medium mb-2">{{ $field['title'] ?? 'Field' }}</h6>
                                @if(isset($field['type']) && $field['type'] === 'file')
                                @if(!empty($field['value']))
                                <a href="{{ asset('storage/' . $field['value']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download me-1"></i> {{ basename($field['value']) }}
                                </a>
                                @else
                                <span class="text-muted small">No file uploaded</span>
                                @endif
                                @else
                                @if(is_array($field['value'] ?? null))
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($field['value'] as $item)
                                    <span class="badge bg-light text-dark">{{ $item }}</span>
                                    @endforeach
                                </div>
                                @else
                                <p class="mb-0 small">{{ $field['value'] ?? 'Not provided' }}</p>
                                @endif
                                @endif
                                </p>
                                @endforeach
                            </div>
                            @endif


                            <hr>

                            <div class="mt-4">
                                <h6>Parties Involved in this Dispute</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <img src="https://placehold.co/60" alt="Poster" class="rounded-circle me-3">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $task->user->username }}</h6>
                                                <div class="text-warning small">
                                                    <span class="text-muted">{{ $task->user->tasks->count() }} tasks posted</span>
                                                    <span class="text-muted">• {{ $task->user->taskSubmissions->where('accepted',true)->count() }} tasks completed</span>
                                                </div>
                                                <p class="text-muted mb-0">Task Poster</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <img src="https://placehold.co/60" alt="Worker" class="rounded-circle me-3">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $taskSubmission->user->username }}</h6>
                                                <div class="text-warning small">
                                                    <span class="text-muted">{{ $taskSubmission->taskWorker->user->tasks->count() }} tasks posted</span>
                                                    <span class="text-muted">• {{ $taskSubmission->taskWorker->user->taskSubmissions->where('accepted',true)->count() }} tasks completed</span>
                                                </div>
                                                <p class="text-muted mb-0">Worker</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Communication Thread -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Dispute Communication</h5>
                        </div>
                        <div class="card-body">
                            <!-- Response Form -->
                            <div class="mb-4">
                                <form wire:submit.prevent="submitDisputeResponse">
                                    <div class="mb-3">
                                        <label class="form-label">Add to Discussion</label>
                                        <textarea class="form-control" wire:model="disputeMessage" rows="3" placeholder="Type your response..."></textarea>
                                        @error('disputeMessage') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Add Evidence (Optional)</label>
                                        <input type="file" class="form-control" wire:model="disputeAttachments" multiple>
                                        <div class="form-text">Upload additional screenshots or files to support your case</div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <button type="submit" wire:target="submitDisputeResponse" class="btn btn-primary" wire:loading.attr="disabled">
                                            <span wire:loading.class="d-none" wire:target="submitDisputeResponse" class="d-inline-flex align-items-center justify-content-center">
                                                Send Response
                                            </span>
                                            <span wire:loading.class="d-inline-flex" wire:target="submitDisputeResponse" class="align-items-center justify-content-center" style="display: none;">
                                                Sending...
                                            </span>
                                        </button>


                                    </div>
                                </form>
                            </div>

                            <!-- Messages -->
                            <div class="messages-container" style="max-height: 400px; overflow-y: auto;">
                                @forelse($disputeComments as $comment)
                                <div class="message-card {{ $comment->user_id == Auth::id() ? 'message-user' : 'message-other' }} p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>{{ $comment->user->username }}</strong>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-2">{{ $comment->body }}</p>
                                    @if($comment->attachments)
                                    <div class="evidence-section">
                                        <h6>Attachments</h6>
                                        <div class="d-flex gap-3">
                                            @foreach($comment->attachments as $attachment)
                                            @php
                                            $extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']);
                                            @endphp
                                            <a href="{{ asset($attachment) }}" @if($isImage) target="_blank" @else download @endif class="btn btn-outline-primary btn-sm">
                                                @if($isImage)
                                                <i class="bi bi-image me-1"></i>
                                                @else
                                                <i class="bi bi-file-earmark-text me-1"></i>
                                                @endif
                                                {{ Str::limit(basename($attachment), 15) }}
                                            </a>


                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <div class="text-center text-muted">No messages yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('livewire:loaded', function() {
                            new Choices('#staffSelect', {
                                searchEnabled: true,
                                itemSelectText: '',
                                placeholder: true,
                                placeholderValue: 'Select a staff member...'
                            });
                        });
                    </script>
                </div>

                <!-- Right Column - Timeline & Actions -->
                <div class="col-lg-4">

                    <div class="card mb-4">
                        <div class="card-header bg-transparent d-flex justify-content-between">
                            <h6 class="mb-0">Disputed Submission </h6>
                            <a href="{{ route('explore.task',$taskSubmission->task) }}" target="_blank" class="dont_decorate">View Task <i class="bi bi-arrow-up-right-circle"></i></a>
                        </div>
                        <div class="card-body">
                            <h6>Submitted Data</h6>
                            <div class="submission-preview border rounded p-3 bg-light mb-3">
                                @if($taskSubmission->submission_details && is_array($taskSubmission->submission_details))
                                @foreach($taskSubmission->submission_details as $field)
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <h6 class="fw-medium">{{ $field['title'] }}</h6>
                                    </div>
                                    <div class="col-12">
                                        @if($field['type'] === 'file')
                                        @if(!empty($field['value']))
                                        <a href="{{ asset('storage/' . $field['value']) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-download me-1"></i> {{ Str::limit(basename($field['value']), 15) }}
                                        </a>
                                        @else
                                        <span class="text-muted small">No file uploaded</span>
                                        @endif
                                        @elseif(is_array($field['value'] ?? null))
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($field['value'] as $item)
                                            <span class="badge bg-light text-dark">{{ $item }}</span>
                                            @endforeach
                                        </div>
                                        @else
                                        <div class="bg-light rounded">{{ $field['value'] ?? 'Not provided' }}</div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="alert alert-info">
                                    <i class="ri-information-line me-2"></i>
                                    No submission data available
                                </div>
                                @endif
                            </div>
                            <h6>Submission Review</h6>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> {{ $taskSubmission->review_body }}
                            </div>
                            

                        </div>
                    </div>

                    <!-- Dispute Timeline -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Dispute Timeline</h6>
                        </div>
                        <div class="card-body">
                            <div class="dispute-timeline">
                                <div class="timeline-item">
                                    <strong>Dispute Raised</strong>
                                    <p class="text-muted mb-0 small">{{ $dispute->outcome }}</p>
                                    <small class="text-muted">{{ $dispute->created_at->format('M d, Y')}} • {{$dispute->created_at->format('h:i A') }}</small>
                                </div>
                                @if($dispute->comments->where('isByAdmin',true)->count())
                                <div class="timeline-item">
                                    <strong>Under Review</strong>
                                    <p class="text-muted mb-0 small">Admin team started reviewing the case</p>
                                    <small class="text-muted">{{ $dispute->comments->firstWhere('isByAdmin',true)->created_at->format('M d, Y')}} • {{$dispute->comments->firstWhere('isByAdmin',true)->created_at->format('h:i A') }}</small>
                                </div>
                                @endif
                                @if($dispute->resolved_at)
                                <div class="timeline-item">
                                    <strong>Dispute Resolved</strong>
                                    <p class="text-muted mb-0 small">Resolution: {{ $dispute->resolution_instruction }}</p>
                                    <small class="text-muted">{{ $dispute->resolved_at->format('M d, Y')}} • {{$dispute->resolved_at->format('h:i A') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- Admin Actions (Visible only to admin) -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Admin Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <!-- <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-download"></i> Download All Files
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-clock"></i> Extend Response Time
                                </button> -->
                                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#resolveModal">
                                    <i class="bi bi-check-circle"></i> Resolve Dispute
                                </button>
                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#escalationModal">
                                    <i class="bi bi-x-circle"></i> Escalate to Staff
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Resolve Dispute Modal (Admin Only) -->
    <div wire:ignore class="modal fade" id="resolveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resolve Dispute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="resolveForm" wire:submit.prevent="resolveDispute">
                        <div class="mb-3">
                            <label class="form-label">Final Resolution</label>
                            <select class="form-select" wire:model="resolution">
                                <option value="">Select resolution</option>
                                <option value="full-payment">Full payment to worker</option>
                                <option value="partial-payment">Partial payment to worker</option>
                                <option value="resubmission">Full refund to poster</option>
                            </select>
                            @error('resolution') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Resolution Details</label>
                            <textarea class="form-control" rows="4" placeholder="Explain the decision and reasoning..." wire:model="resolutionDetails"></textarea>
                            @error('resolutionDetails') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount to Worker</label>
                            <div class="input-group">
                                <input type="number" class="form-control" wire:model="amountToWorker" min="0" max="100">
                                <span class="input-group-text">%</span>
                            </div>
                            <div class="form-text">Enter as percentage of the task submission budget</div>
                            @error('amountToWorker') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="resolveForm" class="btn btn-success" wire:target="resolveDispute" wire:loading.attr="disabled">
                        <span wire:loading.class="d-none" wire:target="resolveDispute">Finalize Resolution</span>
                        <span wire:loading.class="d-inline-flex" wire:target="resolveDispute" style="display: none;">Resolving...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore class="modal fade" id="escalationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Escalate Dispute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="escalationForm" wire:submit.prevent="escalateDispute">
                        <div class="mb-3">
                            <label class="form-label">Select Staff</label>
                            <select class="form-select" id="staffSelect" wire:model="selectedStaff">
                                <option value=""></option>
                                @foreach($staff as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->username }})</option>
                                @endforeach
                            </select>
                            @error('selectedStaff') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Personal note</label>
                            <textarea class="form-control" rows="3" placeholder="Personal note to staff" wire:model="escalationNote"></textarea>
                            @error('escalationNote') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </form>
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="escalationForm" class="btn btn-success" wire:target="escalateDispute" wire:loading.attr="disabled">
                        <span wire:loading.class="d-none" wire:target="escalateDispute">Escalate</span>
                        <span wire:loading.class="d-inline-flex" wire:target="escalateDispute" style="display: none;">Escalating...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>