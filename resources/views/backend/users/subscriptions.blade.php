@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				User Subscriptions
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Users</a></li>
					<li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
				</ol>
			</nav>
		</div>

		<!-- Filters Section -->
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Filters</h5>
					</div>
					<div class="card-body">
						<form method="GET" action="{{ route('admin.users.subscriptions.index') }}" id="subscriptionFiltersForm">
							<div class="row">
								<div class="col-md-3 mb-3">
									<label for="user_email" class="form-label">User Email</label>
									<input type="email" class="form-control" id="user_email" name="user_email"
										   value="{{ request('user_email') }}" placeholder="Filter by email">
								</div>

								<div class="col-md-3 mb-3">
									<label for="plan_id" class="form-label">Plan</label>
									<select class="form-select" id="plan_id" name="plan_id">
										<option value="">All Plans</option>
										@foreach($plans as $plan)
											<option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
												{{ $plan->name }} ({{ ucfirst($plan->type) }})
											</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-3 mb-3">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" id="status" name="status">
										<option value="">All Statuses</option>
										<option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
										<option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
										<option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
										<option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
									</select>
								</div>

								<div class="col-md-3 mb-3">
									<label for="billing_cycle" class="form-label">Billing Cycle</label>
									<select class="form-select" id="billing_cycle" name="billing_cycle">
										<option value="">All Cycles</option>
										<option value="monthly" {{ request('billing_cycle') === 'monthly' ? 'selected' : '' }}>Monthly</option>
										<option value="annual" {{ request('billing_cycle') === 'annual' ? 'selected' : '' }}>Annual</option>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary me-2" id="applyFiltersBtn">
										<i class="ri-search-line me-1"></i>Apply Filters
									</button>
									<a href="{{ route('admin.users.subscriptions.index') }}" class="btn btn-secondary">
										<i class="ri-refresh-line me-1"></i>Clear Filters
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Subscriptions</h5>
						<h6 class="card-subtitle text-muted">
							@if($subscriptions->total() > 0)
								Showing {{ $subscriptions->firstItem() }} to {{ $subscriptions->lastItem() }} of {{ $subscriptions->total() }} subscriptions
							@else
								No subscriptions found
							@endif
						</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>User</th>
										<th>Plan</th>
										<th>Status</th>
										<th>Cost</th>
										<th>Billing Cycle</th>
										<th>Started At</th>
										<th>Expires At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@forelse($subscriptions as $subscription)
									<tr>
										<td>
											<div>
												<strong>{{ $subscription->user->name }}</strong>
												<br>
												<small class="text-muted">{{ $subscription->user->email }}</small>
											</div>
										</td>
										<td>
											<span class="badge bg-primary">{{ $subscription->plan->name }}</span>
											<br>
											<small class="text-muted">{{ ucfirst($subscription->plan->type) }}</small>
										</td>
										<td>
											@if($subscription->status == 'active')
												<span class="badge bg-success">Active</span>
											@elseif($subscription->status == 'expired')
												<span class="badge bg-warning">Expired</span>
											@elseif($subscription->status == 'cancelled')
												<span class="badge bg-danger">Cancelled</span>
											@elseif($subscription->status == 'suspended')
												<span class="badge bg-secondary">Suspended</span>
											@else
												<span class="badge bg-light text-dark">{{ ucfirst($subscription->status) }}</span>
											@endif
										</td>
										<td>
											<strong>{{ $subscription->currency }} {{ $subscription->cost }}</strong>
										</td>
										<td>
											<span class="badge bg-info">{{ ucfirst($subscription->billing_cycle) }}</span>
										</td>
										<td>
											@if($subscription->starts_at)
												{{ $subscription->starts_at->format('M d, Y') }}
											@else
												<span class="text-muted">-</span>
											@endif
										</td>
										<td>
											@if($subscription->expires_at)
												{{ $subscription->expires_at->format('M d, Y') }}
												@if($subscription->expires_at->isPast() && $subscription->status == 'active')
													<br><small class="text-danger">(Expired)</small>
												@endif
											@else
												<span class="text-muted">-</span>
											@endif
										</td>
										<td>
											<a href="{{ route('admin.users.subscriptions.show', $subscription) }}" class="btn btn-primary btn-sm">
												<i class="ri-eye-line me-1"></i>View
											</a>
										</td>
									</tr>
									@empty
										<tr>
											<td colspan="8" class="text-center py-4">
												<div class="text-muted">
													<i class="ri-inbox-line me-2"></i>No subscriptions found
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					@if($subscriptions->hasPages())
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $subscriptions])
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

@push('styles')
<style>
	.filter-loading {
		opacity: 0.7;
		pointer-events: none;
	}

	.badge {
		font-size: 0.75rem;
	}

	.table th {
		font-weight: 600;
		background-color: #f8f9fa;
	}

	.btn-group {
		flex-wrap: wrap;
		gap: 0.25rem;
	}

	.btn-group .btn {
		margin: 0;
	}
</style>
@endpush

@push('scripts')
<script>
	$(function() {
		// Auto-submit form when certain filters change
		$('#status, #plan_id, #billing_cycle').on('change', function() {
			$('#subscriptionFiltersForm').submit();
		});

		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#subscriptionFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Show loading state when form is submitted
		$('#subscriptionFiltersForm').on('submit', function() {
			setFormLoading(true);
		});
	});
</script>
@endpush
