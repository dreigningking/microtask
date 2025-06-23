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
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Tasks</h5>
						<h6 class="card-subtitle text-muted">Highly flexible tool that many advanced features to any HTML table.</h6>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped" style="width:100%">
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
								@foreach($payments as $payment)
									<tr>
										<td>{{ $payment->reference }}</td>
										<td>{{ $payment->user->name ?? '-' }}</td>
										<td>{{ $payment->currency }}</td>
										<td>{{ number_format($payment->amount, 2) }}</td>
										<td>{{ number_format($payment->vat_value, 2) }}</td>
										<td>{{ $payment->gateway ?? '-' }}</td>
										<td>{{ ucfirst($payment->status) }}</td>
										<td>{{ $payment->created_at ? $payment->created_at->format('Y-m-d H:i') : '-' }}</td>
										<td>
											<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#paidForModal{{ $payment->id }}">
												View Details
											</button>
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
									<th>VAT</th>
									<th>Gateway</th>
									<th>Status</th>
									<th>Date</th>
									<th>Paid For</th>
								</tr>
							</tfoot>
						</table>
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
			responsive: true
		});
	});
</script>
@endpush