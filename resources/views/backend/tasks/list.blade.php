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
	
	.filter-loading {
		opacity: 0.6;
		pointer-events: none;
	}
	
	.filter-loading::after {
		content: '';
		position: absolute;
		top: 50%;
		left: 50%;
		width: 20px;
		height: 20px;
		margin: -10px 0 0 -10px;
		border: 2px solid #f3f3f3;
		border-top: 2px solid var(--bs-primary);
		border-radius: 50%;
		animation: spin 1s linear infinite;
	}
	
	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	
	.quick-filter-badge {
		transition: all 0.2s ease;
	}
	
	.quick-filter-badge:hover {
		transform: translateY(-1px);
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}
</style>
@endpush

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

		<!-- Help Section -->
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">
							<a class="text-decoration-none" data-bs-toggle="collapse" href="#helpSection" role="button" aria-expanded="false" aria-controls="helpSection">
								<i class="ri-question-line me-2"></i>Filter Help & Tips
								<i class="ri-arrow-down-s-line float-end"></i>
							</a>
						</h5>
					</div>
					<div class="collapse" id="helpSection">
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<h6><i class="ri-search-line me-2"></i>Search & Basic Filters</h6>
									<ul class="list-unstyled">
										<li><strong>Search:</strong> Type in the search box to find tasks by title or description</li>
										<li><strong>Country:</strong> Filter by country (Super Admin only)</li>
										<li><strong>Platform:</strong> Filter by task platform (e.g., Instagram, Facebook)</li>
										<li><strong>Monitoring:</strong> Filter by monitoring type (Self, Admin, or System)</li>
										<li><strong>Status:</strong> Filter by task status (Active, Inactive, Pending Approval, Approved)</li>
									</ul>
								</div>
								<div class="col-md-6">
									<h6><i class="ri-filter-line me-2"></i>Advanced Filters</h6>
									<ul class="list-unstyled">
										<li><strong>Date Range:</strong> Filter tasks by creation date</li>
										<li><strong>Budget Range:</strong> Filter by budget per person</li>
										<li><strong>Sorting:</strong> Sort by date, title, budget, or worker count</li>
										<li><strong>Quick Actions:</strong> Use keyboard shortcuts (Ctrl+F for search, Ctrl+E for export)</li>
									</ul>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-12">
									<h6><i class="ri-lightbulb-line me-2"></i>Pro Tips</h6>
									<div class="alert alert-info mb-0">
										<ul class="mb-0">
											<li>Filters auto-apply when you change dropdowns (Platform, Monitoring, Status, Sort)</li>
											<li>Search has a 500ms delay to avoid excessive requests</li>
											<li>Use the export feature to download filtered results as CSV</li>
											<li>Click on filter badges to remove individual filters</li>
											<li>Hover over table rows to see more details</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Search and Filter Form -->
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Search & Filters</h5>
					</div>
					<div class="card-body">
						<form method="GET" action="{{ route('admin.tasks.index') }}" id="taskFiltersForm">
							<div class="row g-3">
								<!-- Search Input -->
								<div class="col-md-4">
									<label for="search" class="form-label">Search</label>
									<input type="text" class="form-control" id="search" name="search" 
										   value="{{ request('search') }}" placeholder="Search by title or description...">
								</div>

								<!-- Country Filter (Super Admin Only) -->
								@if(auth()->user()->first_role->name === 'super-admin')
								<div class="col-md-3">
									<label for="country_id" class="form-label">Country</label>
									<select class="form-select" id="country_id" name="country_id">
										<option value="">All Countries</option>
										@foreach($countries as $country)
											<option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
												{{ $country->name }}
											</option>
										@endforeach
									</select>
								</div>
								@endif

								<!-- Platform Filter -->
								<div class="col-md-3">
									<label for="platform_id" class="form-label">Platform</label>
									<select class="form-select" id="platform_id" name="platform_id">
										<option value="">All Platforms</option>
										@foreach($platforms as $platform)
											<option value="{{ $platform->id }}" {{ request('platform_id') == $platform->id ? 'selected' : '' }}>
												{{ $platform->name }}
											</option>
										@endforeach
									</select>
								</div>

								<!-- Monitoring Type Filter -->
								<div class="col-md-3">
									<label for="monitoring_type" class="form-label">Monitoring Type</label>
									<select class="form-select" id="monitoring_type" name="monitoring_type">
										<option value="">All Types</option>
										@foreach($monitoringTypes as $key => $label)
											<option value="{{ $key }}" {{ request('monitoring_type') == $key ? 'selected' : '' }}>
												{{ $label }}
											</option>
										@endforeach
									</select>
								</div>

								<!-- Status Filter -->
								<div class="col-md-3">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" id="status" name="status">
										<option value="">All Statuses</option>
										<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
										<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
										<option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
										<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
									</select>
								</div>

								<!-- Date Range Filters -->
								<div class="col-md-3">
									<label for="date_from" class="form-label">Date From</label>
									<input type="date" class="form-control" id="date_from" name="date_from" 
										   value="{{ request('date_from') }}">
								</div>

								<div class="col-md-3">
									<label for="date_to" class="form-label">Date To</label>
									<input type="date" class="form-control" id="date_to" name="date_to" 
										   value="{{ request('date_to') }}">
								</div>

								<!-- Budget Range Filters -->
								<div class="col-md-3">
									<label for="budget_min" class="form-label">Min Budget</label>
									<input type="number" class="form-control" id="budget_min" name="budget_min" 
										   value="{{ request('budget_min') }}" step="0.01" min="0" placeholder="0.00">
								</div>

								<div class="col-md-3">
									<label for="budget_max" class="form-label">Max Budget</label>
									<input type="number" class="form-control" id="budget_max" name="budget_max" 
										   value="{{ request('budget_max') }}" step="0.01" min="0" placeholder="0.00">
								</div>

								<!-- Sort Options -->
								<div class="col-md-3">
									<label for="sort_by" class="form-label">Sort By</label>
									<select class="form-select" id="sort_by" name="sort_by">
										<option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Posted Date</option>
										<option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
										<option value="budget_per_person" {{ request('sort_by') == 'budget_per_person' ? 'selected' : '' }}>Budget</option>
										<option value="number_of_people" {{ request('sort_by') == 'number_of_people' ? 'selected' : '' }}>Workers</option>
									</select>
								</div>

								<div class="col-md-3">
									<label for="sort_order" class="form-label">Sort Order</label>
									<select class="form-select" id="sort_order" name="sort_order">
										<option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
										<option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
									</select>
								</div>

								<!-- Action Buttons -->
								<div class="col-12">
									<div class="d-flex gap-2">
										<button type="submit" class="btn btn-primary" id="applyFiltersBtn">
											<i class="ri-search-line me-1"></i>Apply Filters
										</button>
										<a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
											<i class="ri-refresh-line me-1"></i>Clear Filters
										</a>
										<button type="button" class="btn btn-outline-info" id="exportBtn">
											<i class="ri-download-line me-1"></i>Export
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Active Filters Display -->
		@if(request()->hasAny(['search', 'country_id', 'platform_id', 'monitoring_type', 'status', 'date_from', 'date_to', 'budget_min', 'budget_max']))
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-body py-2">
						<div class="d-flex align-items-center gap-2 flex-wrap">
							<small class="text-muted me-2">Active Filters:</small>
							
							@if(request('search'))
							<span class="badge bg-primary d-flex align-items-center gap-1 quick-filter-badge">
								Search: "{{ request('search') }}"
								<a href="{{ route('admin.tasks.index', request()->except('search')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('country_id') && auth()->user()->first_role->name === 'super-admin')
							<span class="badge bg-info d-flex align-items-center gap-1 quick-filter-badge">
								Country: {{ $countries->firstWhere('id', request('country_id'))->name ?? 'Unknown' }}
								<a href="{{ route('admin.tasks.index', request()->except('country_id')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('platform_id'))
							<span class="badge bg-success d-flex align-items-center gap-1 quick-filter-badge">
								Platform: {{ $platforms->firstWhere('id', request('platform_id'))->name ?? 'Unknown' }}
								<a href="{{ route('admin.tasks.index', request()->except('platform_id')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('monitoring_type'))
							<span class="badge bg-warning d-flex align-items-center gap-1 quick-filter-badge">
								Monitoring: {{ $monitoringTypes[request('monitoring_type')] ?? 'Unknown' }}
								<a href="{{ route('admin.tasks.index', request()->except('monitoring_type')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('status'))
							<span class="badge bg-secondary d-flex align-items-center gap-1 quick-filter-badge">
								Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
								<a href="{{ route('admin.tasks.index', request()->except('status')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('date_from') || request('date_to'))
							<span class="badge bg-dark d-flex align-items-center gap-1 quick-filter-badge">
								Date: {{ request('date_from', 'Any') }} to {{ request('date_to', 'Any') }}
								<a href="{{ route('admin.tasks.index', request()->except(['date_from', 'date_to'])) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('budget_min') || request('budget_max'))
							<span class="badge bg-primary d-flex align-items-center gap-1 quick-filter-badge">
								Budget: {{ request('budget_min', 'Any') }} to {{ request('budget_max', 'Any') }}
								<a href="{{ route('admin.tasks.index', request()->except(['budget_min', 'budget_max'])) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							<a href="{{ route('admin.tasks.index') }}" class="badge bg-danger text-decoration-none quick-filter-badge">
								Clear All Filters
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Tasks</h5>
						<h6 class="card-subtitle text-muted">Manage and monitor task submissions with different monitoring types.</h6>
					</div>
					<div class="card-body">
						<!-- Results Summary -->
						@if(request()->hasAny(['search', 'country_id', 'platform_id', 'monitoring_type', 'status', 'date_from', 'date_to', 'budget_min', 'budget_max']))
						<div class="alert alert-info mb-3">
							<strong>Filtered Results:</strong> 
							Showing {{ $tasks->total() }} task(s) matching your criteria
							@if(request('search'))
								• Search: "{{ request('search') }}"
							@endif
							@if(request('country_id') && auth()->user()->first_role->name === 'super-admin')
								• Country: {{ $countries->firstWhere('id', request('country_id'))->name ?? 'Unknown' }}
							@endif
							@if(request('platform_id'))
								• Platform: {{ $platforms->firstWhere('id', request('platform_id'))->name ?? 'Unknown' }}
							@endif
							@if(request('monitoring_type'))
								• Monitoring: {{ $monitoringTypes[request('monitoring_type')] ?? 'Unknown' }}
							@endif
							@if(request('status'))
								• Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
							@endif
						</div>
						@endif

						<!-- Summary Statistics -->
						<div class="row mb-3">
							<div class="col-md-3">
								<div class="card bg-primary text-white">
									<div class="card-body py-2">
										<div class="d-flex align-items-center">
											<div class="flex-grow-1">
												<h6 class="mb-0">Total Tasks</h6>
												<h4 class="mb-0">{{ $tasks->total() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-task-line fs-1"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card bg-success text-white">
									<div class="card-body py-2">
										<div class="d-flex align-items-center">
											<div class="flex-grow-1">
												<h6 class="mb-0">Active Tasks</h6>
												<h4 class="mb-0">{{ $tasks->where('is_active', 1)->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-check-line fs-1"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card bg-warning text-white">
									<div class="card-body py-2">
										<div class="d-flex align-items-center">
											<div class="flex-grow-1">
												<h6 class="mb-0">Pending Review</h6>
												<h4 class="mb-0">{{ $tasks->filter(function($task) {
													$submissions = $task->submissions ?? collect();
													if ($task->monitoring_type === 'admin_monitoring') {
														return $submissions->where('reviewed_at', null)->count() > 0;
													} elseif ($task->monitoring_type === 'self_monitoring') {
														$deadlineHours = \App\Models\Setting::where('name', 'submission_review_deadline')->value('value') ?? 24;
														return $submissions->filter(function($submission) use ($deadlineHours) {
															if ($submission->reviewed_at) return false;
															$expectedReviewTime = $submission->created_at->addHours($deadlineHours);
															return now()->isAfter($expectedReviewTime);
														})->count() > 0;
													}
													return false;
												})->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-time-line fs-1"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card bg-info text-white">
									<div class="card-body py-2">
										<div class="d-flex align-items-center">
											<div class="flex-grow-1">
												<h6 class="mb-0">This Page</h6>
												<h4 class="mb-0">{{ $tasks->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-file-list-line fs-1"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width:100%">
								<thead class="table-dark">
									<tr>
										<th style="width: 20%">Task Details</th>
										<th style="width: 12%">Owner & Country</th>
										<th style="width: 10%">Platform</th>
										<th style="width: 8%">Workers</th>
										<th style="width: 12%">Monitoring</th>
										<th style="width: 12%">Admin Review</th>
										<th style="width: 8%">Posted</th>
										<th style="width: 8%">Payment</th>
										<th style="width: 10%">Actions</th>
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
										<td>
											<div class="d-flex align-items-start">
												<div class="flex-grow-1">
													<div class="fw-bold text-primary mb-1">{{ $task->title }}</div>
													<div class="text-muted small mb-2">
														{{ Str::limit($task->description, 100) }}
													</div>
													<div class="d-flex gap-2 flex-wrap">
														@if($task->is_active)
															<span class="badge bg-success">Active</span>
														@else
															<span class="badge bg-secondary">Inactive</span>
														@endif
														@if($task->approved_at)
															<span class="badge bg-info">Approved</span>
														@else
															<span class="badge bg-warning">Pending Approval</span>
														@endif
													</div>
													@if($needsAdminReview > 0)
														<div class="text-danger small mt-1">
															<i class="ri-alert-line me-1"></i>{{ $needsAdminReview }} need{{ $needsAdminReview > 1 ? 's' : '' }} review
														</div>
													@endif
												</div>
											</div>
										</td>
										<td>
											<div class="d-flex flex-column">
												<div class="fw-bold">{{ $task->user->name ?? 'N/A' }}</div>
												<div class="text-muted small">
													@if(auth()->user()->first_role->name === 'super-admin' && $task->user)
														{{ $task->user->country->name ?? 'Unknown Country' }}
													@endif
												</div>
											</div>
										</td>
										<td>
											@if($task->platform)
												<span class="badge bg-outline-primary">{{ $task->platform->name }}</span>
											@else
												<span class="text-muted">-</span>
											@endif
										</td>
										<td>
											<div class="text-center">
												<span class="badge bg-primary fs-6">
													{{ $task->workers()->whereNotNull('accepted_at')->count() }} / {{ $task->number_of_people }}
												</span>
											</div>
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
											@else
												<span class="text-muted">-</span>
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
										<td>
											<div class="text-center">
												<div class="fw-bold">{{ $task->created_at->format('M d') }}</div>
												<div class="text-muted small">{{ $task->created_at->format('Y') }}</div>
											</div>
										</td>
										<td>
											<div class="text-center">
												<div class="fw-bold">{{ $task->currency }} {{ number_format($task->budget_per_person, 2) }}</div>
												<div class="text-muted small">per person</div>
											</div>
										</td>
										<td>
											<div class="d-flex flex-column gap-1">
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
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $tasks])
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
		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#taskFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Auto-submit form when certain filters change
		$('#platform_id, #monitoring_type, #status, #sort_by, #sort_order').on('change', function() {
			setFormLoading(true);
			$('#taskFiltersForm').submit();
		});

		// Export functionality
		$('#exportBtn').on('click', function() {
			const btn = $(this);
			const originalText = btn.html();
			
			btn.prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Exporting...');
			
			try {
				const form = $('#taskFiltersForm')[0];
				const formData = new FormData(form);
				
				// Add export parameter
				formData.append('export', 'csv');
				
				// Create a temporary form for export
				const exportForm = document.createElement('form');
				exportForm.method = 'POST';
				exportForm.action = '{{ route("admin.tasks.index") }}';
				exportForm.target = '_blank';
				
				// Add CSRF token
				const csrfToken = document.createElement('input');
				csrfToken.type = 'hidden';
				csrfToken.name = '_token';
				csrfToken.value = '{{ csrf_token() }}';
				exportForm.appendChild(csrfToken);
				
				// Add method override
				const methodField = document.createElement('input');
				methodField.type = 'hidden';
				methodField.name = '_method';
				methodField.value = 'GET';
				exportForm.appendChild(methodField);
				
				// Add all form data
				for (let [key, value] of formData.entries()) {
					if (value) {
						const input = document.createElement('input');
						input.type = 'hidden';
						input.name = key;
						input.value = value;
						exportForm.appendChild(input);
					}
				}
				
				document.body.appendChild(exportForm);
				exportForm.submit();
				document.body.removeChild(exportForm);
				
				// Show success message
				showNotification('Export started successfully!', 'success');
				
			} catch (error) {
				console.error('Export error:', error);
				showNotification('Export failed. Please try again.', 'error');
			} finally {
				btn.prop('disabled', false).html(originalText);
			}
		});

		// Date range validation
		$('#date_from, #date_to').on('change', function() {
			const dateFrom = $('#date_from').val();
			const dateTo = $('#date_to').val();
			
			if (dateFrom && dateTo && dateFrom > dateTo) {
				showNotification('Start date cannot be after end date', 'warning');
				$(this).val('');
			}
		});

		// Budget range validation
		$('#budget_min, #budget_max').on('change', function() {
			const budgetMin = parseFloat($('#budget_min').val()) || 0;
			const budgetMax = parseFloat($('#budget_max').val()) || 0;
			
			if (budgetMin > 0 && budgetMax > 0 && budgetMin > budgetMax) {
				showNotification('Minimum budget cannot be greater than maximum budget', 'warning');
				$(this).val('');
			}
		});

		// Search with debounce
		let searchTimeout;
		$('#search').on('input', function() {
			clearTimeout(searchTimeout);
			searchTimeout = setTimeout(function() {
				setFormLoading(true);
				$('#taskFiltersForm').submit();
			}, 500);
		});

		// Clear individual filters
		$('.clear-filter').on('click', function() {
			const filterName = $(this).data('filter');
			$('#' + filterName).val('');
			setFormLoading(true);
			$('#taskFiltersForm').submit();
		});

		// Form submission
		$('#taskFiltersForm').on('submit', function() {
			setFormLoading(true);
		});

		// Initialize tooltips
		$('[data-bs-toggle="tooltip"]').tooltip();

		// Notification function
		function showNotification(message, type = 'info') {
			const alertClass = type === 'error' ? 'alert-danger' : 
							  type === 'warning' ? 'alert-warning' : 
							  type === 'success' ? 'alert-success' : 'alert-info';
			
			const alert = $(`
				<div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
					 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
					${message}
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			`);
			
			$('body').append(alert);
			
			// Auto-dismiss after 5 seconds
			setTimeout(() => {
				alert.alert('close');
			}, 5000);
		}

		// Add quick filter functionality
		$('.quick-filter-badge a').on('click', function(e) {
			e.preventDefault();
			const href = $(this).attr('href');
			setFormLoading(true);
			window.location.href = href;
		});

		// Keyboard shortcuts
		$(document).on('keydown', function(e) {
			// Ctrl/Cmd + F to focus search
			if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
				e.preventDefault();
				$('#search').focus();
			}
			
			// Ctrl/Cmd + E to export
			if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
				e.preventDefault();
				$('#exportBtn').click();
			}
		});

		// Show keyboard shortcuts help
		$('#search').attr('title', 'Press Ctrl+F to focus');
		$('#exportBtn').attr('title', 'Press Ctrl+E to export');

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