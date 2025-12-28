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

            <!-- Search Bar -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search tasks by title...">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>

            <!-- Task Tabs -->
            <ul class="nav nav-tabs mb-4" id="myTasksTab" role="tablist">
                 <li class="nav-item" role="presentation">
                     <button class="nav-link {{ $activeTab === 'active' ? 'active' : '' }}" wire:click="switchTab('active')" type="button">Active Tasks ({{ $stats['in_progress'] }})</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}" wire:click="switchTab('pending')" type="button">Pending Review ({{ $stats['pending_review'] }})</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link {{ $activeTab === 'drafts' ? 'active' : '' }}" wire:click="switchTab('drafts')" type="button">Drafts ({{ $stats['drafts'] }})</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link {{ $activeTab === 'completed' ? 'active' : '' }}" wire:click="switchTab('completed')" type="button">Completed ({{ $stats['completed'] }})</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link {{ $activeTab === 'rejected' ? 'active' : '' }}" wire:click="switchTab('rejected')" type="button">Rejected ({{ $stats['rejected'] }})</button>
                 </li>
             </ul>

            <div class="tab-content" id="myTasksTabContent">
                <!-- Dynamic Tasks Content -->
                <div class="tab-pane fade show active" id="tasks-content" role="tabpanel">
                    <div class="row g-4">
                        @forelse($tasks as $task)
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            @if($activeTab === 'active')
                                                <span class="badge bg-success status-badge">Active</span>
                                            @elseif($activeTab === 'pending')
                                                <span class="badge bg-warning status-badge">Pending Review</span>
                                            @elseif($activeTab === 'completed')
                                                <span class="badge bg-success status-badge">Completed</span>
                                            @elseif($activeTab === 'drafts')
                                                <span class="badge bg-secondary status-badge">Draft</span>
                                            @elseif($activeTab === 'rejected')
                                                <span class="badge bg-danger status-badge">Rejected</span>
                                            @endif
                                            <span class="badge bg-primary">{{ $task->platform->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="text-end">
                                            @if($activeTab === 'completed')
                                                <h4 class="text-success mb-0">{{ Auth::user()->currency_symbol }}{{ number_format($task->expected_budget, 2) }}</h4>
                                                <small class="text-muted">Total Budget</small>
                                            @else
                                                <h4 class="text-{{ $activeTab === 'drafts' || $activeTab === 'rejected' ? 'muted' : 'success' }} mb-0">{{ Auth::user()->currency_symbol }}{{ number_format($task->expected_budget, 2) }}</h4>
                                                <small class="text-muted">Budget</small>
                                            @endif
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ Str::limit($task->description, 150) }}</p>

                                    <div class="row mb-3">
                                        @if($activeTab === 'active')
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
                                        @elseif($activeTab === 'pending')
                                            <div class="col-md-6">
                                                <small class="text-muted"><i class="bi bi-calendar"></i> Submitted: {{ $task->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted"><i class="bi bi-clock"></i> Waiting for admin approval</small>
                                            </div>
                                        @elseif($activeTab === 'completed')
                                            <div class="col-md-3">
                                                <small class="text-muted"><i class="bi bi-file-earmark-check"></i> Submissions: {{ $task->taskSubmissions->where('accepted', true)->count() }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted"><i class="bi bi-cash"></i> Paid Out: {{ Auth::user()->currency_symbol }}{{ number_format($task->taskSubmissions->where('accepted', true)->count() * $task->budget_per_submission, 2) }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted"><i class="bi bi-arrow-counterclockwise"></i> Refund: {{ Auth::user()->currency_symbol }}{{ number_format(($task->number_of_submissions - $task->taskSubmissions->where('accepted', true)->count()) * $task->budget_per_submission, 2) }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted"><i class="bi bi-check-circle"></i> Reviewed: {{ $task->taskSubmissions->whereNotNull('reviewed_at')->count() }}</small>
                                            </div>
                                        @elseif($activeTab === 'drafts')
                                            <div class="col-md-6">
                                                <small class="text-muted"><i class="bi bi-clock"></i> Created: {{ $task->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted"><i class="bi bi-pencil"></i> Draft - Not published</small>
                                            </div>
                                        @elseif($activeTab === 'rejected')
                                            <div class="col-md-6">
                                                <small class="text-muted"><i class="bi bi-clock"></i> Created: {{ $task->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted"><i class="bi bi-exclamation-triangle"></i> Rejected - Not published</small>
                                            </div>
                                            @if($task->latestModeration && $task->latestModeration->notes)
                                            <div class="col-12 mt-2">
                                                <div class="alert alert-danger py-2">
                                                    <small><strong>Rejection Reason:</strong> {{ $task->latestModeration->notes }}</small>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">
                                                    @if($activeTab === 'active')
                                                        Manage your active task
                                                    @elseif($activeTab === 'pending')
                                                        Your task is under review by our team
                                                    @elseif($activeTab === 'completed')
                                                        Task completed successfully
                                                    @elseif($activeTab === 'drafts')
                                                        Complete your draft to publish
                                                    @elseif($activeTab === 'rejected')
                                                        This task has been rejected
                                                    @endif
                                                </small>
                                            </div>
                                            <div>
                                                @if($activeTab === 'active' || $activeTab === 'completed')
                                                    <a href="{{ route('tasks.manage', $task) }}" class="btn btn-primary btn-sm">{{ $activeTab === 'completed' ? 'View Full Details' : 'View Details' }}</a>
                                                @elseif($activeTab === 'pending' || $activeTab === 'drafts' || $activeTab === 'rejected')
                                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">{{ $activeTab === 'drafts' ? 'Edit Draft' : 'Edit Task' }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            @if($activeTab === 'active')
                                <i class="bi bi-briefcase display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Active Tasks</h4>
                                <p class="text-muted">You don't have any active tasks at the moment.</p>
                            @elseif($activeTab === 'pending')
                                <i class="bi bi-hourglass display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Tasks Pending Review</h4>
                                <p class="text-muted">All your tasks have been reviewed.</p>
                            @elseif($activeTab === 'completed')
                                <i class="bi bi-check-circle display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Completed Tasks</h4>
                                <p class="text-muted">You don't have any completed tasks yet.</p>
                            @elseif($activeTab === 'drafts')
                                <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Draft Tasks</h4>
                                <p class="text-muted">You don't have any tasks in draft mode.</p>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Your First Task</a>
                            @elseif($activeTab === 'rejected')
                                <i class="bi bi-x-circle display-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No Rejected Tasks</h4>
                                <p class="text-muted">You don't have any rejected tasks.</p>
                            @endif
                        </div>
                        @endforelse
                    </div>
                    @if($tasks->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tasks->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>