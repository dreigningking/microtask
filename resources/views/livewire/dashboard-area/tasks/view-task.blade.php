<div class="content-wrapper">
    @if ($taskWorker && $taskWorker->task)
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">{{ $taskWorker->task->title }}</h1>
                <p class="text-muted mb-0">Posted {{ $taskWorker->task->created_at->diffForHumans() }}</p>
            </div>
            <div class="d-flex gap-2">
                @if($taskWorker->completed_at)
                <span class="badge bg-success">Completed</span>
                @elseif($taskWorker->submitted_at)
                <span class="badge bg-warning">Submitted</span>
                @elseif($taskWorker->accepted_at)
                <span class="badge bg-primary">In Progress</span>
                @elseif($taskWorker->saved_at)
                <span class="badge bg-info">Saved</span>
                @else
                <span class="badge bg-secondary">Pending</span>
                @endif
                <span class="badge bg-success fs-6">{{ $taskWorker->task->user->country->currency_symbol ?? '$' }}{{ number_format($taskWorker->task->budget_per_person, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Task Status</h6>
                        <span class="bg-primary bg-opacity-10 rounded-circle p-2">
                            @if($taskWorker->completed_at)
                            <i class="ri-check-double-line text-success"></i>
                            @elseif($taskWorker->submitted_at)
                            <i class="ri-send-plane-line text-warning"></i>
                            @elseif($taskWorker->accepted_at)
                            <i class="ri-time-line text-primary"></i>
                            @else
                            <i class="ri-clock-line text-secondary"></i>
                            @endif
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0">
                        @if($taskWorker->completed_at)
                        Completed
                        @elseif($taskWorker->submitted_at)
                        Submitted
                        @elseif($taskWorker->accepted_at)
                        In Progress
                        @elseif($taskWorker->saved_at)
                        Saved
                        @else
                        Pending
                        @endif
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Budget</h6>
                        <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="ri-money-dollar-circle-line text-success"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $taskWorker->task->user->country->currency_symbol ?? '$' }}{{ number_format($taskWorker->task->budget_per_person, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Time Required</h6>
                        <span class="bg-info bg-opacity-10 rounded-circle p-2"><i class="ri-time-line text-info"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $requiredTime }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">People Remaining</h6>
                        <span class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="ri-user-line text-warning"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">
                        @php
                        $acceptedWorkersCount = $taskWorker->task->workers->whereNotNull('accepted_at')->count();
                        $peopleRemaining = $taskWorker->task->number_of_people - $acceptedWorkersCount;
                        @endphp
                        {{ $peopleRemaining > 0 ? $peopleRemaining : 'None' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Task Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Task Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Description</h6>
                        <p class="mb-0">{{ $taskWorker->task->description }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Task Creator</h6>
                            <p class="fw-semibold mb-0">{{ $taskWorker->task->user->username }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Platform</h6>
                            <p class="fw-semibold mb-0">{{ $taskWorker->task->platform->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Template</h6>
                            <p class="fw-semibold mb-0">{{ $taskWorker->task->template->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Expected Time</h6>
                            <p class="fw-semibold mb-0">{{ $requiredTime }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Accepted Date</h6>
                            <p class="fw-semibold mb-0">{{ $taskWorker->accepted_at ? $taskWorker->accepted_at->format('M d, Y H:i') : 'Not accepted yet' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Multiple Submissions</h6>
                            <p class="fw-semibold mb-0">
                                @if($taskWorker->task->allows_multiple_submissions ?? false)
                                <span class="badge bg-success">Allowed</span>
                                @else
                                <span class="badge bg-secondary">Not Allowed</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($taskWorker->task->files)
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Attached Files</h6>
                        <div class="row g-2">
                            @foreach($taskWorker->task->files as $file)
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

                    @if($taskWorker->task->requirements)
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Requirements</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($taskWorker->task->requirements as $requirement)
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

            <!-- Submission Form -->
            @if (!empty($submissionFields) && $taskWorker && $taskWorker->accepted_at)
            @if(($taskWorker->task->allows_multiple_submissions ?? false) || $submissions->count() === 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Submission Requirements</h5>
                </div>
                <div class="card-body">
                    <form wire:submit="submitTask">
                        <div class="row g-3">
                            @foreach($submissionFields as $index => $field)
                            <div class="col-12">
                                <label for="submission-field-{{ $index }}" class="form-label">{{ $field['title'] }}</label>

                                @if ($field['type'] === 'text')
                                <input type="text" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'textarea')
                                <textarea id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" rows="4" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror"></textarea>
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'number')
                                <input type="number" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'email')
                                <input type="email" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'url')
                                <input type="url" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'date')
                                <input type="date" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'time')
                                <input type="time" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'select')
                                <select id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="form-select @error('submittedData.' . $field['name']) is-invalid @enderror">
                                    <option value="">Select {{ $field['title'] }}</option>
                                    @foreach($field['options'] ?? [] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'checkbox')
                                <div class="mt-2">
                                    @foreach($field['options'] ?? [] as $option)
                                    <div class="form-check">
                                        <input type="checkbox"
                                            id="submission-field-{{ $index }}-{{ Str::slug($option) }}"
                                            wire:model="submittedData.{{ $field['name'] }}"
                                            value="{{ $option }}"
                                            class="form-check-input @error('submittedData.' . $field['name']) is-invalid @enderror">
                                        <label for="submission-field-{{ $index }}-{{ Str::slug($option) }}" class="form-check-label">{{ $option }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'radio')
                                <div class="mt-2">
                                    @foreach($field['options'] ?? [] as $option)
                                    <div class="form-check">
                                        <input type="radio"
                                            id="submission-field-{{ $index }}-{{ Str::slug($option) }}"
                                            wire:model="submittedData.{{ $field['name'] }}"
                                            value="{{ $option }}"
                                            class="form-check-input @error('submittedData.' . $field['name']) is-invalid @enderror">
                                        <label for="submission-field-{{ $index }}-{{ Str::slug($option) }}" class="form-check-label">{{ $option }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @elseif ($field['type'] === 'file')
                                <input type="file"
                                    id="submission-field-{{ $index }}"
                                    wire:model.live="submittedData.{{ $field['name'] }}"
                                    class="form-control @error('submittedData.' . $field['name']) is-invalid @enderror">
                                @error('submittedData.' . $field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @endif
                                @if (isset($field['description']))
                                <div class="form-text">{{ $field['description'] }}</div>
                                @endif
                            </div>
                            @endforeach
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ri-send-plane-line me-1"></i> Submit Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="ri-check-double-line display-4 text-success mb-3"></i>
                    <h5 class="text-success">You have submitted</h5>
                    <p class="text-muted">Multiple submissions are not allowed for this task.</p>
                </div>
            </div>
            @endif
            @elseif (!empty($submissionFields) && (!$taskWorker || !$taskWorker->accepted_at))
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="ri-lock-line display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">Start Task to Submit</h5>
                    <p class="text-muted">You need to start this task before you can submit your work.</p>
                    <button wire:click="startTask" class="btn btn-primary">
                        <i class="ri-play-line me-1"></i> Start Task
                    </button>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="ri-file-text-line display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No Submission Requirements</h5>
                    <p class="text-muted">No specific submission requirements provided for this task template.</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Invite People -->
            @if ($peopleRemaining > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Invite People</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning mb-3">
                        <h6 class="alert-heading">Want to help others earn?</h6>
                        <p class="mb-0">There are still {{ $peopleRemaining }} spots left for this task. Share it with your friends and earn a commission when they complete it!</p>
                    </div>
                    <button wire:click="openInviteModal" class="btn btn-warning w-100">
                        <i class="ri-share-line me-1"></i> Invite People to do Task
                    </button>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if (!$taskWorker || !$taskWorker->accepted_at)
                        <!-- User hasn't started the task yet -->
                        <button wire:click="startTask" class="btn btn-primary">
                            <i class="ri-play-line me-1"></i> Start Task
                        </button>
                        @elseif ($taskWorker->rejected_at)
                        <!-- Worker has been rejected -->
                        <div class="alert alert-danger mb-0">
                            <i class="ri-error-warning-line me-1"></i>
                            You have been rejected from this task and cannot submit work.
                        </div>
                        @elseif ($taskWorker->completed_at)
                        <!-- Task has been completed -->
                        <button wire:click="reviewTask" class="btn btn-success">
                            <i class="ri-star-line me-1"></i> Review Task
                        </button>
                        @else
                        <!-- Task is in progress -->
                        <button wire:click="cancelTask" class="btn btn-outline-danger"
                            onclick="return confirm('Are you sure you want to cancel this task? All submissions will be deleted.')">
                            <i class="ri-close-line me-1"></i> Cancel Task
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission History -->
        @if($taskWorker && $submissions->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-history-line me-2 text-primary"></i>
                    Submission History
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Submission #</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $index => $submission)
                            <tr>
                                <td>
                                    <div class="fw-medium">Submission {{ $submissions->count() - $index }}</div>
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
                                    @elseif($submission->paid_at)
                                    <span class="badge bg-primary">Paid</span>
                                    @else
                                    <span class="badge bg-secondary">{{ $submission->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="viewSubmission({{ $submission->id }})">
                                        <i class="ri-eye-line me-1"></i> View
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

        <!-- Task Review Section -->
        @if($taskWorker && $taskWorker->completed_at)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-star-line me-2 text-warning"></i>
                    Task Review
                </h5>
            </div>
            <div class="card-body">
                @if($taskWorker->task_rating && $taskWorker->task_review)
                <!-- Existing Review -->
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=$taskWorker->task_rating)
                                <i class="ri-star-fill text-warning"></i>
                                @else
                                <i class="ri-star-line text-muted"></i>
                                @endif
                                @endfor
                        </div>
                        <span class="fw-medium">{{ $taskWorker->task_rating }}/5 stars</span>
                    </div>
                    <p class="mb-0">{{ $taskWorker->task_review }}</p>
                    <small class="text-muted">Reviewed on {{ $taskWorker->updated_at->format('M d, Y') }}</small>
                </div>
                @else
                <!-- Review Form -->
                <form wire:submit="reviewTask">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="d-flex align-items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                class="btn btn-link p-0 me-1"
                                wire:click="setRating({{ $i }})">
                                @if($i <= $taskRating)
                                    <i class="ri-star-fill text-warning fs-4"></i>
                                    @else
                                    <i class="ri-star-line text-muted fs-4"></i>
                                    @endif
                                    </button>
                                    @endfor
                                    <span class="ms-2 fw-medium">{{ $taskRating }}/5 stars</span>
                        </div>
                        @error('taskRating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="taskReview" class="form-label">Review</label>
                        <textarea id="taskReview"
                            wire:model="taskReview"
                            rows="4"
                            class="form-control @error('taskReview') is-invalid @enderror"
                            placeholder="Share your experience with this task..."></textarea>
                        @error('taskReview') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="ri-send-plane-line me-1"></i> Submit Review
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif

        
    </div>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="ri-error-warning-line display-4 text-muted mb-3"></i>
            <h4 class="text-muted mb-2">Task Not Found or Accessible</h4>
            <p class="text-muted mb-4">The task you are trying to view does not exist or you do not have permission to view it.</p>
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                <i class="ri-arrow-left-line me-1"></i> Go to My Tasks
            </a>
        </div>
    </div>
    @endif
    <!-- Invite Modal -->
    <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inviteModalLabel">Invite People to do Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inviteEmail" class="form-label">Email Addresses</label>
                        <textarea id="inviteEmail" wire:model.live="inviteEmail" rows="3" placeholder="Enter one or more emails, separated by commas or new lines" class="form-control"></textarea>
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
    });
</script>
@endpush