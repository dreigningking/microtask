@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Task Details
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Tasks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $task->title }}</li>
                </ol>
            </nav>
        </div>

        @php
            // Calculate monitoring status
            
            $submissions = $task->submissions ?? collect();
            $needsAdminReview = 0;
            $escalatedSubmissions = 0;
            $adminReviewFee = 0;
            
            if ($task->monitoring_type === 'admin_monitoring') {
                // All submissions need admin review
                $needsAdminReview = $submissions->where('reviewed_at', null)->count();
                $adminReviewFee = $submissions->count() * ($task->country->admin_monitoring_cost ?? 10);
            } elseif ($task->monitoring_type === 'self_monitoring') {
                // Only escalated submissions need admin review
                $deadlineHours = \App\Models\Setting::where('name', 'submission_review_deadline')->value('value') ?? 24;
                $deadlineHours = intval($deadlineHours);

                $escalatedSubmissions = $submissions->filter(function($submission) use ($deadlineHours) {
                    if ($submission->reviewed_at) return false;
                    $expectedReviewTime = $submission->created_at->addHours($deadlineHours);
                    return now()->isAfter($expectedReviewTime);
                })->count();
                $needsAdminReview = $escalatedSubmissions;
                $adminReviewFee = $escalatedSubmissions * ($task->country->admin_monitoring_cost ?? 10);
            }
            
            $totalPaidFee = $task->admin_monitoring_fee ?? 0;
            $refundAmount = $totalPaidFee - $adminReviewFee;
        @endphp

        <!-- Task Status Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">{{ $task->title }}</h5>
                            <p class="text-muted mb-0">Created {{ $task->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            @if($task->visibility == 'private')
                                <span class="badge bg-warning me-2">Private</span>
                            @endif
                            
                            @foreach($task->promotions as $promotion)
                                @if($promotion->type == 'featured')
                                    <span class="badge bg-info me-2">Featured</span>
                                @endif
                                @if($promotion->type == 'urgent')
                                    <span class="badge bg-danger me-2">Urgent</span>
                                @endif
                            @endforeach
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="taskActionDropdown" data-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="taskActionDropdown">
                                    <li><a class="dropdown-item" href="#">Edit Task</a></li>
                                    <li><a class="dropdown-item" href="#">Disable Task</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#">Delete Task</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Workers</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $task->workers->count() }} / {{ $task->number_of_submissions }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Positions filled</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Budget</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $task->currency }} {{ $task->expected_budget }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">{{ $task->budget_per_submission }} per person</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Completion Time</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="clock"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $task->expected_completion_minutes }} min</h1>
                        <div class="mb-0">
                            <span class="text-muted">Estimated time per worker</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Completion Rate</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="check-circle"></i>
                                </div>
                            </div>
                        </div>
                        @php
                            $completedWorkers = $task->workers->filter(function($worker) {
                                return $worker->completed_at !== null;
                            })->count();
                            
                            $completionRate = $task->workers->count() > 0 
                                ? round(($completedWorkers / $task->workers->count()) * 100) 
                                : 0;
                        @endphp
                        <h1 class="mt-1 mb-3">{{ $completionRate }}%</h1>
                        <div class="mb-0">
                            <span class="text-muted">{{ $completedWorkers }} completed out of {{ $task->workers->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#tab-overview" data-toggle="tab" role="tab">Overview</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-workers" data-toggle="tab" role="tab">Workers & Submissions</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-payment" data-toggle="tab" role="tab">Payment Info</a></li>
                    </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="card-title mb-4">Task Description</h4>
                                        <div class="mb-4">
                                            {!! $task->description !!}
                                        </div>
                                        
                                        <h4 class="card-title mb-3">Requirements</h4>
                                        <div class="mb-4">
                                            <div class="row">
                                                @foreach($task->requirements as $requirement)
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="align-middle me-2 text-primary" data-feather="check-square"></i>
                                                        <span>{{ $requirement }}</span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        @if(!empty($task->files))
                                        <h4 class="card-title mb-3">Attachments</h4>
                                        <div class="mb-4">
                                            <div class="row">
                                                @foreach($task->files as $file)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="align-middle me-2 text-primary" data-feather="file"></i>
                                                                <div>
                                                                    <div class="text-truncate" style="max-width: 180px;">{{ $file['name'] ?? basename($file['path'] ?? '') }}</div>
                                                                    <a href="{{ asset($file['path']) }}" target="_blank" class="text-sm">View</a>
                                                                    <div class="text-muted small mt-1">
                                                                        @if(!empty($file['mime_type']))
                                                                            <span>{{ $file['mime_type'] }}</span>
                                                                        @endif
                                                                        @if(!empty($file['size']))
                                                                            <span> &middot; {{ number_format($file['size']/1024, 2) }} KB</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Task Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Creator</span>
                                                        <span class="text-body">{{ $task->user->name }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Platform</span>
                                                        <span class="text-body">{{ $task->platform->name }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Template</span>
                                                        <span class="text-body">{{ $task->template->name }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Status</span>
                                                        <span class="badge bg-{{ $task->is_active ? 'success' : 'danger' }}">
                                                            {{ $task->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Created</span>
                                                        <span class="text-body">{{ $task->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>

                                                <hr>

                                                <h6 class="card-subtitle text-muted mb-3">Monitoring Details</h6>
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Type</span>
                                                        <span class="text-body">{{ ucfirst(str_replace('_', ' ', $task->monitoring_type)) }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Frequency</span>
                                                        <span class="text-body">{{ ucfirst($task->monitoring_frequency) }}</span>
                                                    </div>
                                                </div>

                                                @if($task->promotions->count() > 0)
                                                <hr>
                                                <h6 class="card-subtitle text-muted mb-3">Promotions</h6>
                                                <div class="mb-0">
                                                    @foreach($task->promotions as $promotion)
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">{{ ucfirst($promotion->type) }}</span>
                                                        <span class="text-body">{{ $promotion->days }} days</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Approval Status</span>
                                                        @if($task->approved_at)
                                                            <span class="badge bg-success">Approved</span>
                                                        @else
                                                            <span class="badge bg-danger">Not Approved</span>
                                                        @endif
                                                    </div>
                                                    @if($task->approved_at && $task->approver)
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Approved By</span>
                                                        <span class="text-body">{{ $task->approver->name }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Approved At</span>
                                                        <span class="text-body">{{ $task->approved_at->format('M d, Y H:i') }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    @if(!$task->approved_at)
                                                        <form action="{{ route('admin.tasks.approve') }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.tasks.disapprove') }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                            <button type="submit" class="btn btn-warning btn-sm">Disapprove</button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.tasks.delete') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this task? This action cannot be undone.');">
                                                        @csrf
                                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Workers & Submissions Tab -->
                        <div class="tab-pane fade" id="tab-workers" role="tabpanel">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Assigned Workers</h4>
                                    <button class="btn btn-sm btn-primary">Invite Worker</button>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Worker</th>
                                                <th>Status</th>
                                                <th>Saved</th>
                                                <th>Accepted</th>
                                                <th>Submitted</th>
                                                <th>Completed</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($task->workers->isEmpty())
                                                <tr>
                                                    <td colspan="7" class="text-center">No workers assigned to this task yet.</td>
                                                </tr>
                                            @else
                                                @foreach($task->workers as $worker)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $worker->user->image }}" 
                                                                class="rounded-circle me-2" width="32" height="32" alt="{{ $worker->user->name }}">
                                                            <div>
                                                                <span class="fw-bold">{{ $worker->user->name }}</span><br>
                                                                <small class="text-muted">{{ $worker->user->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($worker->completed_at)
                                                            <span class="badge bg-success">Completed</span>
                                                        @elseif($worker->submitted_at)
                                                            <span class="badge bg-primary">Submitted</span>
                                                        @elseif($worker->accepted_at)
                                                            <span class="badge bg-info">In Progress</span>
                                                        @elseif($worker->saved_at)
                                                            <span class="badge bg-warning">Saved</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $worker->saved_at ? $worker->saved_at->format('M d, Y') : '-' }}</td>
                                                    <td>{{ $worker->accepted_at ? $worker->accepted_at->format('M d, Y') : '-' }}</td>
                                                    <td>{{ $worker->submitted_at ? $worker->submitted_at->format('M d, Y') : '-' }}</td>
                                                    <td>{{ $worker->completed_at ? $worker->completed_at->format('M d, Y') : '-' }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                                                Actions
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#">View Details</a></li>
                                                                @if($worker->submitted_at && !$worker->completed_at)
                                                                <li><a class="dropdown-item" href="#">Approve Submission</a></li>
                                                                <li><a class="dropdown-item" href="#">Request Changes</a></li>
                                                                @endif
                                                                @if(!$worker->completed_at)
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-danger" href="#">Remove Worker</a></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h4 class="card-title mt-5 mb-4">Submissions</h4>
                                
                                @if($task->workers->whereNotNull('submitted_at')->isEmpty())
                                    <div class="alert alert-info">
                                        No submissions have been made for this task yet.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach($task->workers->whereNotNull('submitted_at') as $worker)
                                            <div class="col-md-6 mb-4">
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $worker->user->image }}" 
                                                                class="rounded-circle me-2" width="32" height="32" alt="{{ $worker->user->name }}">
                                                            <h5 class="card-title mb-0">{{ $worker->user->name }}</h5>
                                                        </div>
                                                        <div>
                                                            @if($worker->completed_at)
                                                                <span class="badge bg-success">Completed</span>
                                                            @else
                                                                <span class="badge bg-primary">Pending Review</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            <strong>Submitted:</strong> {{ $worker->submitted_at->format('M d, Y g:i A') }}
                                                        </p>
                                                        
                                                        @php
                                                            $submissions = $worker->submissions ?? [];
                                                        @endphp
                                                        
                                                        @if(!empty($submissions['notes']))
                                                            <div class="mb-3">
                                                                <strong class="d-block mb-2">Notes:</strong>
                                                                <p>{{ $submissions['notes'] }}</p>
                                                            </div>
                                                        @endif
                                                        
                                                        @if(!empty($submissions['files']))
                                                            <div>
                                                                <strong class="d-block mb-2">Files:</strong>
                                                                <div class="list-group mb-3">
                                                                    @foreach($submissions['files'] as $file)
                                                                        <a href="{{ asset($file) }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center">
                                                                            <i class="align-middle me-2" data-feather="file"></i>
                                                                            <span>{{ basename($file) }}</span>
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        @if($worker->rating)
                                                            <div class="mb-3">
                                                                <strong class="d-block mb-2">Rating:</strong>
                                                                <div class="d-flex align-items-center">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="align-middle text-warning" data-feather="{{ $i <= $worker->rating ? 'star' : 'star-outline' }}"></i>
                                                                    @endfor
                                                                    <span class="ms-2">{{ $worker->rating }}/5</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        @if($worker->review)
                                                            <div>
                                                                <strong class="d-block mb-2">Review:</strong>
                                                                <p>{{ $worker->review }}</p>
                                                            </div>
                                                        @endif
                                                        
                                                        @if(!$worker->completed_at)
                                                            <div class="mt-3 d-flex justify-content-end">
                                                                <button class="btn btn-outline-danger me-2">Request Changes</button>
                                                                <button class="btn btn-success">Approve</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Payment Info Tab -->
                        <div class="tab-pane fade" id="tab-payment" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="card-title mb-4">Payment Summary</h4>
                                        
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="card bg-light">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-subtitle text-muted mb-1">Total Budget</h6>
                                                        <h3 class="mb-0">{{ $task->currency }} {{ $task->expected_budget }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card bg-light">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-subtitle text-muted mb-1">Budget Per Worker</h6>
                                                        <h3 class="mb-0">{{ $task->currency }} {{ $task->budget_per_submission }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card bg-light">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-subtitle text-muted mb-1">Total Paid</h6>
                                                        @php
                                                            $totalPaid = $task->workers->whereNotNull('paid_at')->count() * $task->budget_per_submission;
                                                        @endphp
                                                        <h3 class="mb-0">{{ $task->currency }} {{ $totalPaid }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <h4 class="card-title mb-3">Payment History</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Worker</th>
                                                        <th>Status</th>
                                                        <th>Submitted</th>
                                                        <th>Completed</th>
                                                        <th>Paid</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($task->workers->isEmpty())
                                                        <tr>
                                                            <td colspan="6" class="text-center">No payment records for this task yet.</td>
                                                        </tr>
                                                    @else
                                                        @foreach($task->workers as $worker)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ $worker->user->image }}" 
                                                                        class="rounded-circle me-2" width="32" height="32" alt="{{ $worker->user->name }}">
                                                                    <span>{{ $worker->user->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if($worker->paid_at)
                                                                    <span class="badge bg-success">Paid</span>
                                                                @elseif($worker->completed_at)
                                                                    <span class="badge bg-warning">Pending Payment</span>
                                                                @elseif($worker->submitted_at)
                                                                    <span class="badge bg-info">Review Pending</span>
                                                                @else
                                                                    <span class="badge bg-secondary">Not Submitted</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $worker->submitted_at ? $worker->submitted_at->format('M d, Y') : '-' }}</td>
                                                            <td>{{ $worker->completed_at ? $worker->completed_at->format('M d, Y') : '-' }}</td>
                                                            <td>{{ $worker->paid_at ? $worker->paid_at->format('M d, Y') : '-' }}</td>
                                                            <td>{{ $task->currency }} {{ $task->budget_per_submission }}</td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        @php
                                            $completedUnpaidWorkers = $task->workers->filter(function($worker) {
                                                return $worker->taskSubmissions->whereNotNull('completed_at')->isNotEmpty() && 
                                                       $worker->taskSubmissions->whereNotNull('paid_at')->isEmpty();
                                            });
                                        @endphp
                                        @if($completedUnpaidWorkers->isNotEmpty())
                                            <div class="mt-3">
                                                <button class="btn btn-primary">Pay All Pending Workers</button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Promotion Costs</h5>
                                            </div>
                                            <div class="card-body">
                                                @if($task->promotions->isEmpty())
                                                    <p class="mb-0">No promotions purchased for this task.</p>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Type</th>
                                                                    <th>Duration</th>
                                                                    <th>Cost</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($task->promotions as $promotion)
                                                                <tr>
                                                                    <td>{{ ucfirst($promotion->type) }}</td>
                                                                    <td>{{ $promotion->days }} days</td>
                                                                    <td>{{ $task->currency }} {{ $promotion->cost }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="2">Total</th>
                                                                    <th>{{ $task->currency }} {{ $task->promotions->sum('cost') }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Add Promotion</h5>
                                            </div>
                                            <div class="card-body">
                                                <form>
                                                    <div class="mb-3">
                                                        <label class="form-label">Promotion Type</label>
                                                        <select class="form-select">
                                                            <option value="featured">Featured Task</option>
                                                            <option value="urgent">Urgent Task</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Duration (days)</label>
                                                        <input type="number" class="form-control" min="1" value="7">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Add Promotion</button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Platform Fee</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Task Budget:</span>
                                                    <span>{{ $task->currency }} {{ $task->expected_budget }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Platform Fee (10%):</span>
                                                    <span>{{ $task->currency }} {{ $task->expected_budget * 0.1 }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Promotion Costs:</span>
                                                    <span>{{ $task->currency }} {{ $task->promotions->sum('cost') }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>Total Client Cost:</span>
                                                    <span>{{ $task->currency }} {{ $task->expected_budget + ($task->expected_budget * 0.1) + $task->promotions->sum('cost') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection