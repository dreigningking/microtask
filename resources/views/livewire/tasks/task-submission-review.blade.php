<div>
    <div wire:ignore.self class="modal fade" id="approveModal" tabindex="-1">
        <div wire:ignore.self class="modal-dialog">
            <div wire:ignore.self class="modal-content">
                @if($selectedSubmission)
                <div class="modal-header">
                    <h5 class="modal-title">Approve Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="approveSubmission">
                        <div class="mb-3">
                            <label class="form-label">Review (Optional)</label>
                            <textarea wire:model="reviewText" class="form-control" rows="3" placeholder="Share your feedback about this work..."></textarea>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">

                                <p>Are you sure you want to approve this submission and release payment of <strong>{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_submission, 2) }}</strong> to <strong>{{ $selectedWorker->user->username ?? '' }}</strong>?</p>

                                <div class="mb-3">
                                    <label class="form-label">Enter your password to continue</label>
                                    <input type="password" wire:model="password" class="form-control" placeholder="***********************" required>
                                    @error('password')
                                    <div class="text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve & Pay {{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_submission, 2) }}</button>
                        </div>
                    </form>
                </div>

                @endif
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="rejectModal" tabindex="-1">
        <div wire:ignore.self class="modal-dialog">
            <div wire:ignore.self class="modal-content">
                @if($selectedSubmission)
                <div class="modal-header">
                    <h5 class="modal-title">Reject Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="rejectSubmission">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Rejected submissions cannot be undone. The worker may dispute this decision.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rejection Notes *</label>
                            <textarea wire:model="reviewText" class="form-control" rows="3" placeholder="Explain why the submission was rejected..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input wire:model="preventFurtherSubmissions" type="checkbox" id="preventFurther" value="1" class="form-check-input border-2">
                                <label for="preventFurther" class="form-check-label">
                                    Prevent user from @if($task->allow_multiple_submissions) making additional submissions @else resubmitting @endif
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Submission</button>
                        </div>
                    </form>
                </div>

                @endif
            </div>
        </div>
    </div>


</div>