<div class="submission-card card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center">
                @if($submission->task_worker && $submission->task_worker->user)
                <img class="rounded-circle me-3" src="{{ $submission->task_worker->user->image }}" alt="{{ $submission->task_worker->user->username }}">
                
                <div>
                    <h6 class="mb-1">{{ $submission->task_worker->user->username }} - {{ $submission->task_worker->user->country->name ?? 'N/A' }}</h6>
                    <div class="text-warning small">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <span class="text-muted">(4.5) • 45 tasks completed</span>
                    </div>
                </div>
            </div>
            <div class="text-end">
                @if(!$submission->accepted)
                <span class="badge bg-warning status-badge">Pending Review</span>
                <div class="text-muted small">Submitted: {{ $selectedSubmission->created_at->format('M d, Y H:i') }}</div>
                @elseif($submission->accepted)
                <span class="badge bg-success status-badge">Approved & Paid</span>
                <div class="text-muted small">Approved at: {{ $selectedSubmission->paid_at->format('M d, Y H:i') }}</div>
                @else
                <span class="badge bg-danger status-badge">Disputed</span>
                <div class="text-muted small">Disputed on: {{ $selectedSubmission->dispute->created_at->format('M d, Y H:i') }}</div>
                @endif
            </div>
        </div>
        @if(!$submission->accepted)
        <h6>Submission Preview</h6>
        <div class="submission-preview border rounded p-3 bg-light mb-3">
            <p><strong>Submission Notes:</strong> "I've created 5 Instagram posts following your brand guidelines. Each post includes high-quality images, engaging captions about coffee culture, and relevant hashtags."</p>
            <p><strong>Files:</strong> instagram_posts_package.zip (5 images + captions document)</p>
            <p><strong>Links:</strong> https://drive.google.com/... (preview link)</p>
        </div>
        @endif
        @elseif($submission->accepted)
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> You approved this submission and paid $45 to Emily Davis.
            <div class="mt-1">
                <strong>Your Rating:</strong>
                <span class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </span>
            </div>
            <div class="mt-1">
                <strong>Your Review:</strong> "Excellent work! Exactly what I was looking for. Will hire again!"
            </div>
        </div>
        @else
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i> This submission is under dispute resolution.
            <div class="mt-1">
                <strong>Worker's Claim:</strong> "The client rejected my work without valid reasons. The submission meets all requirements stated in the task."
            </div>
            <div class="mt-1">
                <strong>Admin Status:</strong> Under review
            </div>
        </div>
        @endif

        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewSubmissionModal" wire:click="$dispatch('submissionClicked', { submission: @js($submission) })">
                <i class="bi bi-eye"></i> View Full Submission
            </button>
            @if(!$submission->accepted)
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                <i class="bi bi-check-circle"></i> Approve
            </button>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#revisionModal">
                <i class="bi bi-arrow-clockwise"></i> Request Revision
            </button>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="bi bi-x-circle"></i> Reject
            </button>
            @endif
        </div>
    </div>
</div>