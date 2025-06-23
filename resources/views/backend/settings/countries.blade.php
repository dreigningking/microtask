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
									<th>Banking</th>
									<th>Transactions</th>
									<th>Tasks</th>
									<th>Plan Prices</th>
									<th>Template Prices</th>
									<th>Notification Emails</th>
									<th>Verification</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($countries as $country)
								<tr>
									<td>{{ $country->name }}</td>
									<td>
										@if($country->hasBankingSettings())
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									<td>
										@if($country->hasTransactionSettings())
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									<td>
										@if($country->hasTaskSettings())
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									<td>
										@if($country->hasPlanPrices())
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									<td>
										@if($country->hasTemplatePrices())
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									<td>
										@if($country->hasNotificationEmails())
											<span class="badge bg-success">Set</span>
										@else
											<span class="badge bg-danger">Not Set</span>
										@endif
									</td>
									<td>
										@if($country->hasVerificationSettings())
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
			responsive: true,
			pageLength: 25,
			order: [[0, 'asc']],
			columnDefs: [
				{ width: '20%', targets: 0 },
				{ width: '8%', targets: [1, 2, 3] },
				{ width: '15%', targets: 4 },
				{ width: '10%', targets: [5, 6, 7] },
				{ width: '9%', targets: 8 }
			]
		});
	});
</script>
@endpush