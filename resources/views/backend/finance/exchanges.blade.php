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
								@foreach($exchanges as $exchange)
									<tr>
										<td>{{ $exchange->reference ?? '-' }}</td>
										<td>{{ $exchange->user->name ?? '-' }}</td>
										<td>{{ $exchange->base_currency }}</td>
										<td>{{ number_format($exchange->base_amount, 2) }}</td>
										<td>{{ $exchange->base_wallet->id ?? '-' }}</td>
										<td>{{ $exchange->target_currency }}</td>
										<td>{{ number_format($exchange->target_amount, 2) }}</td>
										<td>{{ $exchange->target_wallet->id ?? '-' }}</td>
										<td>{{ $exchange->exchange_rate }}</td>
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
										<td>{{ $exchange->created_at ? $exchange->created_at->format('Y-m-d H:i') : '-' }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
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
							</tfoot>
						</table>
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