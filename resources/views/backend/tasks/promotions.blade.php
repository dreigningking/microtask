@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Task Promotions
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Tasks</a></li>
					<li class="breadcrumb-item active" aria-current="page">Promotions</li>
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
										<li><strong>Search:</strong> Type in the search box to find promotions by task title or description</li>
										<li><strong>Country:</strong> Filter by country (Super Admin only)</li>
										<li><strong>Type:</strong> Filter by promotion type</li>
										<li><strong>Status:</strong> Filter by promotion status (Running or Finished)</li>
									</ul>
								</div>
								<div class="col-md-6">
									<h6><i class="ri-filter-line me-2"></i>Advanced Filters</h6>
									<ul class="list-unstyled">
										<li><strong>Date Range:</strong> Filter promotions by creation date</li>
										<li><strong>Cost Range:</strong> Filter by promotion cost</li>
										<li><strong>Sorting:</strong> Sort by date, cost, or type</li>
										<li><strong>Quick Actions:</strong> Use keyboard shortcuts (Ctrl+F for search)</li>
									</ul>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-12">
									<h6><i class="ri-lightbulb-line me-2"></i>Pro Tips</h6>
									<div class="alert alert-info mb-0">
										<ul class="mb-0">
											<li>Click "Apply Filters" button to apply your filter selections</li>
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
						<form method="GET" action="{{ route('admin.tasks.promotions') }}" id="promotionFiltersForm">
							<div class="row g-3">
								<!-- Search Input -->
								<div class="col-md-4">
									<label for="search" class="form-label">Search</label>
									<input type="text" class="form-control" id="search" name="search"
										value="{{ request('search') }}" placeholder="Search by task title or description...">
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

								<!-- Promotion Type Filter -->
								<div class="col-md-3">
									<label for="type" class="form-label">Promotion Type</label>
									<select class="form-select" id="type" name="type">
										<option value="">All Types</option>
										@foreach($promotionTypes as $type)
										<option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
											{{ ucfirst($type) }}
										</option>
										@endforeach
									</select>
								</div>

								<!-- Status Filter -->
								<div class="col-md-3">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" id="status" name="status">
										<option value="">All Statuses</option>
										<option value="running" {{ is_string(request('status')) && request('status') == 'running' ? 'selected' : '' }}>Running</option>
										<option value="finished" {{ is_string(request('status')) && request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
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

								<!-- Cost Range Filters -->
								<div class="col-md-3">
									<label for="cost_min" class="form-label">Min Cost</label>
									<input type="number" class="form-control" id="cost_min" name="cost_min"
										value="{{ request('cost_min') }}" step="0.01" min="0" placeholder="0.00">
								</div>

								<div class="col-md-3">
									<label for="cost_max" class="form-label">Max Cost</label>
									<input type="number" class="form-control" id="cost_max" name="cost_max"
										value="{{ request('cost_max') }}" step="0.01" min="0" placeholder="0.00">
								</div>

								<!-- Sort Options -->
								<div class="col-md-3">
									<label for="sort_by" class="form-label">Sort By</label>
									<select class="form-select" id="sort_by" name="sort_by">
										<option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Created Date</option>
										<option value="cost" {{ request('sort_by') == 'cost' ? 'selected' : '' }}>Cost</option>
										<option value="type" {{ request('sort_by') == 'type' ? 'selected' : '' }}>Type</option>
										<option value="end_at" {{ request('sort_by') == 'end_at' ? 'selected' : '' }}>End Date</option>
									</select>
								</div>

								<div class="col-md-3">
									<label for="sort_order" class="form-label">Sort Order</label>
									<select class="form-select" id="sort_order" name="sort_order">
										<option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
										<option value="asc" {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
									</select>
								</div>

								<!-- Action Buttons -->
								<div class="col-12">
									<div class="d-flex gap-2">
										<button type="submit" class="btn btn-primary" id="applyFiltersBtn">
											<i class="ri-search-line me-1"></i>Apply Filters
										</button>
										<a href="{{ route('admin.tasks.promotions') }}" class="btn btn-secondary">
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
		@if(request()->hasAny(['search', 'country_id', 'type', 'status', 'date_from', 'date_to', 'cost_min', 'cost_max']))
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-body py-2">
						<div class="d-flex align-items-center gap-2 flex-wrap">
							<small class="text-muted me-2">Active Filters:</small>

							@if(request('search'))
								@php
									$searchValue = is_array(request('search')) ? (request('search')[0] ?? '') : request('search');
								@endphp
								@if($searchValue)
								<span class="badge bg-primary d-flex align-items-center gap-1 quick-filter-badge">
									Search: "{{ $searchValue }}"
																	<a href="?{{ http_build_query(request()->except('search')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
								</span>
								@endif
							@endif

							@if(request('country_id') && auth()->user()->first_role->name === 'super-admin')
								@php
									$countryIdValue = is_array(request('country_id')) ? (request('country_id')[0] ?? '') : request('country_id');
								@endphp
								@if($countryIdValue)
								<span class="badge bg-info d-flex align-items-center gap-1 quick-filter-badge">
									Country: {{ $countries->firstWhere('id', $countryIdValue)->name ?? 'Unknown' }}
																	<a href="?{{ http_build_query(request()->except('country_id')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
								</span>
								@endif
							@endif

							@if(request('type'))
								@php
									$typeValue = is_array(request('type')) ? (request('type')[0] ?? '') : request('type');
								@endphp
								@if($typeValue)
								<span class="badge bg-success d-flex align-items-center gap-1 quick-filter-badge">
									Type: {{ ucfirst($typeValue) }}
																	<a href="?{{ http_build_query(request()->except('type')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
								</span>
								@endif
							@endif

							@if(request('status'))
								@php
									$statusValue = is_array(request('status')) ? (request('status')[0] ?? '') : request('status');
								@endphp
								@if($statusValue)
								<span class="badge bg-warning d-flex align-items-center gap-1 quick-filter-badge">
									Status: {{ ucfirst($statusValue) }}
																	<a href="?{{ http_build_query(request()->except('status')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
								</span>
								@endif
							@endif

							@if(request('date_from') || request('date_to'))
							<span class="badge bg-dark d-flex align-items-center gap-1 quick-filter-badge">
								Date: {{ request('date_from', 'Any') }} to {{ request('date_to', 'Any') }}
								<a href="?{{ http_build_query(request()->except(['date_from', 'date_to'])) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('cost_min') || request('cost_max'))
							<span class="badge bg-primary d-flex align-items-center gap-1 quick-filter-badge">
								Cost: {{ request('cost_min', 'Any') }} to {{ request('cost_max', 'Any') }}
								<a href="?{{ http_build_query(request()->except(['cost_min', 'cost_max'])) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							<a href="{{ route('admin.tasks.promotions') }}" class="badge bg-danger text-decoration-none quick-filter-badge">
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
						<h5 class="card-title">Task Promotions</h5>
						<h6 class="card-subtitle text-muted">Manage and monitor task promotions with comprehensive filtering.</h6>
					</div>
					<div class="card-body">
						<!-- Results Summary -->
						@if(request()->hasAny(['search', 'country_id', 'type', 'status', 'date_from', 'date_to', 'cost_min', 'cost_max']))
						<div class="alert alert-info mb-3">
							<strong>Filtered Results:</strong>
							Showing {{ $promotions->total() }} promotion(s) matching your criteria
							@if(request('search'))
								@php
									$searchValue = is_array(request('search')) ? (request('search')[0] ?? '') : request('search');
								@endphp
								@if($searchValue)
								• Search: "{{ $searchValue }}"
								@endif
							@endif
							@if(request('country_id') && auth()->user()->first_role->name === 'super-admin')
								@php
									$countryIdValue = is_array(request('country_id')) ? (request('country_id')[0] ?? '') : request('country_id');
								@endphp
								@if($countryIdValue)
								• Country: {{ $countries->firstWhere('id', $countryIdValue)->name ?? 'Unknown' }}
								@endif
							@endif
							@if(request('type'))
								@php
									$typeValue = is_array(request('type')) ? (request('type')[0] ?? '') : request('type');
								@endphp
								@if($typeValue)
								• Type: {{ ucfirst($typeValue) }}
								@endif
							@endif
							@if(request('status'))
								@php
									$statusValue = is_array(request('status')) ? (request('status')[0] ?? '') : request('status');
								@endphp
								@if($statusValue)
								• Status: {{ ucfirst($statusValue) }}
								@endif
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
												<h6 class="mb-0">Total Promotions</h6>
												<h4 class="mb-0">{{ $promotions->total() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-rocket-line fs-1"></i>
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
												<h6 class="mb-0">Running</h6>
												<h4 class="mb-0">{{ $promotions->filter(function($promotion) { return $promotion->end_at && $promotion->end_at->isFuture(); })->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-play-circle-line fs-1"></i>
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
												<h6 class="mb-0">Finished</h6>
												<h4 class="mb-0">{{ $promotions->filter(function($promotion) { return $promotion->end_at && $promotion->end_at->isPast(); })->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-stop-circle-line fs-1"></i>
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
												<h4 class="mb-0">{{ $promotions->count() }}</h4>
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
										<th style="width: 25%">Task Details</th>
										<th style="width: 15%">Owner & Country</th>
										<th style="width: 12%">Promotion Info</th>
										<th style="width: 12%">Status & Duration</th>
										<th style="width: 10%">Cost</th>
										<th style="width: 8%">Created</th>
										<th style="width: 18%">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($promotions as $promotion)
									@php
									$isRunning = $promotion->end_at && $promotion->end_at->isFuture();
									$isFinished = $promotion->end_at && $promotion->end_at->isPast();
									$daysRemaining = $promotion->end_at ? now()->diffInDays($promotion->end_at, false) : null;
									@endphp
									<tr>
										<td>
											<div class="d-flex align-items-start">
												<div class="flex-grow-1">
													<div class="fw-bold text-primary mb-1">{{ $promotion->task->title ?? 'N/A' }}</div>
													<div class="text-muted small mb-2">
														{{ Str::limit($promotion->task->description ?? 'No description', 100) }}
													</div>
													<div class="d-flex gap-2 flex-wrap">
														@if($promotion->task && $promotion->task->is_active)
														<span class="badge bg-success">Active Task</span>
														@else
														<span class="badge bg-secondary">Inactive Task</span>
														@endif
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="d-flex flex-column">
												<div class="fw-bold">{{ $promotion->user->name ?? 'N/A' }}</div>
												<div class="text-muted small">
													@if(auth()->user()->first_role->name === 'super-admin' && $promotion->user && $promotion->user->country)
													{{ $promotion->user->country->name ?? 'Unknown Country' }}
													@endif
												</div>
											</div>
										</td>
										<td>
											<div class="d-flex flex-column">
												<span class="badge bg-outline-primary mb-1">{{ ucfirst($promotion->type) }}</span>
												<div class="text-muted small">
													Duration: {{ $promotion->days }} days
												</div>
											</div>
										</td>
										<td>
											@if($isRunning)
											<span class="badge bg-success">
												<i class="ri-play-circle-line me-1"></i>Running
											</span>
											@if($daysRemaining !== null)
											<div class="text-success small mt-1">
												<i class="ri-time-line me-1"></i>{{ $daysRemaining }} days left
											</div>
											@endif
											@elseif($isFinished)
											<span class="badge bg-warning">
												<i class="ri-stop-circle-line me-1"></i>Finished
											</span>
											@if($daysRemaining !== null)
											<div class="text-muted small mt-1">
												<i class="ri-time-line me-1"></i>{{ abs($daysRemaining) }} days ago
											</div>
											@endif
											@else
											<span class="badge bg-secondary">
												<i class="ri-question-line me-1"></i>Unknown
											</span>
											@endif
										</td>
										<td>
											<div class="text-center">
												<div class="fw-bold">{{ $promotion->currency }} {{ number_format($promotion->cost, 2) }}</div>
												<div class="text-muted small">Total cost</div>
											</div>
										</td>
										<td>
											<div class="text-center">
												<div class="fw-bold">{{ $promotion->created_at->format('M d') }}</div>
												<div class="text-muted small">{{ $promotion->created_at->format('Y') }}</div>
											</div>
										</td>
										<td>
											<div class="d-flex flex-column gap-1">
												@if($promotion->task)
												<a href="{{ route('admin.tasks.show', $promotion->task) }}" class="btn btn-primary btn-sm">
													<i class="ri-eye-line me-1"></i>View Task
												</a>
												@endif
												@if($promotion->user)
												<a href="{{ route('admin.users.show', $promotion->user) }}" class="btn btn-info btn-sm">
													<i class="ri-user-line me-1"></i>View User
												</a>
												@endif
												<div class="text-muted small">
													@if($promotion->start_at)
													Started: {{ $promotion->start_at->format('M d, Y') }}
													@endif
													@if($promotion->end_at)
													<br>Ends: {{ $promotion->end_at->format('M d, Y') }}
													@endif
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $promotions])
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

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
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	.quick-filter-badge {
		transition: all 0.2s ease;
	}

	.quick-filter-badge:hover {
		transform: translateY(-1px);
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}
</style>
@endpush

@push('scripts')
<script>
	$(function() {
		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#promotionFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Remove auto-submit - filters only work when button is clicked
		// $('#type, #status, #sort_by, #sort_order').on('change', function() {
		// 	setFormLoading(true);
		// 	$('#promotionFiltersForm').submit();
		// });

		// Export functionality
		$('#exportBtn').on('click', function() {
			const btn = $(this);
			const originalText = btn.html();

			btn.prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Exporting...');

			try {
				const form = $('#promotionFiltersForm')[0];
				const formData = new FormData(form);

				// Add export parameter
				formData.append('export', 'csv');

				// Create a temporary form for export
				const exportForm = document.createElement('form');
				exportForm.method = 'POST';
				exportForm.action = '{{ route("admin.tasks.promotions") }}';
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

		// Cost range validation
		$('#cost_min, #cost_max').on('change', function() {
			const costMin = parseFloat($('#cost_min').val()) || 0;
			const costMax = parseFloat($('#cost_max').val()) || 0;

			if (costMin > 0 && costMax > 0 && costMin > costMax) {
				showNotification('Minimum cost cannot be greater than maximum cost', 'warning');
				$(this).val('');
			}
		});

		// Search only submits when filter button is clicked
		// let searchTimeout;
		// $('#search').on('input', function() {
		// 	clearTimeout(searchTimeout);
		// 	searchTimeout = setTimeout(function() {
		// 		setFormLoading(true);
		// 		$('#promotionFiltersForm').submit();
		// 	}, 500);
		// });

		// Form submission
		$('#promotionFiltersForm').on('submit', function() {
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
	});
</script>
@endpush