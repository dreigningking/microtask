<div class="content-wrapper">
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
                                            @elseif($job->workers->count() >= $job->number_of_people)
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
                                        <div class="col-6 small"><span class="text-muted">Workers:</span> <span class="fw-semibold">{{ $job->workers->count() }}/{{ $job->number_of_people }}</span></div>
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
                                <td>{{ $job->workers->count() }}/{{ $job->number_of_people }}</td>
                                <td>{{ $job->workers->whereNotNull('submitted_at')->count() }}/{{ $job->workers->count() }}</td>
                                <td>
                                    @if(!$job->is_active)
                                        <span class="badge bg-secondary">Draft</span>
                                    @elseif($job->workers->count() >= $job->number_of_people)
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