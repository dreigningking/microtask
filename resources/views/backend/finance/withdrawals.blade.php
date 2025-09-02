@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Withdrawals
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Withdrawals</li>
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
						<form method="GET" action="{{ route('admin.withdrawals.index') }}" id="withdrawalFiltersForm">
							<div class="row">
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
									<label for="payout_method" class="form-label">Payout Method</label>
									<select class="form-select" id="payout_method" name="payout_method">
										<option value="">All Methods</option>
										@if($payoutMethods && $payoutMethods->count() > 0)
											@foreach($payoutMethods as $method)
												<option value="{{ $method }}" {{ request('payout_method') === $method ? 'selected' : '' }}>
													{{ ucfirst($method) }}
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
									<a href="{{ route('admin.withdrawals.index') }}" class="btn btn-secondary">
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
						<h5 class="card-title">Withdrawals</h5>
						<h6 class="card-subtitle text-muted">
							@if($withdrawals->total() > 0)
								Showing {{ $withdrawals->firstItem() }} to {{ $withdrawals->lastItem() }} of {{ $withdrawals->total() }} withdrawals
							@else
								No withdrawals found
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
										<th>Bank Account</th>
										<th>Gateway</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Requested At</th>
										<th>Approved By</th>
										<th>Approved At</th>
										<th>Rejected At</th>
										<th>Note</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@forelse($withdrawals as $withdrawal)
										<tr>
											<td>
												<code class="text-primary">{{ $withdrawal->reference }}</code>
											</td>
											<td>
												@if($withdrawal->user)
													<a href="{{ route('admin.users.show', $withdrawal->user) }}">{{ $withdrawal->user->name ?? '-' }}</a>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												@if($withdrawal->user && $withdrawal->user->bankAccount)
													<div class="small">
														<div><strong>{{ $withdrawal->user->bankAccount->bank_name }}</strong></div>
														<div class="text-muted">{{ $withdrawal->user->bankAccount->account_name }}</div>
														<div class="text-muted">{{ $withdrawal->user->bankAccount->account_number }}</div>
														@if($withdrawal->user->bankAccount->bank_code)
															<div class="text-muted">Code: {{ $withdrawal->user->bankAccount->bank_code }}</div>
														@endif
													</div>
												@else
													<span class="text-danger">No Bank Account</span>
												@endif
											</td>
											<td>
												<div class="small">
													<div><span class="badge bg-info">{{ ucfirst($withdrawal->gateway) }}</span></div>
													<div class="text-muted">{{ ucfirst($withdrawal->payment_method) }}</div>
												</div>	
											</td>
											<td>
												<span class="badge bg-light text-dark">{{ $withdrawal->currency }}</span>
											</td>
											<td>
												<strong>{{ number_format($withdrawal->amount, 2) }}</strong>
											</td>
											<td>
												@if($withdrawal->status === 'paid')
													<span class="badge bg-primary">Paid</span>
												@elseif($withdrawal->status === 'approved')
													<span class="badge bg-success">Approved</span>
												@elseif($withdrawal->status === 'processing')
													<span class="badge bg-info">Processing</span>
												@elseif($withdrawal->status === 'rejected')
													<span class="badge bg-danger">Rejected</span>
												@elseif($withdrawal->status === 'failed')
													<span class="badge bg-dark">Failed</span>
												@else
													<span class="badge bg-warning text-dark">Pending</span>
												@endif
											</td>
											<td>
												{{ $withdrawal->created_at ? $withdrawal->created_at->format('M d, Y H:i') : '-' }}
											</td>
											<td>
												@if($withdrawal->approver)
													<a href="{{ route('admin.users.show', $withdrawal->approver) }}">{{ $withdrawal->approver->name ?? '-' }}</a>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												{{ $withdrawal->approved_at ? $withdrawal->approved_at->format('M d, Y H:i') : '-' }}
											</td>
											<td>
												{{ $withdrawal->rejected_at ? $withdrawal->rejected_at->format('M d, Y H:i') : '-' }}
											</td>
											<td>
												@if($withdrawal->note)
													<span class="text-muted">{{ Str::limit($withdrawal->note, 30) }}</span>
												@else
													<span class="text-muted">-</span>
												@endif
											</td>
											<td>
												@if($withdrawal->status === 'pending')
													@if($withdrawal->user && $withdrawal->user->bankAccount)
														<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $withdrawal->id }}">
															<i class="ri-check-line me-1"></i>Approve
														</button>
													@else
														<button type="button" class="btn btn-secondary btn-sm" disabled title="User has no bank account">
															<i class="ri-error-line me-1"></i>No Bank Account
														</button>
													@endif
													
													<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#disapproveModal{{ $withdrawal->id }}">
														<i class="ri-close-line me-1"></i>Reject
													</button>
												@elseif($withdrawal->status === 'processing')
													<span class="badge bg-info">Processing</span>
												@elseif($withdrawal->status === 'failed')
													<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#retryModal{{ $withdrawal->id }}">
														<i class="ri-refresh-line me-1"></i>Retry
													</button>
												@else
													-
												@endif
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="12" class="text-center py-4">
												<div class="text-muted">
													<i class="ri-inbox-line me-2"></i>No withdrawals found
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					@if($withdrawals->hasPages())
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $withdrawals])
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
	
	.small {
		font-size: 0.875rem;
	}
</style>
@endpush

@push('scripts')
<script>
	$(function() {
		// Auto-submit form when certain filters change
		$('#currency, #status, #payout_method, #country_id').on('change', function() {
			$('#withdrawalFiltersForm').submit();
		});

		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#withdrawalFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Show loading state when form is submitted
		$('#withdrawalFiltersForm').on('submit', function() {
			setFormLoading(true);
		});
	});
</script>
@endpush

@foreach($withdrawals as $withdrawal)
	<!-- Approve Modal -->
	<div class="modal fade" id="approveModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $withdrawal->id }}" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="approveModalLabel{{ $withdrawal->id }}">Approve Withdrawal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<h6>Withdrawal Details</h6>
							<table class="table table-sm">
								<tr><td><strong>Reference:</strong></td><td>{{ $withdrawal->reference }}</td></tr>
								<tr><td><strong>Amount:</strong></td><td>{{ number_format($withdrawal->amount, 2) }} {{ $withdrawal->currency }}</td></tr>
								<tr><td><strong>User:</strong></td><td>{{ $withdrawal->user->name ?? '-' }}</td></tr>
								<tr><td><strong>Status:</strong></td><td>{{ ucfirst($withdrawal->status) }}</td></tr>
							</table>
						</div>
						<div class="col-md-6">
							<h6>Bank Account Details</h6>
							@if($withdrawal->user && $withdrawal->user->bankAccount)
								<table class="table table-sm">
									<tr><td><strong>Bank:</strong></td><td>{{ $withdrawal->user->bankAccount->bank_name }}</td></tr>
									<tr><td><strong>Account Name:</strong></td><td>{{ $withdrawal->user->bankAccount->account_name }}</td></tr>
									<tr><td><strong>Account Number:</strong></td><td>{{ $withdrawal->user->bankAccount->account_number }}</td></tr>
									@if($withdrawal->user->bankAccount->bank_code)
										<tr><td><strong>Bank Code:</strong></td><td>{{ $withdrawal->user->bankAccount->bank_code }}</td></tr>
									@endif
								</table>
								
								<h6>Gateway Information</h6>
									<table class="table table-sm">
										<tr><td><strong>Gateway:</strong></td><td><span class="badge bg-info">{{ ucfirst($withdrawal->gateway) }}</span></td></tr>
										<tr><td><strong>Payout Method:</strong></td><td><span class="badge bg-secondary">{{ ucfirst($withdrawal->payment_method) }}</span></td></tr>
									</table>
								
							@else
								<div class="alert alert-warning">
									<i class="ri-error-line me-2"></i>User does not have a bank account configured.
								</div>
							@endif
						</div>
					</div>
					
					<div class="alert alert-info">
						<i class="ri-information-line me-2"></i>
						<strong>Note:</strong> Approving this withdrawal will initiate the payout process using the configured gateway ({{ $withdrawal->gateway ?? 'manual' }}).
					</div>
				</div>
				<div class="modal-footer">
					@if($withdrawal->user && $withdrawal->user->bankAccount)
						<form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}">
							@csrf
							<button type="submit" class="btn btn-success btn-sm">
								<i class="ri-check-line me-1"></i>Approve & Initiate Payout
							</button>
						</form>
					@endif
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Disapprove Modal -->
	<div class="modal fade" id="disapproveModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="disapproveModalLabel{{ $withdrawal->id }}" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="disapproveModalLabel{{ $withdrawal->id }}">Reject Withdrawal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action="{{ route('admin.withdrawals.disapprove', $withdrawal->id) }}">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="note{{ $withdrawal->id }}">Reason for rejection</label>
							<textarea class="form-control" id="note{{ $withdrawal->id }}" name="note" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger btn-sm">
							<i class="ri-close-line me-1"></i>Reject
						</button>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Retry Modal -->
	<div class="modal fade" id="retryModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="retryModalLabel{{ $withdrawal->id }}" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="retryModalLabel{{ $withdrawal->id }}">Retry Failed Payout</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to retry the payout for withdrawal <strong>{{ $withdrawal->reference }}</strong>?</p>
					<p class="text-muted small">This will attempt to process the payout again using the configured gateway.</p>
				</div>
				<div class="modal-footer">
					<form method="POST" action="{{ route('admin.withdrawals.retry', $withdrawal->id) }}">
						@csrf
						<button type="submit" class="btn btn-warning btn-sm">
							<i class="ri-refresh-line me-1"></i>Retry Payout
						</button>
					</form>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
@endforeach