<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">My Posted Tasks</h1>
                    <p class="mb-0">Manage tasks you've posted and review applicants</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="applied-tasks.html" class="btn btn-outline-light">Applied Tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-primary mb-1">5</h4>
                        <small class="text-muted">Total Posted</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-success mb-1">3</h4>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-warning mb-1">1</h4>
                        <small class="text-muted">In Progress</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h4 class="text-info mb-1">1</h4>
                        <small class="text-muted">Waiting Review</small>
                    </div>
                </div>
            </div>

            <!-- Task Tabs -->
            <ul class="nav nav-tabs mb-4" id="myTasksTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button">Active Tasks</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button">Completed</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft" type="button">Drafts</button>
                </li>
            </ul>

            <div class="tab-content" id="myTasksTabContent">
                <!-- Active Tasks Tab -->
                <div class="tab-pane fade show active" id="active" role="tabpanel">
                    <div class="row g-4">
                        <!-- Task 1 - In Progress -->
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-warning status-badge">In Progress</span>
                                            <span class="badge bg-primary">Data Entry</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-success mb-0">$25</h4>
                                            <small class="text-muted">Budget</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Excel Data Entry for Customer Records</h5>
                                    <p class="card-text">Need someone to input 500 customer records into Excel spreadsheet with basic formatting and data validation.</p>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-clock"></i> Deadline: 2 days left</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-people"></i> 8 applicants</small>
                                        </div>
                                    </div>

                                    <!-- Assigned Worker -->
                                    <div class="border-top pt-3">
                                        <h6>Assigned Worker</h6>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40" alt="Worker" class="rounded-circle me-3">
                                            <div>
                                                <strong>Sarah Johnson</strong>
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                    <span class="text-muted">(4.5)</span>
                                                </div>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-outline-primary btn-sm">Message</button>
                                                <button class="btn btn-primary btn-sm">Review Work</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Task 2 - Waiting for Worker -->
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-info status-badge">Waiting for Worker</span>
                                            <span class="badge bg-success">Social Media</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-success mb-0">$45</h4>
                                            <small class="text-muted">Budget</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Instagram Content Creation</h5>
                                    <p class="card-text">Create 5 engaging Instagram posts for our coffee shop with brand-consistent visuals and captions.</p>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-clock"></i> Deadline: 5 days left</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-people"></i> 3 applicants</small>
                                        </div>
                                    </div>

                                    <!-- Applicants -->
                                    <div class="border-top pt-3">
                                        <h6>Applicants</h6>
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="https://via.placeholder.com/30" alt="Applicant" class="rounded-circle me-2">
                                            <div class="flex-grow-1">
                                                <strong>Mike Chen</strong>
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                    <span class="text-muted">(4.0)</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-success btn-sm">Accept</button>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30" alt="Applicant" class="rounded-circle me-2">
                                            <div class="flex-grow-1">
                                                <strong>Emily Davis</strong>
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <span class="text-muted">(5.0)</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-success btn-sm">Accept</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks Tab -->
                <div class="tab-pane fade" id="completed" role="tabpanel">
                    <div class="row g-4">
                        <!-- Completed Task 1 -->
                        <div class="col-12">
                            <div class="task-card card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-success status-badge">Completed</span>
                                            <span class="badge bg-info">Writing</span>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-success mb-0">$60</h4>
                                            <small class="text-muted">Paid</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Blog Article about Sustainable Living</h5>
                                    <p class="card-text">1000-word blog post with SEO optimization and relevant images.</p>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-calendar-check"></i> Completed: 2 days ago</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted"><i class="bi bi-star-fill text-warning"></i> You rated: 5 stars</small>
                                        </div>
                                    </div>

                                    <!-- Worker Info -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Worker" class="rounded-circle me-3">
                                                <div>
                                                    <strong>David Wilson</strong>
                                                    <div class="text-warning small">
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <span class="text-muted">(5.0)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-outline-secondary btn-sm">View Work</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drafts Tab -->
                <div class="tab-pane fade" id="draft" role="tabpanel">
                    <div class="text-center py-5">
                        <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                        <h4 class="text-muted mt-3">No Draft Tasks</h4>
                        <p class="text-muted">You don't have any tasks in draft mode.</p>
                        <a href="#" class="btn btn-primary">Create Your First Task</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="content-wrapper d-none">
        <!-- Header -->
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0">
                        @switch($status)
                        @case('in_progress')
                        Ongoing Jobs
                        @break
                        @case('completed')
                        Completed Jobs
                        @break
                        @case('drafts')
                        Draft Jobs
                        @break
                        @default
                        My Jobs
                        @endswitch
                    </h1>
                    <p class="text-muted mb-0">
                        @switch($status)
                        @case('in_progress')
                        Jobs that are currently being worked on by your team
                        @break
                        @case('completed')
                        Jobs that have been successfully completed
                        @break
                        @case('drafts')
                        Jobs that are saved but not yet published
                        @break
                        @default
                        Manage all your posted jobs in one place
                        @endswitch
                    </p>
                </div>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="ri-add-line me-1"></i>
                    <span>Post New Job</span>
                </a>
            </div>
        </div>

        <!-- Filtering and Status Tabs -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-4">
                    <!-- Status Tabs -->
                    <div class="col-md-8 mb-2 mb-md-0">
                        <div class="btn-group" role="group">
                            <a href="{{ route('jobs.index') }}" class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                All Jobs ({{ $stats['total'] }})
                            </a>
                            <a href="{{ route('jobs.ongoing') }}" class="btn btn-sm {{ $status === 'in_progress' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Ongoing ({{ $stats['in_progress'] }})
                            </a>
                            <a href="{{ route('jobs.completed') }}" class="btn btn-sm {{ $status === 'completed' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Completed ({{ $stats['completed'] }})
                            </a>
                            <a href="{{ route('jobs.drafts') }}" class="btn btn-sm {{ $status === 'drafts' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Drafts ({{ $stats['drafts'] }})
                            </a>
                        </div>
                    </div>
                    <!-- Search -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search jobs...">
                            <span class="input-group-text bg-white border-0"><i class="ri-search-line text-muted"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Mobile Cards View -->
                <div class="d-md-none">
                    <div class="row g-3">
                        @forelse($jobs as $job)
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-1">{{ $job->title }}</h5>
                                            <div class="text-muted small">{{ $job->platform->name }}</div>
                                        </div>
                                        <div>
                                            @if(!$job->is_active)
                                            <span class="badge bg-secondary">Draft</span>
                                            @elseif($job->workers->count() >= $job->number_of_submissions)
                                            <span class="badge bg-warning">Completed</span>
                                            @elseif($job->workers->count() > 0)
                                            <span class="badge bg-info">In Progress</span>
                                            @else
                                            <span class="badge bg-success">Active</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 small"><span class="text-muted">Budget:</span> <span class="fw-semibold">{{ $job->user->country->currency_symbol }}{{ number_format($job->expected_budget, 2) }}</span></div>
                                        <div class="col-6 small"><span class="text-muted">Workers:</span> <span class="fw-semibold">{{ $job->workers->count() }}/{{ $job->number_of_submissions }}</span></div>
                                        <div class="col-6 small"><span class="text-muted">Submissions:</span> <span class="fw-semibold">{{ $job->workers->whereNotNull('submitted_at')->count() }}/{{ $job->workers->count() }}</span></div>
                                        <div class="col-6 small"><span class="text-muted">Posted:</span> <span class="fw-semibold">{{ $job->created_at->format('M d, Y') }}</span></div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('jobs.view', $job) }}" class="btn btn-primary btn-sm flex-fill"><i class="ri-eye-line me-1"></i> View</a>
                                        @if($job->can_be_edited)
                                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-secondary btn-sm flex-fill"><i class="ri-edit-line me-1"></i> Edit</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted py-4">
                            <i class="ri-briefcase-4-line display-4 mb-2"></i>
                            <p>No jobs found</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="d-none d-md-block table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Job Title</th>
                                <th>Platform</th>
                                <th>Posted Date</th>
                                <th>Budget</th>
                                <th>Workers</th>
                                <th>Submissions</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->platform->name }}</td>
                                <td>{{ $job->created_at->format('M d, Y') }}</td>
                                <td>{{ $job->user->country->currency_symbol }}{{ number_format($job->expected_budget, 2) }}</td>
                                <td>{{ $job->workers->count() }}/{{ $job->number_of_submissions }}</td>
                                <td>{{ $job->workers->whereNotNull('submitted_at')->count() }}/{{ $job->workers->count() }}</td>
                                <td>
                                    @if(!$job->is_active)
                                    <span class="badge bg-secondary">Draft</span>
                                    @elseif($job->workers->count() >= $job->number_of_submissions)
                                    <span class="badge bg-warning">Completed</span>
                                    @elseif($job->workers->count() > 0)
                                    <span class="badge bg-info">In Progress</span>
                                    @else
                                    <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('jobs.view', $job) }}" class="btn btn-primary btn-sm me-1"><i class="ri-eye-line me-1"></i> View</a>
                                    @if($job->can_be_edited)
                                    <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-secondary btn-sm"><i class="ri-edit-line me-1"></i> Edit</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No jobs found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <span class="fw-semibold">{{ $jobs->firstItem() }}</span> to <span class="fw-semibold">{{ $jobs->lastItem() }}</span> of <span class="fw-semibold">{{ $jobs->total() }}</span> results
                    </div>
                    <div>
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Total Jobs</h6>
                            <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="ri-briefcase-4-line text-primary"></i></span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Active Jobs</h6>
                            <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="ri-check-double-line text-success"></i></span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $stats['active'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Total Workers</h6>
                            <span class="bg-purple bg-opacity-10 rounded-circle p-2"><i class="ri-user-3-line text-purple"></i></span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $stats['total_workers'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Total Spent</h6>
                            <span class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="ri-money-dollar-circle-line text-warning"></i></span>
                        </div>
                        <h3 class="fw-bold mb-0">${{ number_format($stats['total_spent'], 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>