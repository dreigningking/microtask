<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Applied Tasks</h1>
                    <p class="mb-0">Track your task applications and progress</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="my-tasks.html" class="btn btn-outline-light">My Posted Tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- Application Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-primary mb-1">{{ $stats['total'] }}</h4>
                        <small class="text-muted">Total Applications</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-warning mb-1">{{ $stats['submitted'] }}</h4>
                        <small class="text-muted">Submissions</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-success mb-1">{{ $stats['completed'] }}</h4>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-secondary mb-1">{{ $stats['cancelled'] }}</h4>
                        <small class="text-muted">Cancelled</small>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-outline-secondary filter-toggle d-lg-none w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterColumn">
                        <i class="fas fa-filter me-2"></i> Show Filters
                    </button>
                    <div class="row">
                        <div class="col-md-6 mb-2">

                            <div class="input-group">
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search tasks...">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>

                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="" class="form-select">
                                <option value="">Filter Submissions</option>
                                <option value="">No Submissions</option>
                                <option value="">Have Submissions</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="" class="form-select">
                                <option value="">Filter Platforms</option>
                                <option value="">Have Submissions</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="" class="form-select">
                                <option value="">Filter Status</option>
                                <option value="">Ongoing</option>
                                <option value="">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($tasks as $task)

                

                <div class="col-12">
                    <div class="task-card card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <!-- <span class="badge bg-info status-badge">Under Review</span> -->
                                    <span class="badge bg-warning">{{ $task->platform->name ?? 'N/A' }}</span>
                                </div>
                                <div class="text-end">
                                    <h4 class="text-success mb-0">{{ $task->user->country->currency_symbol ?? '$' }}{{ number_format($task->budget_per_submission, 2) }}</h4>
                                    <small class="text-muted">Potential Earnings</small>
                                </div>
                            </div>
                            <h5 class="card-title">{{ $task->title }}p</h5>
                            <p class="card-text text-muted">{{ $task->description }}</p>

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <small class="text-muted"><i class="bi bi-clock"></i> Applied: {{ $task->taskWorkers->firstWhere('user_id',$user->id)->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted"><i class="bi bi-clock"></i> Deadline: {{ $task->expiry_date ? $task->expiry_date->format('jS M') : 'Not Available' }}</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted"><i class="bi bi-people"></i> {{ $task->taskSubmissions->count().'/'.$task->number_of_submissions }} Submissions</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted"><i class="bi bi-calendar"></i> You submitted: {{ $task->taskSubmissions->where('user_id',$user->id)->count()}}</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted"><i class="bi bi-calendar"></i> Earnings: {{ $task->user->country->currency_symbol ?? '$' }}{{ $task->taskSubmissions->where('user_id',$user->id)->where('paid_at','!=',null)->count() * $task->budget_per_submission}}</small>
                                </div>
                                <div class="col-md-2 text-md-end mt-2 mt-md-0">
                                    <a href="{{ route('explore.task',$task) }}" class="btn btn-sm btn-outline-primary">
                                        View Task
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">

                </div>
                @endforelse

            </div>
        </div>
    </section>
</div>
{{--
<div class="content-wrapper">
    <!-- Header -->
    

    <!-- Stats Cards -->
    

    

    <!-- Search and Filter Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search tasks by title or description...">
                        <span class="input-group-text"><i class="ri-search-line"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <select wire:model.live="sortBy" class="form-select">
                        <option value="latest">Latest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="budget_desc">Budget (High to Low)</option>
                        <option value="budget_asc">Budget (Low to High)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="card">
        <div class="card-body">
            <!-- Mobile Cards View -->
            <div class="d-md-none">
                <div class="row g-3">
                    @forelse($tasks as $taskWorker)
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        
                                    </div>
                                    <div>
                                        <h5 class="mb-1"></h5>
                                        <div class="text-muted small">{{ $taskWorker->task->platform->name ?? 'N/A' }}</div>
                                        @if($taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                        <span class="badge bg-primary">Ongoing</span>

                                        @elseif($taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                        <span class="badge bg-purple">Submitted</span>
                                        @elseif($taskWorker->completed_at)
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($taskWorker->cancelled_at)
                                        <span class="badge bg-danger">Cancelled</span>
                                        @else
                                        <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 small">
                                        <span class="text-muted">Budget:</span> <span class="fw-semibold">
                                        {{ $taskWorker->task->user->country->currency_symbol ?? '$' }}
                                        {{ number_format($taskWorker->task->budget_per_submission, 2) }}
                                        </span>
                                    </div>
                                    <div class="col-6 small"><span class="text-muted">Signed Up:</span> <span class="fw-semibold">{{ $taskWorker->created_at->format('M d, Y') }}</span></div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('tasks.view', $taskWorker->task) }}" class="btn btn-primary btn-sm flex-fill"><i class="ri-eye-line me-1"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-4">
                        <i class="ri-task-line display-4 mb-2"></i>
                        <p>No tasks found</p>
                    </div>
                    @endforelse
                </div>
            </div>

            
        </div>
    </div>
</div>
--}}