@php /* This file is a Bootstrap version of the tasks dashboard view. */ @endphp
@if ($workerSubscription)
<div class="alert alert-info d-flex justify-content-between align-items-center">
    <div>
        <strong>Current Plan:</strong> <span class="text-primary">{{ $workerSubscription->plan->name }}</span><br>
        <small>Expires on: {{ \Carbon\Carbon::parse($workerSubscription->expires_at)->format('F d, Y') }}</small>
    </div>
    @if($workerUpgradeSuggestion)
        <div>
            <a href="{{ route('subscriptions') }}" class="btn btn-primary btn-sm">Upgrade to {{ $workerUpgradeSuggestion->name }}</a>
        </div>
    @endif
</div>
@else
<div class="alert alert-info d-flex justify-content-between align-items-center">
    <div>
        <strong>No Active Worker Subscription</strong><br>
        <small>Choose a plan to start working on tasks.</small>
    </div>
    @if($workerUpgradeSuggestion)
    <div>
        <a href="{{ route('subscriptions') }}" class="btn btn-primary btn-sm">Get {{ $workerUpgradeSuggestion->name }} Plan</a>
    </div>
    @endif
</div>        
@endif


@if($workerPendingSubscription)
    <div class="alert alert-warning d-flex align-items-center">
        <i class="ri-time-line text-warning me-2"></i>
        <div>
            <strong>Pending Subscription:</strong> Your <b>{{ $workerPendingSubscription->plan->name }}</b> plan will become active on {{ \Carbon\Carbon::parse($workerPendingSubscription->starts_at)->format('F d, Y') }}.
        </div>
    </div>
@endif

<div class="row mb-4">
    <!-- Task Stats -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body">
                        <h6 class="text-muted">Total Earnings</h6>
                        <h3 class="mb-0">{{ $userData->country->currency_symbol }}{{ number_format($earnings, 2) }}</h3>
                        <small class="text-success"><i class="ri-arrow-up-line"></i> 12.5% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h6 class="text-muted">Completed Tasks</h6>
                        <h3 class="mb-0">{{ $completedTasks->count() }}</h3>
                        <small class="text-success"><i class="ri-arrow-up-line"></i> 8.2% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body">
                        <h6 class="text-muted">Ongoing Tasks</h6>
                        <h3 class="mb-0">{{ $ongoingTasks->count() }}</h3>
                        <small class="text-warning"><i class="ri-time-line"></i> {{ $ongoingTasks->filter(fn($task) => $task->task->expected_completion_minutes < 180)->count() }} due soon</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info">
                    <div class="card-body">
                        <h6 class="text-muted">Saved Tasks</h6>
                        <h3 class="mb-0">{{ $savedTasks->count() }}</h3>
                        <a href="{{route('tasks.index')}}?status=saved" class="btn btn-link p-0">View all <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Main Task Content -->
    <div class="col-lg-8">
        <!-- Saved Tasks -->
        <div class="card mb-4 border-primary">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <span>Saved Tasks</span>
                <a href="#" class="text-white">Find more tasks <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="card-body">
                @forelse($savedTasks as $taskWorker)
                <div class="mb-3 border-bottom pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $taskWorker->task->title }}</h5>
                        <span class="badge bg-success">{{ $userData->country->currency_symbol }}{{ $taskWorker->task->budget_per_person }}</span>
                    </div>
                    <div class="text-muted small mb-1">
                        <i class="ri-building-line"></i> {{ optional($taskWorker->task->user)->name ?? 'Anonymous' }} &middot;
                        <i class="ri-time-line"></i> Posted {{ $taskWorker->task->created_at->diffForHumans() }}
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-primary">{{ optional($taskWorker->task->platform)->name ?? 'General' }}</span>
                        <span class="badge bg-info">{{ $taskWorker->task->expected_completion_minutes }} mins</span>
                    </div>
                    <button class="btn btn-sm btn-primary">Apply Now</button>
                    <button class="btn btn-sm btn-outline-danger ms-2"><i class="ri-delete-bin-line"></i> Unsave</button>
                </div>
                @empty
                <div class="text-center text-muted">No saved tasks found. Browse jobs and save the ones you're interested in!</div>
                @endforelse
            </div>
        </div>
        <!-- Ongoing Tasks -->
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <span>My Ongoing Tasks</span>
                <a href="{{route('tasks.index')}}?status=accepted" class="text-dark">View all <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="card-body">
                @forelse($ongoingTasks as $taskWorker)
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div>
                        <h6 class="mb-1">{{ $taskWorker->task->title }}</h6>
                        <div class="small text-muted">
                            @if($taskWorker->task->expected_completion_minutes < 180)
                                <i class="ri-alarm-warning-line text-danger"></i>
                                @endif
                                Accepted {{ $taskWorker->accepted_at->diffForHumans() }}
                        </div>
                    </div>
                    @php
                    $timeElapsed = now()->diffInMinutes($taskWorker->accepted_at);
                    $totalTime = $taskWorker->task->expected_completion_minutes;
                    $completionPercentage = min(95, round(($timeElapsed / $totalTime) * 100));
                    @endphp
                    <span class="badge bg-{{ $completionPercentage < 50 ? 'danger' : ($completionPercentage < 80 ? 'warning' : 'success') }}">{{ $completionPercentage }}% Complete</span>
                </div>
                @empty
                <div class="text-center text-muted">You don't have any ongoing tasks.</div>
                @endforelse
            </div>
        </div>
        <!-- Recently Completed Tasks -->
        <div class="card border-success">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <span>Recently Completed Tasks</span>
                <a href="{{route('tasks.index')}}?status=completed" class="text-white">View all <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="card-body">
                @forelse($completedTasks as $taskWorker)
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-primary text-white rounded-circle me-2"><i class="ri-file-text-line"></i></span>
                        <div>
                            <div>{{ $taskWorker->task->title }}</div>
                            <small class="text-muted">Submitted {{ $taskWorker->submitted_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">+{{ $userData->country->currency_symbol }}{{ $taskWorker->task->budget_per_person }}</div>
                        <small class="text-muted">
                            @if($taskWorker->paid_at)
                            <span class="text-success">Paid {{ $taskWorker->paid_at->diffForHumans() }}</span>
                            @else
                            <span class="text-warning">Pending Payment</span>
                            @endif
                        </small>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted">You haven't completed any tasks yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Earnings Summary -->
        <div class="card mb-4">
            <div class="card-header">Earnings Summary</div>
            <div class="card-body">
                @forelse($earningsSummary as $earning)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <span class="avatar bg-{{ $earning->icon_color }} text-white rounded-circle me-2"><i class="{{ $earning->icon }}"></i></span>
                        <div>
                            <div>{{ $earning->description }}</div>
                            <small class="text-muted">{{ $earning->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <span class="fw-bold text-success">+{{ $userData->country->currency_symbol }}{{ $earning->amount }}</span>
                </div>
                @empty
                <div class="text-center text-muted">No recent earnings.</div>
                @endforelse
                <div class="mt-3 text-center">
                    <a href="#" class="btn btn-link">View all transactions <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
        </div>
        <!-- Referral Program -->
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">Refer & Earn</div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <span class="avatar bg-primary text-white rounded-circle me-3"><i class="ri-user-add-line"></i></span>
                    <div>
                        <div class="fw-bold">Invite people and earn rewards</div>
                        <small class="text-muted">Use the invitation system on jobs and tasks to invite others. You will earn a commission when your invitee signs up and completes their first task.</small>
                    </div>
                </div>
                <div class="text-center">
                    <div class="display-6 fw-bold text-success">{{ $userData->country->currency_symbol }}{{ number_format($referralEarnings, 2) }}</div>
                    <div class="text-muted">Referral Earnings</div>
                </div>
            </div>
        </div>
    </div>
</div>