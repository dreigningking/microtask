@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Earnings
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Earnings</li>
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
						<form method="GET" action="{{ route('admin.earnings.index') }}" id="settlementFiltersForm">
							<div class="row">
								<div class="col-md-3 mb-3">
									<label for="user_name" class="form-label">User Name</label>
									<input type="text" class="form-control" id="user_name" name="user_name" 
										   value="{{ request('user_name') }}" placeholder="Search by user name">
								</div>
								
								<div class="col-md-3 mb-3">
									<label for="settlement_type" class="form-label">Settlement Type</label>
									<select class="form-select" id="settlement_type" name="settlement_type">
										<option value="">All Types</option>
										<option value="task" {{ request('settlement_type') === 'task' ? 'selected' : '' }}>Task</option>
										<option value="referral" {{ request('settlement_type') === 'referral' ? 'selected' : '' }}>Referral</option>
									</select>
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="currency" class="form-label">Currency</label>
									<select class="form-select" id="currency" name="currency">
										<option value="">All Currencies</option>
										@if($currencies && $currencies->count() > 0)
											@foreach($currencies as $currency)
												<option value="{{ $currency }}" {{ request('currency') === $currency ? 'selected' : '' }}>
													{{ $currency }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="amount_min" class="form-label">Min Amount</label>
									<input type="number" class="form-control" id="amount_min" name="amount_min" 
										   value="{{ request('amount_min') }}" step="0.01" placeholder="0.00">
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="amount_max" class="form-label">Max Amount</label>
									<input type="number" class="form-control" id="amount_max" name="amount_max" 
										   value="{{ request('amount_max') }}" step="0.01" placeholder="0.00">
								</div>
							</div>
							
							@if(auth()->user()->role->slug === 'super-admin' && $countries && $countries->count() > 0)
							<div class="row">
								<div class="col-md-3 mb-3">
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
							</div>
							@endif
							
							<div class="row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary me-2" id="applyFiltersBtn">
										<i class="ri-search-line me-1"></i>Apply Filters
									</button>
									<a href="{{ route('admin.earnings.index') }}" class="btn btn-secondary">
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
						<h5 class="card-title">Settlements</h5>
						<h6 class="card-subtitle text-muted">
							@if($settlements->total() > 0)
								Showing {{ $settlements->firstItem() }} to {{ $settlements->lastItem() }} of {{ $settlements->total() }} settlements
							@else
								No settlements found
							@endif
						</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Beneficiary</th>
										<th>Settlement Type</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@forelse($settlements as $settlement)
										<tr>
											<td>
												@if($settlement->user)
													<a href="{{route('admin.users.show',$settlement->user)}}">{{ $settlement->user->name ?? '-' }}</a>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												@if($settlement->settlementable_type === 'App\\Models\\Task')
													<span class="badge bg-primary">Task</span>
												@elseif($settlement->settlementable_type === 'App\\Models\\Referral' && $settlement->settlementable)
													@if($settlement->settlementable->type == 'internal')
														<span class="badge bg-success">Task Invitation Bonus</span>
													@else
														<span class="badge bg-info">Referral Bonus</span>
													@endif
												@else
													<span class="badge bg-secondary">Other</span>
												@endif
											</td>
											<td>
												<span class="badge bg-light text-dark">{{ $settlement->currency }}</span>
											</td>
											<td>
												<strong>{{ number_format($settlement->amount, 2) }}</strong>
											</td>
											<td>
												{{ $settlement->created_at->format('M d, Y H:i') }}
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="5" class="text-center py-4">
												<div class="text-muted">
													<i class="ri-inbox-line me-2"></i>No settlements found
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					@if($settlements->hasPages())
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $settlements])
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
</style>
@endpush

@push('scripts')
<script>
	$(function() {
		// Auto-submit form when certain filters change
		$('#settlement_type, #currency, #country_id').on('change', function() {
			$('#settlementFiltersForm').submit();
		});

		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#settlementFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Show loading state when form is submitted
		$('#settlementFiltersForm').on('submit', function() {
			setFormLoading(true);
		});
	});
</script>
@endpush