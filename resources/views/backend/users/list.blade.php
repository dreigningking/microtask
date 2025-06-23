@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Users
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Users</a></li>
					<li class="breadcrumb-item active" aria-current="page">List</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Users</h5>
						<h6 class="card-subtitle text-muted">Highly flexible tool that many advanced features to any HTML table.</h6>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Member since</th>
									<th>Tasks Completed</th>
									<th>Jobs Completed</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->name }}</td>
									<td>{{ $user->created_at->format('Y/m/d') }}</td>
									<td>{{ $user->tasks_completed ?? 0 }} out of {{ $user->tasks_on_hand ?? 0 }}</td>
									<td>{{ $user->jobs_completed ?? 0 }} out of {{ $user->jobs_posted ?? 0 }}</td>
									<td>
										<a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary btn-sm">View</a>
										@if(isset($user->is_active) && !$user->is_active)
											<form action="{{ route('admin.users.enable') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Enable this user?');">
												@csrf
												<input type="hidden" name="user_id" value="{{$user->id}}">
												<button type="submit" class="btn btn-success btn-sm">Enable</button>
											</form>
										@else
											<form action="{{ route('admin.users.suspend') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Suspend this user?');">
												@csrf
												<input type="hidden" name="user_id" value="{{$user->id}}">
												<button type="submit" class="btn btn-warning btn-sm">Suspend</button>
											</form>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Title</th>
									<th>Owner</th>
									<th>Platform</th>
									<th>Workers</th>
									<th>Posted</th>
									<th>Payment</th>
									<th>Actions</th>
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