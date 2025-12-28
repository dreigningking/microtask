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
				Moderations
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Moderations</a></li>
					<li class="breadcrumb-item active" aria-current="page">List</li>
				</ol>
			</nav>
		</div>

		
		<!-- Search and Filter Form -->
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Search & Filters</h5>
					</div>
					<div class="card-body">
						<form method="GET" action="{{ route('admin.moderations') }}" id="taskFiltersForm">
							<div class="row g-3">
								

								<!-- Country Filter (Super Admin Only) -->
								
								<div class="col-md-3 mb-2">
									<label for="country_id" class="form-label">Country</label>
									<select class="form-control form-select" id="country_id" name="country_id">
										<option value="">All Countries</option>
										@foreach($countries as $country)
											<option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
												{{ $country->name }}
											</option>
										@endforeach
									</select>
								</div>
								

								

								<!-- Moderation Type Filter -->
								<div class="col-md-3 mb-2">
									<label for="moderation_type" class="form-label">Moderation Type</label>
									<select class="form-control form-select" id="moderation_type" name="moderation_type">
										<option value="">All Types</option>
										@foreach($moderatables as $key => $label)
											<option value="{{ $key }}" {{ request('moderation_type') == $key ? 'selected' : '' }}>
												{{ $label }}
											</option>
										@endforeach
									</select>
								</div>

								<!-- Status Filter -->
								<div class="col-md-3 mb-2">
									<label for="status" class="form-label">Status</label>
									<select class="form-control form-select" id="status" name="status">
										<option value="">All Statuses</option>
										<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
										<option value="pending" {{ (request('status') == 'pending' || !request('status')) ? 'selected' : '' }}>Pending</option>
										<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>

									</select>
								</div>

								<!-- Date Range Filters -->
								<div class="col-md-3 mb-2">
									<label for="date_from" class="form-label">Date From</label>
									<input type="date" class="form-control" id="date_from" name="date_from" 
										   value="{{ request('date_from') }}">
								</div>

								<div class="col-md-3 mb-2">
									<label for="date_to" class="form-label">Date To</label>
									<input type="date" class="form-control" id="date_to" name="date_to" 
										   value="{{ request('date_to') }}">
								</div>


								<!-- Action Buttons -->
								<div class="col-12">
									<div class="d-flex">
										<button type="submit" class="btn btn-primary mr-2" id="applyFiltersBtn">
											<i class="ri-search-line me-1"></i>Apply Filters
										</button>
										<a href="{{ route('admin.moderations') }}" class="btn btn-secondary">
											<i class="ri-refresh-line me-1"></i>Clear Filters
										</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Active Filters Display -->
		@if(request()->hasAny(['search', 'country_id', 'platform_id', 'review_type', 'status', 'date_from', 'date_to', 'budget_min', 'budget_max']))
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-body py-2">
						<div class="d-flex align-items-center gap-2 flex-wrap">
							<small class="text-muted me-2">Active Filters:</small>
							

							@if(request('country_id') && auth()->user()->role->slug === 'super-admin')
							<span class="badge bg-info d-flex align-items-center gap-1 quick-filter-badge">
								Country: {{ $countries->firstWhere('id', request('country_id'))->name ?? 'Unknown' }}
								<a href="{{ route('admin.moderations', request()->except('country_id')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif

							@if(request('moderation_type'))
							<span class="badge bg-warning d-flex align-items-center gap-1 quick-filter-badge">
								Type: {{ $moderatables[request('moderation_type')] ?? 'Unknown' }}
								<a href="{{ route('admin.moderations', request()->except('moderation_type')) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif


							@if(request('date_from') || request('date_to'))
							<span class="badge bg-dark d-flex align-items-center gap-1 quick-filter-badge">
								Date: {{ request('date_from', 'Any') }} to {{ request('date_to', 'Any') }}
								<a href="{{ route('admin.moderations', request()->except(['date_from', 'date_to'])) }}" class="text-white text-decoration-none ms-1">
									<i class="ri-close-line"></i>
								</a>
							</span>
							@endif


							<a href="{{ route('admin.moderations') }}" class="badge bg-danger text-decoration-none quick-filter-badge">
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
						<h5 class="card-title">Moderations</h5>
						<h6 class="card-subtitle text-muted">Manage and monitor task submissions with different review types.</h6>
					</div>
					<div class="card-body">
						<!-- Results Summary -->
						@if(request()->hasAny(['country_id', 'moderation_type', 'date_from', 'date_to']))
						<div class="alert alert-info mb-3">
							<strong>Filtered Results:</strong>
							Showing {{ $moderations->total() }} moderation(s) matching your criteria
							@if(request('country_id') && auth()->user()->role->slug === 'super-admin')
								• Country: {{ $countries->firstWhere('id', request('country_id'))->name ?? 'Unknown' }}
							@endif
							@if(request('moderation_type'))
								• Type: {{ $moderatables[request('moderation_type')] ?? 'Unknown' }}
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
												<h6 class="mb-0">Total Moderations</h6>
												<h4 class="mb-0">{{ $moderations->total() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-task-line fs-1"></i>
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
												<h6 class="mb-0">Pending</h6>
												<h4 class="mb-0">{{ $moderations->where('status', 'pending')->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-time-line fs-1"></i>
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
												<h6 class="mb-0">Approved</h6>
												<h4 class="mb-0">{{ $moderations->where('status', 'approved')->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-check-line fs-1"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card bg-danger text-white">
									<div class="card-body py-2">
										<div class="d-flex align-items-center">
											<div class="flex-grow-1">
												<h6 class="mb-0">Rejected</h6>
												<h4 class="mb-0">{{ $moderations->where('status', 'rejected')->count() }}</h4>
											</div>
											<div class="flex-shrink-0">
												<i class="ri-x-line fs-1"></i>
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
										<th style="width: 20%">Created Date</th>
										<th style="width: 15%">Type</th>
										<th style="width: 25%">Notes</th>
										<th style="width: 15%">Moderated By</th>
										<th style="width: 10%">Status</th>
										<th style="width: 15%">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($moderations as $moderation)
									<tr>
										<td>{{ $moderation->created_at->format('M d, Y H:i') }}</td>
										<td>{{ $moderatables[$moderation->moderatable_type] ?? class_basename($moderation->moderatable_type) }}</td>
										<td>{{ Str::limit($moderation->notes, 50) }}</td>
										<td>{{ $moderation->moderator->name ?? 'N/A' }}</td>
										<td>
											@if($moderation->status == 'approved')
												<span class="badge bg-success">Approved</span>
											@elseif($moderation->status == 'rejected')
												<span class="badge bg-danger">Rejected</span>
											@else
												<span class="badge bg-warning">Pending</span>
											@endif
										</td>
										<td>
											<a href="{{ $moderation->target }}" class="btn btn-primary btn-sm">
												<i class="ri-eye-line me-1"></i>View
											</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $moderations])
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
		$('#moderation_type, #status').on('change', function() {
			setFormLoading(true);
			$('#taskFiltersForm').submit();
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
			// No shortcuts
		});

	});
</script>
@endpush