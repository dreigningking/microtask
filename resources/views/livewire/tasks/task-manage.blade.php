<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-2">
                        @if($task->inProgress)
                        <span class="badge bg-dark me-2">Active</span>
                        @elseif($task->isCompleted)
                        <span class="badge bg-success me-2">Completed</span>
                        @elseif($task->isPendingReview)
                        <span class="badge bg-warning me-2">Pending Review</span>
                        @elseif($task->isRejected)
                        <span class="badge bg-danger me-2">Rejected</span>
                        @endif
                        <span class="badge bg-light text-dark">{{ $task->platform->name }}</span>
                    </div>
                    <h1 class="h3 mb-2">{{ $task->title }}</h1>
                    <div class="d-flex align-items-center text-white-50">
                        <span class="me-3"><i class="bi bi-calendar-fill"></i> {{ $task->created_at->format('d-M-Y') }}</span>
                        <span class="me-3"><i class="bi bi-clock"></i> {{ !$task->remaining_time ? 'Expired': $task->remaining_time.' left'  }}</span>
                        <span><i class="bi bi-file-lock"></i> {{ $task->visibility }}</span>
                    </div>
                </div>

                <div class="col-md-4 text-md-end">
                    <div class="h2 d-inline d-md-block text-warning mb-1">{{ $task->user->country->currency_symbol.number_format($task->budget_per_submission,2) }}</div>
                    <small class="text-white-50">Per approved submission</small>
                    <div class="d-flex justify-content-md-end">
                        <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{route('tasks.posted')}}">Posted Tasks</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Task</li>
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
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Task Details</h5>
                        </div>
                        <div class="card-body">
                            <h6>Description</h6>
                            <p>{{ $task->description }}</p>

                            @if($task->requirements && is_array($task->requirements) && count($task->requirements))
                            <div class="mt-4">
                                <h6>Requirements</h6>
                                <ul class="list-unstyled">
                                    @foreach ($task->requirements as $requirement)
                                    <li><i class="bi bi-check-circle text-success me-2"></i> {{ $requirement }}</li>
                                    @endforeach
                                </ul>
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
                                    <span>Workers:</span>
                                    <strong>{{ $task->taskWorkers->count() }}</strong>
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


                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Share Task</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <button data-bs-toggle="modal" data-bs-target="#referralModal" class="btn btn-sm btn-primary"><i class="bi bi-share"></i> Share via email</button>
                                <button class="btn btn-sm btn-danger text-white"><i class="bi bi-instagram"></i></button>
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-twitter"></i> </button>
                                <button class="btn btn-sm btn-primary text-white"><i class="bi bi-linkedin"></i> </button>
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-facebook"></i> </button>
                            </div>
                           
                        </div>
                    </div>

                    @if($task->promotions->isNotEmpty())
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Promotion Statistics</h6>
                        </div>
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <span>Emails sent:</span>
                                <strong>12</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Views:</span>
                                <strong class="text-success">3</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Clicks:</span>
                                <strong class="text-warning">7</strong>
                            </div>

                        </div>

                    </div>
                    @endif
                </div>
                <!-- Right Column - Submissions -->
                <div class="col-lg-8">
                    <!-- Submission Tabs -->
                    <ul class="nav nav-tabs mb-4" id="submissionsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                                Pending <span class="badge bg-secondary ms-1">{{ $task->taskSubmissions->whereNull('reviewed_at', false)->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                                Approved <span class="badge bg-success ms-1">{{ $task->taskSubmissions->where('accepted', true)->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                                Rejected <span class="badge bg-danger ms-1">{{ $task->taskSubmissions->where('accepted', false)->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="disputed-tab" data-bs-toggle="tab" data-bs-target="#disputed" type="button">
                                Disputed <span class="badge bg-warning ms-1">{{ $task->disputes->where('resolved_at', null)->count() ?? 0 }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button">
                                Comments <span class="badge bg-primary ms-1">{{ $task->comments->count() }}</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="submissionsTabContent">
                        <!-- Pending Review Tab -->
                        <div class="tab-pane fade show active" id="pending" role="tabpanel">
                            @forelse ($task->taskSubmissions->whereNull('reviewed_at') as $submission)
                            @include('components.layouts.submission-card',['submission'=> $submission])
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-clipboard-x display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Pending Submissions</h4>
                                <p class="text-muted">All submissions have been reviewed.</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Approved Tab -->
                        <div class="tab-pane fade" id="approved" role="tabpanel">
                            @forelse ($task->taskSubmissions->where('accepted', true) as $submission)
                            @include('components.layouts.submission-card',['submission'=> $submission])
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Approved Submissions</h4>
                                <p class="text-muted">Approved submissions will appear here.</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Disputed Tab -->
                        <div class="tab-pane fade" id="rejected" role="tabpanel">
                            @forelse ($task->taskSubmissions->where('accepted', false) as $submission)
                            @include('components.layouts.submission-card',['submission'=> $submission])
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Rejected Submissions</h4>
                                <p class="text-muted">Rejected submissions will appear here.</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Disputed Tab -->
                        <div class="tab-pane fade" id="disputed" role="tabpanel">
                            @forelse ($task->disputes->where('resolved_at', null) as $dispute)
                            @include('components.layouts.submission-card',['submission'=> $dispute->taskSubmission])
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-exclamation-triangle display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Disputed Submissions</h4>
                                <p class="text-muted">Disputed submissions will appear here.</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Comments Tab -->
                        <div class="tab-pane fade" id="comments" role="tabpanel">
                            <!-- Comments List -->
                            <div class="comments-section">
                                @forelse ($task->comments as $comment)
                                <div class="comment-thread card mb-3">
                                    <div class="card-body">
                                        <!-- Original Question -->
                                        <div class="d-flex mb-3">
                                            <img src="{{ $comment->user->image ?? 'https://placehold.co/40' }}" alt="User" class="rounded-circle me-3" width="40" height="40">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $comment->user->username }}</h6>
                                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2"></i> Report</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p class="mb-2">{{ $comment->body }}</p>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-hand-thumbs-up me-1"></i> Helpful ({{ $comment->helpful_count ?? 0 }})
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Task Creator Responses -->
                                        @if($comment->children->count() > 0)
                                        @foreach($comment->children as $response)
                                        <div class="response ms-5 border-start border-primary border-3 ps-3 mb-3">
                                            <div class="d-flex mb-2">
                                                <img src="{{ $response->user->image ?? 'https://placehold.co/35' }}" alt="Task Creator" class="rounded-circle me-2" width="35" height="35">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h6 class="mb-0 me-2">{{ $response->user->username }}</h6>
                                                        <span class="badge bg-primary">Author</span>
                                                        <small class="text-muted ms-2">{{ $response->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0">{{ $response->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                        <!-- Response Form -->
                                        <div class="response-form ms-5 border-start border-primary border-3 ps-3">
                                            <form wire:submit="respondToComment({{ $comment->id }})">
                                                <div class="mb-2">
                                                    <textarea wire:model="commentResponses.{{ $comment->id }}" class="form-control form-control-sm" rows="2" placeholder="Add a response..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="respondToComment">
                                                    <i class="bi bi-reply me-1"></i> Reply
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-chat-dots display-1 text-muted"></i>
                                    <h4 class="text-muted mt-3">No Comments Yet</h4>
                                    <p class="text-muted">Comments from workers will appear here.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @livewire('tasks.task-submission-review')
    @livewire('tasks.task-referrals',[
    'task'=> $task
    ])


</div>