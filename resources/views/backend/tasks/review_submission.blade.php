@push('styles')
<style>
	.badge.bg-outline-primary {
		background-color: transparent !important;
		color: var(--bs-primary) !important;
		border: 1px solid var(--bs-primary);
	}

	.table-hover tbody tr:hover {
		background-color: rgba(var(--bs-primary-rgb), 0.05) !important;
	}

	.card-body.py-2 {
		padding: 0.75rem !important;
	}

	.fs-1 {
		font-size: 2.5rem !important;
	}

	.btn-group-sm .btn {
		padding: 0.25rem 0.5rem;
	}

	.review-form-container {
		border: 1px solid #dee2e6;
		border-radius: 0.375rem;
		padding: 1rem;
		background-color: #f8f9fa;
	}
</style>
@endpush

@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Review Submission
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.tasks.submissions') }}">Task Submissions</a></li>
					<li class="breadcrumb-item active" aria-current="page">Review Submission</li>
				</ol>
			</nav>
		</div>

		<div class="row g-4">
			<div class="col-lg-8">
				<!-- Task Information Card -->
				<div class="card mb-4">
					<div class="card-header bg-primary text-white">
						<h5 class="card-title mb-0">
							<i class="ri-file-list-line me-2"></i>
							Task: {{ $submission->task->title }}
						</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<h6 class="text-muted mb-2">Task Details</h6>
								<p class="mb-2"><strong>Description:</strong> {{ Str::limit($submission->task->description, 150) }}</p>

								@if($submission->task->platform)
									<p class="mb-2"><strong>Platform:</strong>
										<span class="badge bg-outline-primary ms-1">{{ $submission->task->platform->name }}</span>
									</p>
								@endif

								<p class="mb-2">
									<strong>Budget per Person:</strong>
									{{ $submission->task->currency }} {{ number_format($submission->task->budget_per_person, 2) }}
								</p>

								<p class="mb-0">
									<strong>Monitoring Type:</strong>
									{{ ucfirst(str_replace('_', ' ', $submission->task->monitoring_type)) }}
								</p>
							</div>
							<div class="col-md-6">
								<h6 class="text-muted mb-2">Submission Info</h6>
								<div class="row g-2">
									<div class="col-6">
										<small class="text-muted">Submitted:</small>
										<div class="fw-semibold">{{ $submission->created_at->format('M d, Y H:i') }}</div>
									</div>
									<div class="col-6">
										<small class="text-muted">Status:</small>
										<div>
											@if($submission->completed_at)
												<span class="badge bg-success">Completed</span>
											@elseif($submission->disputed_at)
												@if($submission->resolved_at)
													<span class="badge bg-info">Dispute Resolved</span>
												@else
													<span class="badge bg-warning">Disputed</span>
												@endif
											@else
												<span class="badge bg-primary">Submitted</span>
											@endif
										</div>
									</div>
									<div class="col-12">
										<small class="text-muted">Worker:</small>
										<div class="fw-semibold">{{ $submission->user->name }}</div>
										<div class="text-muted small">{{ $submission->user->country->name ?? 'N/A' }}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Submission Data -->
				<div class="card mb-4">
					<div class="card-header">
						<h5 class="card-title mb-0">Submission Data</h5>
					</div>
					<div class="card-body">
						@if($submission->submissions && is_array($submission->submissions))
							<div class="row g-3">
								@foreach($submission->submissions as $field => $value)
								<div class="col-12">
									<h6 class="fw-medium mb-2">{{ ucfirst(str_replace('_', ' ', $field)) }}</h6>
									@if(is_array($value))
										<div class="d-flex flex-wrap gap-2">
											@foreach($value as $item)
											<span class="badge bg-light text-dark">{{ $item }}</span>
											@endforeach
										</div>
									@elseif(str_starts_with($value, 'storage/') || str_starts_with($value, 'public/uploads/'))
										<div class="border rounded p-3 bg-light">
											<div class="d-flex align-items-center">
												<i class="ri-file-line fs-3 text-primary me-3"></i>
												<div class="flex-grow-1">
													<strong>{{ basename($value) }}</strong>
													<div class="text-muted small">Submitted file</div>
												</div>
												<a href="{{ Storage::url(str_replace(['storage/', 'public/uploads/'], '', $value)) }}"
												   target="_blank" class="btn btn-outline-primary btn-sm">
													<i class="ri-eye-line me-1"></i> View File
												</a>
											</div>
										</div>
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
				</div>
			</div>

			<div class="col-lg-4">
				<!-- Quick Actions -->
				<div class="card mb-4">
					<div class="card-header">
						<h5 class="card-title mb-0">Quick Actions</h5>
					</div>
					<div class="card-body">
						<div class="d-grid gap-2">
							<a href="{{ route('admin.tasks.submissions') }}" class="btn btn-outline-secondary">
								<i class="ri-arrow-left-line me-1"></i> Back to Submissions
							</a>
							@if(!$submission->reviewed_at)
								<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
									<i class="ri-check-line me-1"></i> Approve Submission
								</button>
								<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal">
									<i class="ri-edit-line me-1"></i> Request Revision
								</button>
								<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
									<i class="ri-close-line me-1"></i> Reject Submission
								</button>
							@else
								<div class="alert alert-success">
									<i class="ri-check-circle-line me-2"></i>
									<strong>Already Reviewed</strong>
									<div class="small mb-2">
										Reviewed on {{ $submission->reviewed_at->format('M d, Y') }}
									</div>
									@if($submission->review_reason == 2)
										<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#resetModal">
											<i class="ri-refresh-line me-1"></i> Reset for Revision
										</button>
									@endif
								</div>
							@endif

							@if(!$submission->paid_at && $submission->completed_at)
								<hr>
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
									<i class="ri-money-dollar-circle-line me-1"></i> Process Payment
								</button>
							@endif
						</div>
					</div>
				</div>

				<!-- Status Overview -->
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Status Overview</h5>
					</div>
					<div class="card-body">
						<div class="row g-3">
							<div class="col-12">
								<div class="d-flex justify-content-between align-items-center mb-2">
									<span class="text-muted">Review Status:</span>
									@if($submission->reviewed_at)
										<span class="badge bg-success">Reviewed</span>
									@else
										<span class="badge bg-warning">Pending</span>
									@endif
								</div>
							</div>
							<div class="col-12">
								<div class="d-flex justify-content-between align-items-center mb-2">
									<span class="text-muted">Completion Status:</span>
									@if($submission->completed_at)
										<span class="badge bg-success">Completed</span>
									@else
										<span class="badge bg-secondary">Not Completed</span>
									@endif
								</div>
							</div>
							<div class="col-12">
								<div class="d-flex justify-content-between align-items-center mb-2">
									<span class="text-muted">Payment Status:</span>
									@if($submission->paid_at)
										<span class="badge bg-success">Paid</span>
									@elseif($submission->completed_at)
										<span class="badge bg-primary">Ready for Payment</span>
									@else
										<span class="badge bg-secondary">Not Eligible</span>
									@endif
								</div>
							</div>
							<div class="col-12">
								<div class="d-flex justify-content-between align-items-center mb-2">
									<span class="text-muted">Dispute Status:</span>
									@if($submission->disputed_at)
										@if($submission->resolved_at)
											<span class="badge bg-info">Resolved</span>
										@else
											<span class="badge bg-warning">Active</span>
										@endif
									@else
										<span class="badge bg-secondary">No Dispute</span>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="approveModalLabel">Approve Submission</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.tasks.review_submission.submit', $submission) }}" method="POST">
				@csrf
				<input type="hidden" name="review_reason" value="1">
				<div class="modal-body">
					<div class="alert alert-success">
						<i class="ri-check-circle-line me-2"></i>
						This will approve the submission and mark it as completed.
					</div>
					<div class="mb-3">
						<label for="review_text" class="form-label">Review Comments (Optional)</label>
						<textarea name="review" id="review_text" rows="3" class="form-control"
								placeholder="Add any feedback or notes..."></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success">Approve Submission</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="reviewModalLabel">Request Revision</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.tasks.review_submission.submit', $submission) }}" method="POST">
				@csrf
				<input type="hidden" name="review_reason" value="2">
				<div class="modal-body">
					<div class="alert alert-warning">
						<i class="ri-error-warning-line me-2"></i>
						The worker will be asked to revise and resubmit their work.
					</div>
					<div class="mb-3">
						<label for="revision_review" class="form-label">Revision Request</label>
						<textarea name="review" id="revision_review" rows="4" class="form-control" required
								placeholder="Explain what needs to be revised..."></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-warning">Request Revision</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="rejectModalLabel">Reject Submission</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.tasks.review_submission.submit', $submission) }}" method="POST">
				@csrf
				<input type="hidden" name="review_reason" value="3">
				<div class="modal-body">
					<div class="alert alert-danger">
						<i class="ri-close-circle-line me-2"></i>
						This will permanently reject the submission. The task worker slot will be freed up.
					</div>
					<div class="mb-3">
						<label for="reject_reason" class="form-label">Reason for Rejection</label>
						<textarea name="review" id="reject_reason" rows="4" class="form-control" required
								placeholder="Explain why this submission was rejected..."></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Reject Submission</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Reset Modal -->
@if($submission->reviewed_at && $submission->review_reason == 2)
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="resetModalLabel">Reset for Revision</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.tasks.review_submission.reset', $submission) }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="alert alert-info">
						<i class="ri-refresh-line me-2"></i>
						This will reset the submission back to pending review, allowing the worker to resubmit.
					</div>
					<p>Are you sure you want to reset this submission for revision?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-warning">Reset Submission</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif

<!-- Payment Modal -->
@if(!$submission->paid_at && $submission->completed_at)
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.tasks.review_submission.disburse', $submission) }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="alert alert-success">
						<i class="ri-money-dollar-circle-line me-2"></i>
						Process payment of <strong>{{ $submission->task->currency }} {{ number_format($submission->task->budget_per_person, 2) }}</strong> to {{ $submission->user->name }}
					</div>
					<p>This will:</p>
					<ul class="mb-0">
						<li>Create a settlement record</li>
						<li>Mark the submission as paid</li>
						<li>Add funds to the worker's wallet</li>
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success">Process Payment</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif

@endsection
