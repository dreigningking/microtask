@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">
		<div class="header">
			<h1 class="header-title">
				Countries Settings
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Settings</a></li>
					<li class="breadcrumb-item active" aria-current="page">Countries</li>
				</ol>
			</nav>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Country Settings</h5>
						<h6 class="card-subtitle text-muted">Manage country-specific settings for your platform.</h6>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped table-sm" style="width:100%">
							<thead>
								<tr>
									<th>Country</th>
									<th>Ready for Production</th>
									<th>Supports Payment</th>
									<th>Wallet Status</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($countries as $country)
								<tr>
									<td>{{ $country->name }}</td>
									<td>
										@if($country->isReadyForProduction())
											<span class="badge bg-success">Ready</span>
										@else
											<span class="badge bg-danger">Not Ready</span>
										@endif
									</td>
									<td>
										@if($country->supportsPayments())
											<span class="badge bg-success">Yes</span>
										@else
											<span class="badge bg-danger">Not Yet</span>
										@endif
									</td>
									<td>
										@if($country->supportsWallets())
											<span class="badge bg-success">Active</span>
										@else
											<span class="badge bg-danger">Disabled</span>
										@endif
									</td>
									<td>
										@if($country->status)
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									
									<td>
										<a href="{{ route('admin.settings.country', $country) }}" class="btn btn-sm btn-primary">
											<i class="align-middle" data-feather="settings"></i> Config
										</a>
									</td>
								</tr>
								@endforeach
							</tbody>
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