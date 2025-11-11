<div>
    @if($selectedSubmission)
    <div class="modal fade" id="viewSubmissionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submission by <span id="workerName">{{ $selectedSubmission->task_worker->user->username }}</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Worker Info -->
                    <div class="d-flex align-items-center mb-4">
                        <img class="rounded-circle me-3" src="{{ $selectedSubmission->task_worker->user->image }}" alt="{{ $selectedSubmission->task_worker->user->username }}" width="50" height="50">

                        <div>
                            <h5 class="mb-1">{{ $selectedSubmission->task_worker->user->username }}</h5>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted">(4.5) • 45 tasks completed</span>
                            </div>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-chat"></i>{{ $selectedSubmission->task_worker->user->country->iso2 }}
                            </button>
                        </div>
                    </div>

                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Submission Data -->
                    <h6>Submission Data</h6>
                    <div class="mb-4">
                        @if($selectedSubmission->submissions && is_array($selectedSubmission->submissions))
                        <div class="row g-3">
                            @foreach($selectedSubmission->submissions as $field => $value)
                            <div class="col-12">
                                <h6 class="fw-medium mb-2">{{ ucfirst(str_replace('_', ' ', $field)) }}</h6>
                                @if(is_array($value))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($value as $item)
                                    <span class="badge bg-light text-dark">{{ $item }}</span>
                                    @endforeach
                                </div>
                                @elseif(str_starts_with($value, 'storage/') || str_starts_with($value, 'public/'))
                                <a href="{{ Storage::url(str_replace(['storage/', 'public/'], '', $value)) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-file-line me-1"></i> View File
                                </a>
                                @else
                                <div class="p-3 bg-light rounded">{{ $value }}</div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            No submission data available
                        </div>
                        @endif
                    </div>

                    <!-- Review Section -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Review Submission</h6>
                        @if($selectedSubmission->reviewed_at)
                        <!-- Existing Review -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-check-line me-2 text-success"></i>
                                <strong>Reviewed on {{ $selectedSubmission->reviewed_at->format('M d, Y H:i') }}</strong>
                            </div>
                            @if($selectedSubmission->review)
                            <p class="mb-1"><strong>Review:</strong></p>
                            <p class="mb-0">{{ $selectedSubmission->review }}</p>
                            @endif
                            @if($selectedSubmission->review_reason)
                            <p class="mb-0 mt-2">
                                <strong>Reason:</strong>
                                @switch($selectedSubmission->review_reason)
                                @case(1)
                                <span class="badge bg-success">Approved</span>
                                @break
                                @case(2)
                                <span class="badge bg-warning">Needs Revision</span>
                                @break
                                @case(3)
                                <span class="badge bg-danger">Rejected</span>
                                @break
                                @default
                                <span class="badge bg-secondary">Unknown</span>
                                @endswitch
                            </p>
                            @endif

                            @if($selectedSubmission->review_reason == 2)
                            <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                <h6 class="text-warning mb-2">
                                    <i class="ri-error-warning-line me-2"></i>
                                    Revision Required
                                </h6>
                                <p class="mb-2">This submission has been marked for revision. The worker should review the feedback and resubmit their work.</p>
                                <button wire:click="resetSubmissionForRevision({{ $selectedSubmission->id }})" class="btn btn-warning btn-sm">
                                    <i class="ri-refresh-line me-1"></i> Reset for Revision
                                </button>
                            </div>
                            @endif
                        </div>
                        @else
                        <!-- Review Form -->
                        <form wire:submit="reviewSubmission">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="reviewReason" class="form-label">Review Decision</label>
                                    <select id="reviewReason" wire:model="reviewReason" class="form-select @error('reviewReason') is-invalid @enderror" required>
                                        <option value="">Select decision</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Needs Revision</option>
                                        <option value="3">Reject</option>
                                    </select>
                                    @error('reviewReason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="reviewText" class="form-label">Review Comments</label>
                                    <textarea id="reviewText" wire:model="reviewText" rows="4" class="form-control @error('reviewText') is-invalid @enderror" placeholder="Provide feedback on the submission..."></textarea>
                                    @error('reviewText') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="reviewSubmission">
                                        <span wire:loading.remove wire:target="reviewSubmission">
                                            <i class="ri-send-boostere-line me-1"></i> Submit Review
                                        </span>
                                        <span wire:loading wire:target="reviewSubmission">
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Submitting...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if(!$selectedSubmission->paid_at && $selectedSubmission->task_worker)
                    <div class="text-center">
                        @if($selectedSubmission->completed_at)
                        <button wire:click="disbursePaymentFromSubmission({{ $selectedSubmission->id }})" class="btn btn-success" wire:loading.attr="disabled" wire:target="disbursePaymentFromSubmission">
                            <span wire:loading.remove wire:target="disbursePaymentFromSubmission">
                                <i class="ri-money-dollar-circle-line me-1"></i> Disburse Payment
                            </span>
                            <span wire:loading wire:target="disbursePaymentFromSubmission">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Processing...
                            </span>
                        </button>
                        @else
                        <div class="alert alert-warning mb-0">
                            <i class="ri-information-line me-2"></i>
                            Submission must be approved before payment can be disbursed.
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this submission and release payment of <strong>$45</strong>?</p>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating">
                            <i class="bi bi-star fs-4 text-warning"></i>
                            <i class="bi bi-star fs-4 text-warning"></i>
                            <i class="bi bi-star fs-4 text-warning"></i>
                            <i class="bi bi-star fs-4 text-warning"></i>
                            <i class="bi bi-star fs-4"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review (Optional)</label>
                        <textarea class="form-control" rows="3" placeholder="Share your feedback about this work..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success">Approve & Pay $45</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Revision Modal -->
    <div class="modal fade" id="revisionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Revision</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>What changes would you like the worker to make?</p>
                    <div class="mb-3">
                        <label class="form-label">Revision Instructions *</label>
                        <textarea class="form-control" rows="4" placeholder="Be specific about what needs to be changed or improved..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline for Revision</label>
                        <input type="date" class="form-control" value="2023-10-20">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning">Request Revision</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Rejected submissions cannot be undone. The worker may dispute this decision.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection *</label>
                        <select class="form-select">
                            <option value="">Select a reason</option>
                            <option value="quality">Poor Quality Work</option>
                            <option value="requirements">Doesn't Meet Requirements</option>
                            <option value="deadline">Submitted After Deadline</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea class="form-control" rows="3" placeholder="Explain why the submission was rejected..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Reject Submission</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="disburseModal" tabindex="-1" aria-labelledby="disburseModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disburseModalLabel">Confirm Payment Disbursement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="ri-money-dollar-circle-line text-warning display-4"></i>
                    </div>
                    <p class="text-center">
                        Are you sure you want to disburse payment of <strong>{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_submission, 2) }}</strong> to <strong>{{ $selectedWorker->user->username ?? '' }}</strong>?
                    </p>
                    <p class="text-muted small text-center">
                        This action will create a settlement record and mark the task as paid for this worker.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="disbursePayment({{ $selectedWorker->id ?? '' }})" class="btn btn-success">Yes, Disburse Payment</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
</div>