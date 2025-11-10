<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">My Posted Tasks</h1>
                    <p class="mb-0">Manage tasks you've posted and review applicants</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Posted Task</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card text-center p-3">
                        <h4 class="text-dark mb-1">{{ $stats['total'] }}</h4>
                        <small class="text-muted">Total Posted</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center p-3">
                        <h4 class="text-info mb-1">{{ $stats['in_progress'] }}</h4>
                        <small class="text-muted">In Progress</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center p-3">
                        <h4 class="text-warning mb-1">{{ $stats['pending_review'] }}</h4>
                        <small class="text-muted">Pending Review</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center p-3">
                        <h4 class="text-danger mb-1">{{ $stats['rejected'] }}</h4>
                        <small class="text-muted">Rejected</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center p-3">
                        <h4 class="text-secondary mb-1">{{ $stats['drafts'] }}</h4>
                        <small class="text-muted">Draft</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center p-3">
                        <h4 class="text-success mb-1">{{ $stats['completed'] }}</h4>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
            </div>

            <!-- Task Tabs -->
            <ul class="nav nav-tabs mb-4" id="myTasksTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button">Active Tasks ({{ $stats['in_progress'] }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Review ({{ $stats['pending_review'] }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft" type="button">Drafts ({{ $stats['drafts'] }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button">Completed ({{ $stats['completed'] }})</button>
                </li>
            </ul>

            <div class="tab-content" id="myTasksTabContent">
                <!-- Active Tasks Tab -->
                <div class="tab-pane fade show active" id="active" role="tabpanel">
                    <div class="row g-4">
                        @forelse($activeTasks as $task)
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-success status-badge">Active</span>
                                            <span class="badge bg-primary">{{ $task->platform->name }}</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-success mb-0">{{ Auth::user()->country->currency_symbol }}{{ number_format($task->expected_budget, 2) }}</h4>
                                            <small class="text-muted">Budget</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ Str::limit($task->description, 150) }}</p>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-file-earmark-text"></i> Submissions: {{ $task->taskSubmissions->count() }}/{{ $task->number_of_submissions }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-people"></i> Workers: {{ $task->taskWorkers->count() }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-clock"></i> Pending Reviews: {{ $task->taskSubmissions->where('accepted', false)->count() }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-calendar"></i> Deadline: {{ $task->remaining_time ?? 'No deadline' }}</small>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">Manage your active task</small>
                                            </div>
                                            <div>
                                                <a href="{{ route('tasks.manage', $task) }}" class="btn btn-primary btn-sm">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-briefcase display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No Active Tasks</h4>
                            <p class="text-muted">You don't have any active tasks at the moment.</p>
                        </div>
                        @endforelse
                    </div>
                    @if($activeTasks->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $activeTasks->links() }}
                    </div>
                    @endif
                </div>

                <!-- Pending Review Tab -->
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    <div class="row g-4">
                        @forelse($pendingTasks as $task)
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-warning status-badge">Pending Review</span>
                                            <span class="badge bg-info">{{ $task->platform->name }}</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-secondary mb-0">{{ Auth::user()->country->currency_symbol }}{{ number_format($task->expected_budget, 2) }}</h4>
                                            <small class="text-muted">Budget</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ Str::limit($task->description, 150) }}</p>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-calendar"></i> Submitted: {{ $task->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-clock"></i> Waiting for admin approval</small>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">Your task is under review by our team</small>
                                            </div>
                                            <div>
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">Edit Task</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-hourglass display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No Tasks Pending Review</h4>
                            <p class="text-muted">All your tasks have been reviewed.</p>
                        </div>
                        @endforelse
                    </div>
                    @if($pendingTasks->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $pendingTasks->links() }}
                    </div>
                    @endif
                </div>

                <!-- Completed Tasks Tab -->
                <div class="tab-pane fade" id="completed" role="tabpanel">
                    <div class="row g-4">
                        @forelse($completedTasks as $task)
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-success status-badge">Completed</span>
                                            <span class="badge bg-info">{{ $task->platform->name }}</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-success mb-0">{{ Auth::user()->country->currency_symbol }}{{ number_format($task->expected_budget, 2) }}</h4>
                                            <small class="text-muted">Total Budget</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ Str::limit($task->description, 150) }}</p>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-file-earmark-check"></i> Submissions: {{ $task->taskSubmissions->where('accepted', true)->count() }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-cash"></i> Paid Out: {{ Auth::user()->country->currency_symbol }}{{ number_format($task->taskSubmissions->where('accepted', true)->count() * $task->budget_per_submission, 2) }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-arrow-counterclockwise"></i> Refund: {{ Auth::user()->country->currency_symbol }}{{ number_format(($task->number_of_submissions - $task->taskSubmissions->where('accepted', true)->count()) * $task->budget_per_submission, 2) }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted"><i class="bi bi-check-circle"></i> Reviewed: {{ $task->taskSubmissions->whereNotNull('reviewed_at')->count() }} (Admin: {{ $task->taskSubmissions->where('review_type', 'admin_review')->count() }}, Self: {{ $task->taskSubmissions->where('review_type', 'self_review')->count() }}, System: {{ $task->taskSubmissions->where('review_type', 'system_review')->count() }})</small>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">Task completed successfully</small>
                                            </div>
                                            <div>
                                                <a href="{{ route('tasks.manage', $task) }}" class="btn btn-primary btn-sm">View Full Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-check-circle display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No Completed Tasks</h4>
                            <p class="text-muted">You don't have any completed tasks yet.</p>
                        </div>
                        @endforelse
                    </div>
                    @if($completedTasks->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $completedTasks->links() }}
                    </div>
                    @endif
                </div>

                <!-- Drafts Tab -->
                <div class="tab-pane fade" id="draft" role="tabpanel">
                    <div class="row g-4">
                        @forelse($draftTasks as $task)
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-secondary status-badge">Draft</span>
                                            <span class="badge bg-light text-dark">{{ $task->platform->name }}</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-muted mb-0">{{ Auth::user()->country->currency_symbol }}{{ number_format($task->expected_budget, 2) }}</h4>
                                            <small class="text-muted">Budget</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ Str::limit($task->description, 150) }}</p>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-clock"></i> Created: {{ $task->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-pencil"></i> Draft - Not published</small>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">Complete your draft to publish</small>
                                            </div>
                                            <div>
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit Draft</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No Draft Tasks</h4>
                            <p class="text-muted">You don't have any tasks in draft mode.</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Your First Task</a>
                        </div>
                        @endforelse
                    </div>
                    @if($draftTasks->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $draftTasks->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


   
</div>