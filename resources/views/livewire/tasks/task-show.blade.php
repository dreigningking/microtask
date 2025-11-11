<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge @if($task->available) bg-success @else bg-danger @endif me-2">{{$task->available ? 'Active':'Not Available'}}</span>
                        <span class="badge bg-light text-dark">{{ $task->platform->name }}</span>
                    </div>
                    <h1 class="h3 mb-2">{{ $task->title }}</h1>
                    <div class="d-flex align-items-center text-white-50">
                        <span class="me-3"><i class="bi bi-calendar-fill"></i> {{ $task->created_at->format('d-M-Y') }}</span>
                        <span class="me-3"><i class="bi bi-people"></i> {{ $task->taskSubmissions->count() }} submissions received</span>
                        <span><i class="bi bi-clock"></i> {{ !$task->remaining_time ? 'Expired': $task->remaining_time.' left'  }} </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="h2 d-inline d-md-block text-warning mb-1">{{ $task->user->country->currency_symbol.number_format($task->budget_per_submission,2) }}</div>
                    <small class="text-white-50">Per approved submission</small>
                    <div class="d-flex justify-content-md-end">
                        <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('explore')}}">Browse Tasks</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Task Details</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Left Column - Task Details -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Task Details</h5>
                        </div>
                        <div class="card-body">
                            <h6>Description</h6>
                            <p>{{ $task->description }}</p>

                            @if(is_array($task->requirements) && count($task->requirements))
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>Requirements</h6>
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

                            @if($task->files && is_array($task->files) && count($task->files))
                            <div class="mt-4">
                                <h6>Attachments</h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($task->files as $file)
                                    <a href="{{ asset($file['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download me-1"></i> {{ $file['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <hr>

                            <div class="mt-4">
                                <h6>Submissions</h6>
                                <div class="d-flex justify-content-between">
                                    <span>Submissions:</span>
                                    <strong>{{ $task->taskSubmissions->count().'/'.$task->number_of_submissions }}</strong>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <span>Multiple Submissions:</span>
                                    <strong>{{ $task->allow_multiple_submissions ? 'Allowed': 'Not Allowed' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Budget per submission</span>
                                    <strong>{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_submission, 2) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Amount Disbursed</span>
                                    <strong>{{ $task->user->country->currency_symbol }}{{ number_format($task->taskSubmissions->where('accepted', true)->count() * $task->budget_per_submission, 2) }}</strong>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span>Total Budget:</span>
                                    <strong>{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_submission * $task->number_of_submissions, 2) }}</strong>
                                </div>
                            </div>


                            <div class="mt-4">
                                <h6>About the Poster</h6>
                                <div class="d-flex align-items-center">
                                    <img src="https://placehold.co/60" alt="Poster" class="rounded-circle me-3">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $task->user->username }}</h5>
                                        <div class="text-warning mb-2">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <span class="text-muted">(4.0) • 12 tasks posted</span>
                                        </div>
                                        <p class="text-muted mb-0">Member since {{ $task->user->created_at->format('M Y') }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div wire:ignore.self class="accordion mb-4" id="taskAccordion">
                        @if($hasUserSubmitted)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSubmissions">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubmissions" aria-expanded="true" aria-controls="collapseSubmissions">
                                    My Submissions <span class="badge bg-primary ms-2">{{ $userSubmissionCount }} {{ $userSubmissionCount == 1 ? 'submission' : 'submissions' }}</span>
                                </button>
                            </h2>
                            <div id="collapseSubmissions" class="accordion-collapse collapse show" aria-labelledby="headingSubmissions" data-bs-parent="#taskAccordion">
                                <div class="accordion-body">
                                    @foreach($userSubmissions as $index => $submission)
                                    <!-- Submission {{ $index + 1 }} -->
                                    <div class="submission-history-card status-{{ $submission->paid_at ? 'approved' : ($submission->reviewed_at ? ($submission->accepted ? 'approved' : 'rejected') : 'pending') }} p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Submission #{{ $index + 1 }}</h6>
                                                <p class="text-muted mb-2">Submitted: {{ $submission->created_at->format('F j, Y') }}</p>
                                            </div>
                                            @if($submission->paid_at)
                                            <span class="badge bg-success">Approved & Paid</span>
                                            @elseif($submission->reviewed_at)
                                            @if($submission->accepted)
                                            <span class="badge bg-success">Approved</span>
                                            @else
                                            <span class="badge bg-danger">Rejected</span>
                                            @endif
                                            @else
                                            <span class="badge bg-warning">Pending Review</span>
                                            @endif
                                        </div>

                                        @if($submission->paid_at)
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle"></i> This submission was approved and payment has been processed.
                                        </div>
                                        @elseif($submission->reviewed_at && $submission->accepted)
                                        <div class="alert alert-info">
                                            <i class="bi bi-check-circle"></i> This submission was approved. Payment will be processed soon.
                                        </div>
                                        @endif

                                        <p class="mb-2"><strong>Submission Notes:</strong> {{ $submission->submission_details['notes'] ?? 'No notes provided' }}</p>

                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View Submission
                                            </button>
                                            @if(!$submission->reviewed_at)
                                            <button class="btn btn-sm btn-outline-danger" wire:click="withdrawSubmission({{ $submission->id }})">
                                                <i class="bi bi-trash"></i> Withdraw
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <div wire:ignore.self class="accordion-item">
                            <h2 class="accordion-header" id="headingComments">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComments" aria-expanded="false" aria-controls="collapseComments">
                                    Questions and Answers
                                </button>
                            </h2>
                            <div wire:ignore.self id="collapseComments" class="accordion-collapse collapse" aria-labelledby="headingComments" data-bs-parent="#taskAccordion">
                                <div class="accordion-body">
                                    @auth
                                    <div class="mb-4">
                                        <h6>Ask a Question</h6>
                                        <form wire:submit.prevent="askQuestion">
                                            <div class="mb-3">
                                                <textarea class="form-control" rows="3" wire:model.live="question" placeholder="Type your question here..."></textarea>
                                            </div>
                                            @if(isset($similarQuestions) && count($similarQuestions))
                                            <div class="mb-3">
                                                <small class="text-muted">Similar questions:</small>
                                                <div class="list-group">
                                                    @foreach($similarQuestions as $similar)
                                                    <a href="#" class="list-group-item list-group-item-action" onclick="scrollToQuestion({{ $similar->id }})">
                                                        {{ Str::limit($similar->body, 100) }}
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                            <button type="submit" class="btn btn-primary">Ask Question</button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i> You must be logged in to ask questions.
                                    </div>
                                    @endauth

                                    <div class="comments-section">
                                        @forelse($comments ?? [] as $comment)
                                        <div class="comment-item mb-3" id="question-{{ $comment->id }}">
                                            <div class="d-flex">
                                                <img src="{{ $comment->user->avatar ?? 'https://placehold.co/40' }}" alt="User" class="rounded-circle me-3" width="40" height="40">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $comment->user->username }}</h6>
                                                    <p class="mb-2">{{ $comment->body }}</p>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                    @if($comment->children->count() > 0)
                                                    @foreach($comment->children as $answer)
                                                    <div class="ms-4 mt-3 p-3 bg-light rounded">
                                                        <div class="d-flex">
                                                            <img src="{{ $answer->user->avatar ?? 'https://placehold.co/40' }}" alt="User" class="rounded-circle me-3" width="40" height="40">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">{{ $answer->user->username }}</h6>
                                                                <p class="mb-2">{{ $answer->body }}</p>
                                                                <small class="text-muted">{{ $answer->created_at->diffForHumans() }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <p class="text-muted">No questions yet. Be the first to ask!</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-lg-4">
                    @auth
                        <!-- BEFORE APPLYING -->
                        <div class="card mb-4" id="beforeApplySection">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0">Apply for this Task</h5>
                            </div>
                            @if(!$isTaskAvailable)
                            <!-- Task is not available - show reasons -->
                            <div class="card-body">
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>This task is not currently available</strong>
                                </div>

                                @if(count($unavailableReasons) > 0)
                                <div class="mb-3">
                                    <h6>Why you cannot apply:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($unavailableReasons as $reason)
                                        <li class="mb-1"><i class="bi bi-x-circle text-danger me-2"></i> {{ $reason }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-lock me-2"></i>
                                    Apply Not Available
                                </button>
                            </div>
                            @else
                            <!-- Task is available -->
                            @if(!$hasStarted)
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" wire:model.live="agreementAccepted" class="form-check-input" id="agreement">
                                    <label class="form-check-label text-muted" for="agreement" style="text-align: justify;">
                                        I agree to complete this task according to the requirements and submit my work within the estimated time frame.
                                    </label>
                                </div>
                                <button
                                    wire:click="startTask"
                                    class="btn btn-primary w-100 mt-3"
                                    @if(!$agreementAccepted) disabled @endif>
                                    <i class="fas fa-play me-2"></i>
                                    Submit Application
                                </button>
                            </div>
                            @else
                            <div class="card-body">
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle"></i> You have applied for this task! Please submit your work before the deadline.
                                </div>
                                <button class="btn btn-outline-secondary w-100 mt-3">
                                    Withdraw Application
                                </button>
                            </div>
                            @endif
                            @endif
                        </div>


                        <div class="card mb-4">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0">Report Task</h5>
                            </div>
                            <div class="card-body">
                                @if($userReported)
                                <p class="text-muted">
                                    You have reported this task. We are looking into it critically
                                </p>
                                @else
                                <p class="text-muted">Find something inappropriate in this task?
                                    Kindly report to admin immediately</p>

                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#reportTaskModal">
                                    Report
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Your Work - Only show after user has applied -->
                        @if($hasStarted)
                        <div class="card mb-4" id="afterAcceptanceSection">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0">Submit Your Work</h5>
                            </div>
                            <div class="card-body">
                                @if(!$canSubmitMore)
                                <!-- Single submission already made -->
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> You have already submitted your work for this task. Only one submission is allowed.
                                </div>
                                <button class="btn btn-outline-primary w-100" disabled>
                                    <i class="bi bi-check-circle me-2"></i>
                                    Submission Already Made
                                </button>
                                @else
                                <!-- Multiple submissions allowed or first submission -->
                                @if($task->allow_multiple_submissions == 1)
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Multiple submissions are allowed for this task. You can submit different versions or improvements.
                                </div>
                                @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> This is a single submission task. You can only submit once, so please ensure your work is complete.
                                </div>
                                @endif

                                <div class="submission-form-card p-3">
                                    <form id="workSubmissionForm">
                                        <div class="mb-3">
                                            <label class="form-label">Work Submission *</label>
                                            <div class="upload-area p-4 text-center" id="uploadArea">
                                                <i class="bi bi-cloud-arrow-up fs-1 text-muted d-block mb-2"></i>
                                                <p class="mb-2">Drag & drop your files here or click to browse</p>
                                                <small class="text-muted">Max file size: 50MB • Supported formats: ZIP, PDF, JPG, PNG, PSD</small>
                                                <input type="file" class="d-none" id="fileInput" multiple>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="document.getElementById('fileInput').click()">
                                                    Select Files
                                                </button>
                                            </div>
                                            <div id="fileList" class="mt-3"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Submission Notes *</label>
                                            <textarea class="form-control" rows="3" placeholder="Describe what you've delivered and any important information..."></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Links (Optional)</label>
                                            <input type="url" class="form-control mb-2" placeholder="https://example.com">
                                            <input type="url" class="form-control" placeholder="https://example.com">
                                            <div class="form-text">Add links to online work, Google Drive, Dropbox, etc.</div>
                                        </div>

                                        <div class="alert alert-warning">
                                            <h6><i class="bi bi-exclamation-triangle"></i> Before Submitting</h6>
                                            <ul class="mb-0 small">
                                                <li>Ensure all requirements are met</li>
                                                <li>Double-check file formats and sizes</li>
                                                <li>Verify links are accessible</li>
                                                @if($task->allow_multiple_submissions != 1)
                                                <li>You can't edit submission after sending (single submission)</li>
                                                @else
                                                <li>You can submit multiple times if needed</li>
                                                @endif
                                            </ul>
                                        </div>

                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-send"></i> Submit Work
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                    @else
                        <div class="card mb-4" id="signInToApplySection">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0">Apply for this Task</h5>
                            </div>
                            
                            
                            <div class="card-body">
                                <p class="">
                                    You must Sign in to apply for this task.
                                </p>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                    Sign In
                                </a>
                            </div>
                            
                            
                        </div>
                    @endauth

                </div>


            </div>
        </div>
    </section>
    <div class="modal fade" id="reportTaskModal" tabindex="-1" role="dialog" aria-labelledby="reportTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="submitReport">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportTaskModalLabel">Report Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <div class="mb-3">
                            <label for="reportReason" class="form-label">Reason for reporting *</label>
                            <textarea
                                class="form-control"
                                id="reportReason"
                                rows="4"
                                placeholder="Please provide details about why you are reporting this task..."
                                wire:model="reportReason"
                                required>
                            </textarea>
                            @error('reportReason')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit Report</span>
                            <span wire:loading>Submitting...</span>
                        </button>
                    </div>
                </form>
            </div>
        function scrollToQuestion(id) {
            const element = document.getElementById('question-' + id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
        </div>
    </div>
</div>
@push('scripts')
<script>
    // File upload functionality
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadArea.classList.add('dragover');
        }

        function unhighlight() {
            uploadArea.classList.remove('dragover');
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'd-flex justify-content-between align-items-center border rounded p-2 mb-2';
                fileItem.innerHTML = `
                        <div>
                            <i class="bi bi-file-earmark me-2"></i>
                            ${file.name}
                            <small class="text-muted d-block">(${(file.size / (1024 * 1024)).toFixed(2)} MB)</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                fileList.appendChild(fileItem);
            }
        }

        // Form submission
        document.getElementById('workSubmissionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Work submitted successfully! The task poster will review your submission.');
            // In real implementation, this would send data to server
        });
    });
</script>
@endpush