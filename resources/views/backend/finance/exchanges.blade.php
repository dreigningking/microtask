@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Exchanges
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Exchanges</li>
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
						<form method="GET" action="{{ route('admin.exchanges.index') }}" id="exchangeFiltersForm">
							<div class="row">
								<div class="col-md-2 mb-3">
									<label for="user_name" class="form-label">User Name</label>
									<input type="text" class="form-control" id="user_name" name="user_name" 
										   value="{{ request('user_name') }}" placeholder="Search by user name">
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="base_currency" class="form-label">Base Currency</label>
									<select class="form-select" id="base_currency" name="base_currency">
										<option value="">All Base Currencies</option>
										@if($baseCurrencies && $baseCurrencies->count() > 0)
											@foreach($baseCurrencies as $currency)
												<option value="{{ $currency }}" {{ request('base_currency') === $currency ? 'selected' : '' }}>
													{{ $currency }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="target_currency" class="form-label">Target Currency</label>
									<select class="form-select" id="target_currency" name="target_currency">
										<option value="">All Target Currencies</option>
										@if($targetCurrencies && $targetCurrencies->count() > 0)
											@foreach($targetCurrencies as $currency)
												<option value="{{ $currency }}" {{ request('target_currency') === $currency ? 'selected' : '' }}>
													{{ $currency }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" id="status" name="status">
										<option value="">All Statuses</option>
										@if($statuses && $statuses->count() > 0)
											@foreach($statuses as $status)
												<option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
													{{ ucfirst($status) }}
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
							
							@if(auth()->user()->role->name === 'super-admin' && $countries && $countries->count() > 0)
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
									<a href="{{ route('admin.exchanges.index') }}" class="btn btn-secondary">
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
						<h5 class="card-title">Exchanges</h5>
						<h6 class="card-subtitle text-muted">
							@if($exchanges->total() > 0)
								Showing {{ $exchanges->firstItem() }} to {{ $exchanges->lastItem() }} of {{ $exchanges->total() }} exchanges
							@else
								No exchanges found
							@endif
						</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Reference</th>
										<th>User</th>
										<th>Base Currency</th>
										<th>Base Amount</th>
										<th>Base Wallet</th>
										<th>Target Currency</th>
										<th>Target Amount</th>
										<th>Target Wallet</th>
										<th>Exchange Rate</th>
										<th>Status</th>
										<th>Created At</th>
									</tr>
								</thead>
								<tbody>
									@forelse($exchanges as $exchange)
										<tr>
											<td>
												@if($exchange->reference)
													<code class="text-primary">{{ $exchange->reference }}</code>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												@if($exchange->user)
													<a href="{{ route('admin.users.show', $exchange->user) }}">{{ $exchange->user->name ?? '-' }}</a>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												<span class="badge bg-light text-dark">{{ $exchange->base_currency }}</span>
											</td>
											<td>
												<strong>{{ number_format($exchange->base_amount, 2) }}</strong>
											</td>
											<td>
												@if($exchange->base_wallet)
													<span class="badge bg-info">{{ $exchange->base_wallet->id ?? '-' }}</span>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												<span class="badge bg-light text-dark">{{ $exchange->target_currency }}</span>
											</td>
											<td>
												<strong>{{ number_format($exchange->target_amount, 2) }}</strong>
											</td>
											<td>
												@if($exchange->target_wallet)
													<span class="badge bg-info">{{ $exchange->target_wallet->id ?? '-' }}</span>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												<code>{{ $exchange->exchange_rate }}</code>
											</td>
											<td>
												@if($exchange->status === 'completed')
													<span class="badge bg-success">Completed</span>
												@elseif($exchange->status === 'pending')
													<span class="badge bg-warning text-dark">Pending</span>
												@elseif($exchange->status === 'failed')
													<span class="badge bg-danger">Failed</span>
												@else
													<span class="badge bg-secondary">{{ ucfirst($exchange->status) }}</span>
												@endif
											</td>
											<td>
												{{ $exchange->created_at ? $exchange->created_at->format('M d, Y H:i') : '-' }}
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="11" class="text-center py-4">
												<div class="text-muted">
													<i class="ri-inbox-line me-2"></i>No exchanges found
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					@if($exchanges->hasPages())
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $exchanges])
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
	
	code {
		font-size: 0.875rem;
		background-color: #f8f9fa;
		padding: 0.2rem 0.4rem;
		border-radius: 0.25rem;
	}
</style>
@endpush

@push('scripts')
<script>
	$(function() {
		// Auto-submit form when certain filters change
		$('#base_currency, #target_currency, #status, #country_id').on('change', function() {
			$('#exchangeFiltersForm').submit();
		});

		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#exchangeFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Show loading state when form is submitted
		$('#exchangeFiltersForm').on('submit', function() {
			setFormLoading(true);
		});
	});
</script>
@endpush