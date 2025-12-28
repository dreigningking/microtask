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
                            <select wire:model.live="filterSubmissions" class="form-select">
                                <option value="">Filter Submissions</option>
                                <option value="no_submissions">No Submissions</option>
                                <option value="have_submissions">Have Submissions</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select wire:model.live="filterPlatforms" class="form-select">
                                <option value="">Filter Platforms</option>
                                @foreach($platforms as $platform)
                                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select wire:model.live="filterStatus" class="form-select">
                                <option value="">Filter Status</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
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
                                    <span class="badge bg-warning">{{ $task->platform->name ?? 'N/A' }}</span>
                                </div>
                                <div class="text-end">
                                    <h4 class="text-success mb-0">{{ $task->user->currency_symbol ?? '$' }}{{ number_format($task->budget_per_submission, 2) }}</h4>
                                    <small class="text-muted">Potential Earnings</small>
                                </div>
                            </div>
                            <h5 class="card-title">{{ $task->title }}</h5>
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
                                    <small class="text-muted"><i class="bi bi-calendar"></i> Earnings: {{ $task->user->currency_symbol ?? '$' }}{{ $task->taskSubmissions->where('user_id',$user->id)->where('paid_at','!=',null)->count() * $task->budget_per_submission}}</small>
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
                <div class="col-12 text-center py-5">
                    <i class="bi bi-clipboard-x display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No applied tasks found</h5>
                    <p class="text-muted">You haven't applied to any tasks yet. Start exploring and applying to tasks to see them here.</p>
                </div>
                @endforelse

            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </section>
</div>
