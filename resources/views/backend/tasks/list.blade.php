@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Tasks
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Tasks</a></li>
					<li class="breadcrumb-item active" aria-current="page">List</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Tasks</h5>
						<h6 class="card-subtitle text-muted">Manage and monitor task submissions with different monitoring types.</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" style="width:100%">
								<thead>
										<tr>
										<th>Title</th>
										<th>Owner</th>
										<th>Platform</th>
										<th>Workers</th>
										<th>Monitoring</th>
										<th>Admin Review</th>
										<th>Posted</th>
										<th>Payment</th>
										<th>Actions</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($tasks as $task)
									@php
										// Calculate monitoring status
										$submissions = $task->submissions ?? collect();
										$needsAdminReview = 0;
										$escalatedSubmissions = 0;
										
										if ($task->monitoring_type === 'admin_monitoring') {
											// All submissions need admin review
											$needsAdminReview = $submissions->where('reviewed_at', null)->count();
										} elseif ($task->monitoring_type === 'self_monitoring') {
											// Only escalated submissions need admin review
											$deadlineHours = \App\Models\Setting::where('name', 'submission_review_deadline')->value('value') ?? 24;
											$escalatedSubmissions = $submissions->filter(function($submission) use ($deadlineHours) {
												if ($submission->reviewed_at) return false;
												$expectedReviewTime = $submission->created_at->addHours($deadlineHours);
												return now()->isAfter($expectedReviewTime);
											})->count();
											$needsAdminReview = $escalatedSubmissions;
										}
									@endphp
									<tr>
										<td class="align-middle">
											<div class="d-flex align-items-center">
												<div class="flex-grow-1 text-nowrap">
													<strong>{{ $task->title }}</strong>
													@if($needsAdminReview > 0)
														<div class="text-danger small">
															<i class="ri-alert-line me-1"></i>{{ $needsAdminReview }} need{{ $needsAdminReview > 1 ? 's' : '' }} review
														</div>
													@endif
												</div>
											</div>
										</td>
										<td>{{ $task->user->name ?? '-' }}</td>
										<td>{{ $task->platform->name ?? '-' }}</td>
										<td>
											<span class="badge bg-primary">{{ $task->workers()->whereNotNull('accepted_at')->count() }} / {{ $task->number_of_people }}</span>
										</td>
										<td>
											@if($task->monitoring_type === 'self_monitoring')
												<span class="badge bg-success">
													<i class="ri-user-line me-1"></i>Self
												</span>
												@if($escalatedSubmissions > 0)
													<div class="text-warning small mt-1">
														<i class="ri-arrow-up-line me-1"></i>{{ $escalatedSubmissions }} escalated
													</div>
												@endif
											@elseif($task->monitoring_type === 'admin_monitoring')
												<span class="badge bg-warning">
													<i class="ri-shield-user-line me-1"></i>Admin
												</span>
											@elseif($task->monitoring_type === 'system_monitoring')
												<span class="badge bg-info">
													<i class="ri-cpu-line me-1"></i>System
												</span>
											@endif
										</td>
										<td>
											@if($needsAdminReview > 0)
												<span class="badge bg-danger">
													<i class="ri-time-line me-1"></i>{{ $needsAdminReview }} pending
												</span>
											@else
												<span class="badge bg-success">
													<i class="ri-check-line me-1"></i>All reviewed
												</span>
											@endif
										</td>
										<td>{{ $task->created_at->format('Y/m/d') }}</td>
										<td>{{ $task->currency }} {{ number_format($task->budget_per_person, 2) }}</td>
										<td>
											<div class="d-flex gap-1">
												<a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-primary btn-sm">
													<i class="ri-eye-line me-1"></i>View
												</a>
												@if($needsAdminReview > 0)
													<a href="{{ route('admin.tasks.show', $task) }}#admin-review" class="btn btn-warning btn-sm">
														<i class="ri-shield-check-line me-1"></i>Review
													</a>
												@endif
												@if(!$task->is_active)
													<form action="{{ route('admin.tasks.approve') }}" method="POST" class="d-inline-block">
														@csrf
														<input type="hidden" name="task_id" value="{{ $task->id }}">
														<button type="submit" class="btn btn-success btn-sm">
															<i class="ri-check-line me-1"></i>Approve
														</button>
													</form>
												@else
													<form action="{{ route('admin.tasks.disapprove') }}" method="POST" class="d-inline-block">
														@csrf
														<input type="hidden" name="task_id" value="{{ $task->id }}">
														<button type="submit" class="btn btn-warning btn-sm">
															<i class="ri-close-line me-1"></i>Disapprove
														</button>
													</form>
												@endif
												<form action="{{ route('admin.tasks.delete') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this task? This action cannot be undone.');">
													@csrf
													<input type="hidden" name="task_id" value="{{ $task->id }}">
													<button type="submit" class="btn btn-danger btn-sm">
														<i class="ri-delete-bin-line me-1"></i>Delete
													</button>
												</form>
											</div>
										</td>
										<td></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-between align-items-center">
							<div class="pagination-info mb-0">
								Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
							</div>
							@if ($tasks->hasPages())
								<nav>
									<ul class="pagination mb-0">
										{{-- Previous Page Link --}}
										@if ($tasks->onFirstPage())
											<li class="page-item disabled"><span class="page-link">&laquo;</span></li>
										@else
											<li class="page-item">
												<a class="page-link" href="{{ $tasks->previousPageUrl() }}" rel="prev">&laquo;</a>
											</li>
										@endif

										{{-- Pagination Elements --}}
										@foreach ($tasks->links()->elements[0] as $page => $url)
											@if ($page == $tasks->currentPage())
												<li class="page-item active"><span class="page-link">{{ $page }}</span></li>
											@else
												<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
											@endif
										@endforeach

										{{-- Next Page Link --}}
										@if ($tasks->hasMorePages())
											<li class="page-item">
												<a class="page-link" href="{{ $tasks->nextPageUrl() }}" rel="next">&raquo;</a>
											</li>
										@else
											<li class="page-item disabled"><span class="page-link">&raquo;</span></li>
										@endif
									</ul>
								</nav>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

@push('scripts')
<script>
	$(function() {
		/* Datatables basic
		$('#datatables-basic').DataTable({
			responsive: true,
			columnDefs: [
				{
					targets: -1, // Actions column
					orderable: false,
					searchable: false,
					width: '200px'
				},
				{
					targets: 4, // Monitoring column
					width: '120px'
				},
				{
					targets: 5, // Admin Review column
					width: '130px'
				},
				{
					targets: 3, // Workers column
					width: '100px'
				}
			],
			order: [[6, 'desc']], // Sort by posted date descending
			pageLength: 25,
			language: {
				search: "Search tasks:",
				lengthMenu: "Show _MENU_ tasks per page",
				info: "Showing _START_ to _END_ of _TOTAL_ tasks",
				infoEmpty: "Showing 0 to 0 of 0 tasks",
				infoFiltered: "(filtered from _MAX_ total tasks)"
			}
		});
		*/
	});
</script>
@endpush