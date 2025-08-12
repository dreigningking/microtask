@php /* This file is a Bootstrap version of the jobs dashboard view. */ @endphp
@if ($taskmasterSubscription)
<div class="alert alert-primary d-flex justify-content-between align-items-center">
    <div>
        <strong>Current Plan:</strong> <span class="text-primary">{{ $taskmasterSubscription->plan->name }}</span><br>
        <small>Expires on: {{ \Carbon\Carbon::parse($taskmasterSubscription->expires_at)->format('F d, Y') }}</small>
    </div>
    @if($taskmasterUpgradeSuggestion)
        <div>
            <a href="{{ route('subscriptions') }}" class="btn btn-primary btn-sm">Upgrade to {{ $taskmasterUpgradeSuggestion->name }}</a>
        </div>
    @endif
</div>
@else
<div class="alert alert-primary d-flex justify-content-between align-items-center">
    <div>
        <strong>No Active Taskmaster Subscription</strong><br>
        <small>Choose a plan to start posting jobs.</small>
    </div>
    @if($taskmasterUpgradeSuggestion)
    <div>
        <a href="{{ route('subscriptions') }}" class="btn btn-primary btn-sm">Get {{ $taskmasterUpgradeSuggestion->name }} Plan</a>
    </div>
    @endif
</div>        
@endif

@if($taskmasterPendingSubscription)
    <div class="alert alert-warning d-flex align-items-center">
        <i class="ri-time-line text-warning me-2"></i>
        <div>
            <strong>Pending Subscription:</strong> Your <b>{{ $taskmasterPendingSubscription->plan->name }}</b> plan will become active on {{ \Carbon\Carbon::parse($taskmasterPendingSubscription->starts_at)->format('F d, Y') }}.
        </div>
    </div>
@endif

<div class="row mb-4">
    <!-- Job Stats -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-danger">
                    <div class="card-body">
                        <h6 class="text-muted">Total Spent</h6>
                        <h3 class="mb-0">{{ $userData->country->currency_symbol }}{{ number_format($jobStats['total_spent'] ?? 0, 2) }}</h3>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body">
                        <h6 class="text-muted">Active Jobs</h6>
                        <h3 class="mb-0">{{ $jobStats['active_jobs'] ?? 0 }}</h3>
                        <small class="text-muted">Currently running</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h6 class="text-muted">Total Workers</h6>
                        <h3 class="mb-0">{{ $jobStats['total_applicants'] ?? 0 }}</h3>
                        <small class="text-muted">Across all jobs</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info">
                    <div class="card-body">
                        <h6 class="text-muted">Completion Rate</h6>
                        <h3 class="mb-0">{{ number_format($jobStats['completion_rate'] ?? 0, 0) }}%</h3>
                        <small class="text-muted">Of all posted jobs</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Main Job Content -->
    <div class="col-lg-8">
        <!-- My Posted Jobs -->
        <div class="card mb-4 border-success">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <span>My Posted Jobs</span>
                <a href="{{route('jobs.create')}}" class="text-white">Post a new job <i class="ri-add-line"></i></a>
            </div>
            <div class="card-body">
                @forelse($postedJobs as $job)
                <div class="mb-3 border-bottom pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $job->title }}</h5>
                        <span class="badge bg-success">{{ $userData->country->currency_symbol }}{{ $job->expected_budget }}</span>
                    </div>
                    <div class="text-muted small mb-1">
                        <i class="ri-time-line"></i> Posted {{ $job->created_at->diffForHumans() }} &middot;
                        <span class="badge bg-primary">{{ $job->task_workers_count ?? 0 }} Workers</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="badge bg-{{ $job->status === 'open' ? 'warning' : ($job->status === 'ongoing' ? 'success' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $job->status)) }}</span>
                        <div>
                            <button class="btn btn-sm btn-primary">View Details</button>
                            <button class="btn btn-sm btn-outline-secondary ms-2">Edit</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted">You haven't posted any jobs yet.<br><a href="{{route('jobs.create')}}" class="btn btn-link">Post your first job</a></div>
                @endforelse
            </div>
        </div>
        <!-- Recent Submissions -->
        <div class="card border-primary">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Recent Submissions</span>
                <a href="#" class="text-white">View all <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="card-body">
                @forelse($recentSubmissions as $submission)
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-secondary text-white rounded-circle me-2 overflow-hidden">
                            <img src="{{ $submission->user->image }}" alt="{{ $submission->user->username }}" class="img-fluid rounded-circle" style="width:32px;height:32px;object-fit:cover;">
                        </span>
                        <div>
                            <div>{{ $submission->user->name }}</div>
                            <small class="text-muted">Submitted for: {{ $submission->task->title }}</small><br>
                            <small class="text-muted">Submitted {{ $submission->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <a href="{{route('jobs.view',$submission->task)}}" class="btn btn-sm btn-success">Review Submission</a>
                </div>
                @empty
                <div class="text-center text-muted">No submissions to review yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Job Statistics -->
        <div class="card mb-4">
            <div class="card-header">Job Statistics</div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    <div class="h4 mb-0">{{ number_format($jobStats['average_rating'] ?? 0, 1) }}/5</div>
                    <small class="text-muted">Average Rating</small>
                </div>
                <div class="mb-3 text-center">
                    <div class="h4 mb-0">{{ $jobStats['avg_completion_time'] ?? 0 }} days</div>
                    <small class="text-muted">Avg. Time to Completion</small>
                </div>
                <div class="mb-3">
                    <h6>Monthly Jobs Posted</h6>
                    <div class="d-flex align-items-end" style="height:60px;">
                        @foreach($jobStats['monthly'] ?? [] as $value)
                        <div class="bg-primary rounded me-1" style="width:6%;height:{{ $value }}%;"></div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between small text-muted mt-1">
                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trending Platforms -->
        <div class="card border-info">
            <div class="card-header bg-info text-white">Trending Platforms</div>
            <div class="card-body">
                @foreach($trendingPlatforms as $platform)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-{{ $platform['color'] }} text-white rounded-circle me-2"><i class="{{ $platform['icon'] }}"></i></span>
                        <span>{{ $platform['name'] }}</span>
                    </div>
                    <span class="badge bg-{{ $platform['color'] }}">{{ $platform['count'] }} Jobs</span>
                </div>
                @endforeach
                <div class="mt-3 text-center">
                    <a href="#" class="btn btn-link">Explore all platforms <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
        </div>
    </div>
</div> 