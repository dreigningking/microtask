@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Payments
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Payments</li>
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
						<form method="GET" action="{{ route('admin.payments.index') }}" id="paymentFiltersForm">
							<div class="row">
								<div class="col-md-2 mb-3">
									<label for="reference" class="form-label">Reference</label>
									<input type="text" class="form-control" id="reference" name="reference" 
										   value="{{ request('reference') }}" placeholder="Payment reference">
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="user_name" class="form-label">User Name</label>
									<input type="text" class="form-control" id="user_name" name="user_name" 
										   value="{{ request('user_name') }}" placeholder="Search by user name">
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
									<label for="gateway" class="form-label">Gateway</label>
									<select class="form-select" id="gateway" name="gateway">
										<option value="">All Gateways</option>
										@if($gateways && $gateways->count() > 0)
											@foreach($gateways as $gateway)
												<option value="{{ $gateway }}" {{ request('gateway') === $gateway ? 'selected' : '' }}>
													{{ $gateway }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							
							<div class="row">
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
							
							@if(auth()->user()->first_role->name === 'super-admin' && $countries && $countries->count() > 0)
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
									<a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
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
						<h5 class="card-title">Payments</h5>
						<h6 class="card-subtitle text-muted">
							@if($payments->total() > 0)
								Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} payments
							@else
								No payments found
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
										<th>Currency</th>
										<th>Amount</th>
										<th>VAT</th>
										<th>Gateway</th>
										<th>Status</th>
										<th>Date</th>
										<th>Paid For</th>
									</tr>
								</thead>
								<tbody>
									@forelse($payments as $payment)
										<tr>
											<td>
												<code class="text-primary">{{ $payment->reference }}</code>
											</td>
											<td>
												@if($payment->user)
													<a href="{{ route('admin.users.show', $payment->user) }}">{{ $payment->user->name ?? '-' }}</a>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												<span class="badge bg-light text-dark">{{ $payment->currency }}</span>
											</td>
											<td>
												<strong>{{ number_format($payment->amount, 2) }}</strong>
											</td>
											<td>
												{{ number_format($payment->vat_value ?? 0, 2) }}
											</td>
											<td>
												@if($payment->gateway)
													<span class="badge bg-info">{{ $payment->gateway }}</span>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												@if($payment->status === 'completed')
													<span class="badge bg-success">Completed</span>
												@elseif($payment->status === 'pending')
													<span class="badge bg-warning">Pending</span>
												@elseif($payment->status === 'failed')
													<span class="badge bg-danger">Failed</span>
												@else
													<span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
												@endif
											</td>
											<td>
												{{ $payment->created_at ? $payment->created_at->format('M d, Y H:i') : '-' }}
											</td>
											<td>
												<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#paidForModal{{ $payment->id }}">
													View Details
												</button>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="9" class="text-center py-4">
												<div class="text-muted">
													<i class="ri-inbox-line me-2"></i>No payments found
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					@if($payments->hasPages())
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $payments])
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Modals for Payment Details -->
@foreach($payments as $payment)
	<!-- Paid For Modal -->
	<div class="modal fade" id="paidForModal{{ $payment->id }}" tabindex="-1" aria-labelledby="paidForModalLabel{{ $payment->id }}" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="paidForModalLabel{{ $payment->id }}">Paid For Details (Payment Ref: {{ $payment->reference }})</h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					@if($payment->order && $payment->order->items)
						<ul class="mb-0">
							@foreach($payment->order->items as $item)
								<li>
									@php
										$type = class_basename($item->orderable_type ?? '');
									@endphp
									@if($type === 'Task')
										Task: {{ $item->orderable->title ?? '-' }}
									@elseif($type === 'TaskPromotion')
										Task Promotion: {{ $item->orderable->type ?? '-' }}
									@elseif($type === 'Subscription')
										Subscription
									@else
										{{ $type }}
									@endif
									({{ number_format($item->amount, 2) }})
								</li>
							@endforeach
						</ul>
					@else
						<p>No order items found for this payment.</p>
					@endif
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endforeach
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
		$('#currency, #status, #gateway, #country_id').on('change', function() {
			$('#paymentFiltersForm').submit();
		});

		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#paymentFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Show loading state when form is submitted
		$('#paymentFiltersForm').on('submit', function() {
			setFormLoading(true);
		});
	});
</script>
@endpush