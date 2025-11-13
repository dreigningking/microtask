<div class="submission-card card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center">
                <img class="rounded-circle me-3" src="{{ $submission->taskWorker->user->image }}" alt="{{ $submission->taskWorker->user->username }}">

                <div>
                    <h6 class="mb-1">{{ $submission->taskWorker->user->username }} - {{ $submission->taskWorker->user->country->name ?? 'N/A' }}</h6>
                    <div class="text-warning small">
                        <span class="text-muted">{{ $submission->taskWorker->user->tasks->count() }} tasks posted</span>
                        <span class="text-muted">• {{ $submission->taskWorker->user->taskSubmissions->where('accepted',true)->count() }} tasks completed</span>
                    </div>
                </div>
            </div>
            <div class="text-end">
                @if(!$submission->reviewed_at)
                <span class="badge bg-secondary status-badge">Pending Review</span>
                <div class="text-muted small">Submitted: {{ $submission->created_at->format('M d, Y H:i') }}</div>
                @elseif($submission->accepted)
                <span class="badge bg-success status-badge">Approved & Paid</span>
                <div class="text-muted small">Approved at: {{ $submission->paid_at->format('M d, Y H:i') }}</div>
                @elseif($submission->dispute)
                <span class="badge bg-warning status-badge">Disputed</span>
                <div class="text-muted small">Disputed on: {{ $submission->dispute->created_at->format('M d, Y H:i') }}</div>
                @elseif(!$submission->accepted)
                <span class="badge bg-danger status-badge">Rejected</span>
                <div class="text-muted small">Rejected at: {{ $submission->reviewed_at->format('M d, Y H:i') }}</div>
                @endif
            </div>
        </div>
        
        <h6>Submission Data</h6>
        <div class="submission-preview border rounded p-3 bg-light mb-3">
            @if($submission->submission_details && is_array($submission->submission_details)) 
                @foreach($submission->submission_details as $field)
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h6 class="fw-medium">{{ $field['title'] }}</h6>
                    </div>
                    <div class="col-md-6">
                        @if($field['type'] === 'file')
                            @if(!empty($field['value']))
                            <a href="{{ asset('storage/' . $field['value']) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-download me-1"></i> {{ Str::limit(basename($field['value']), 15) }}
                            </a>
                            @else
                                <span class="text-muted small">No file uploaded</span>
                            @endif
                        @elseif(is_array($field['value'] ?? null))
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($field['value'] as $item)
                            <span class="badge bg-light text-dark">{{ $item }}</span>
                            @endforeach
                        </div>
                        @else
                        <div class="bg-light rounded">{{ $field['value'] ?? 'Not provided' }}</div>
                        @endif
                    </div>
                </div>
                @endforeach        
            @else
                <div class="alert alert-info">
                    <i class="ri-information-line me-2"></i>
                    No submission data available
                </div>
            @endif
        </div>
        
        @if($submission->reviewed_at && $submission->accepted)
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> You approved this submission and paid {{ $submission->task->user->country->currency_symbol.number_format($submission->task->budget_per_submission,2) }} to Emily Davis.
            
            <div class="mt-1">
                <strong>Your Review:</strong> {{ $submission->review_body }}
            </div>
        </div>
        @endif
        @if($submission->reviewed_at && !$submission->accepted)
        <div class="alert alert-danger">
            <i class="bi bi-x-circle"></i> You rejected this submission
            
            <div class="mt-1">
                <strong>Your Review:</strong> {{ $submission->review_body }}
            </div>
        </div>
        @endif
        @if($submission->reviewed_at && $submission->dispute)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> This submission is under dispute resolution.
            <div class="mt-1">
                <strong>Worker's Claim:</strong> {{ $submission->dispute->comments->first()->body }}
            </div>
            <div class="mt-1">
                <strong>Admin Status:</strong> Under review
            </div>
            <div class="mt-1">
                <a href="{{ route('tasks.dispute',$submission) }}" class="btn btn-sm btn-warning">View Dispute</a> 
            </div>
        </div>
        @endif

        <div class="d-flex gap-2">
            <!-- <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewSubmissionModal">
                <i class="bi bi-eye"></i> View Full Submission
            </button> -->
            @if(!$submission->reviewed_at)
            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#approveModal" wire:click="$dispatch('submissionClicked', { submissionId: {{$submission->id}} })">
                <i class="bi bi-check-circle"></i> Approve
            </button>
            
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" wire:click="$dispatch('submissionClicked', { submissionId: {{$submission->id}} })">
                <i class="bi bi-x-circle"></i> Reject
            </button>
            @endif
        </div>
    </div>
</div>