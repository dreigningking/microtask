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
									<th>Beneficiary</th>
									<th>Settlement Type</th>
									<th>Currency</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								@foreach($settlements as $settlement)
									<tr>
										<td>
											<a href="{{route('admin.users.show',$settlement->user)}}">{{ $settlement->user->name ?? '-' }}</a>
										</td>
										<td>
											@if($settlement->settlementable_type === 'App\\Models\\Task')
												Task
											@elseif($settlement->settlementable_type === 'App\\Models\\Referral')
												@if($settlement->settlementable->type == 'internal')
													Task Invitation Bonus
												@else
													Referral Bonus
												@endif
											
											@endif
										</td>
										<td>{{ $settlement->currency }}</td>
										<td>{{ number_format($settlement->amount, 2) }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Beneficiary</th>
									<th>Settlement Type</th>
									<th>Currency</th>
									<th>Amount</th>
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