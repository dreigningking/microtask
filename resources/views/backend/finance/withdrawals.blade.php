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
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Withdrawals</h5>
						<h6 class="card-subtitle text-muted">Highly flexible tool that many advanced features to any HTML table.</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="datatables-basic" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Reference</th>
										<th>User</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Payment Method</th>
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
									@foreach($withdrawals as $withdrawal)
										<tr>
											<td>{{ $withdrawal->reference }}</td>
											<td>{{ $withdrawal->user->name ?? '-' }}</td>
											<td>{{ $withdrawal->currency }}</td>
											<td>{{ number_format($withdrawal->amount, 2) }}</td>
											<td>{{ $withdrawal->payment_method ?? '-' }}</td>
											<td>
												@if($withdrawal->status === 'paid')
													<span class="badge bg-primary">Paid</span>
												@elseif($withdrawal->status === 'approved')
													<span class="badge bg-success">Approved</span>
												@elseif($withdrawal->status === 'rejected')
													<span class="badge bg-danger">Rejected</span>
												@else
													<span class="badge bg-warning text-dark">Pending</span>
												@endif
											</td>
											<td>{{ $withdrawal->created_at ? $withdrawal->created_at->format('Y-m-d H:i') : '-' }}</td>
											<td>{{ $withdrawal->approver->name ?? '-' }}</td>
											<td>{{ $withdrawal->approved_at ? $withdrawal->approved_at->format('Y-m-d H:i') : '-' }}</td>
											<td>{{ $withdrawal->rejected_at ? $withdrawal->rejected_at->format('Y-m-d H:i') : '-' }}</td>
											<td>{{ $withdrawal->note ?? '-' }}</td>
											<td>
												@if($withdrawal->status === 'pending')
													@php
														// Default to 'gateway' if setting or method is not available
														$payoutMethod = $withdrawal->user->country->setting->payout_method ?? 'gateway';
													@endphp
											
													@if($payoutMethod === 'manual')
														<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#markAsPaidModal{{ $withdrawal->id }}">Mark as Paid</button>
													@else
														<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $withdrawal->id }}">Approve</button>
													@endif
													
													<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#disapproveModal{{ $withdrawal->id }}">Disapprove</button>
												@else
													-
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<th>Reference</th>
										<th>User</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Payment Method</th>
										<th>Status</th>
										<th>Requested At</th>
										<th>Approved By</th>
										<th>Approved At</th>
										<th>Rejected At</th>
										<th>Note</th>
										<th>Actions</th>
									</tr>
								</tfoot>
							</table>
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
		// Datatables basic
		$('#datatables-basic').DataTable({
			scrollX: true
		});
	});
</script>
@endpush
@foreach($withdrawals as $withdrawal)
	<!-- Mark as Paid Modal -->
	<div class="modal fade" id="markAsPaidModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="markAsPaidModalLabel{{ $withdrawal->id }}" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="markAsPaidModalLabel{{ $withdrawal->id }}">Mark as Paid</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Are you sure you have paid this withdrawal (Ref: <strong>{{ $withdrawal->reference }}</strong>) and want to mark it as paid?
				</div>
				<div class="modal-footer">
					<form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}">
						@csrf
						<button type="submit" class="btn btn-success btn-sm">Yes, Mark as Paid</button>
					</form>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Approve Modal -->
	<div class="modal fade" id="approveModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $withdrawal->id }}" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="approveModalLabel{{ $withdrawal->id }}">Approve Withdrawal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Are you sure you want to approve this withdrawal (Ref: <strong>{{ $withdrawal->reference }}</strong>)?
				</div>
				<div class="modal-footer">
					<form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}">
						@csrf
						<button type="submit" class="btn btn-success btn-sm">Approve</button>
					</form>
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
					<h5 class="modal-title" id="disapproveModalLabel{{ $withdrawal->id }}">Disapprove Withdrawal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action="{{ route('admin.withdrawals.disapprove', $withdrawal->id) }}">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="note{{ $withdrawal->id }}">Reason for disapproval</label>
							<textarea class="form-control" id="note{{ $withdrawal->id }}" name="note" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger btn-sm">Disapprove</button>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endforeach