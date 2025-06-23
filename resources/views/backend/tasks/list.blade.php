@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Tasks
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Tasks</a></li>
					<li class="breadcrumb-item active" aria-current="page">List</li>
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
									<th>Title</th>
									<th>Owner</th>
									<th>Platform</th>
									<th>Workers</th>
									<th>Posted</th>
									<th>Payment</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($tasks as $task)
								<tr>
									<td>{{ $task->title }}</td>
									<td>{{ $task->user->name ?? '-' }}</td>
									<td>{{ $task->platform->name ?? '-' }}</td>
									<td>{{ $task->workers()->whereNotNull('accepted_at')->count() }} / {{ $task->number_of_people }}</td>
									<td>{{ $task->created_at->format('Y/m/d') }}</td>
									<td>{{ $task->currency }} {{ number_format($task->budget_per_person, 2) }}</td>
									<td>
										<a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-primary btn-sm">View</a>
										@if(!$task->is_active)
											<form action="{{ route('admin.tasks.approve') }}" method="POST" class="d-inline-block">
												@csrf
												<input type="hidden" name="task_id" value="{{ $task->id }}">
												<button type="submit" class="btn btn-success btn-sm">Approve</button>
											</form>
										@else
											<form action="{{ route('admin.tasks.disapprove') }}" method="POST" class="d-inline-block">
												@csrf
												<input type="hidden" name="task_id" value="{{ $task->id }}">
												<button type="submit" class="btn btn-warning btn-sm">Disapprove</button>
											</form>
										@endif
										<form action="{{ route('admin.tasks.delete') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this task? This action cannot be undone.');">
											@csrf
											<input type="hidden" name="task_id" value="{{ $task->id }}">
											<button type="submit" class="btn btn-danger btn-sm">Delete</button>
										</form>
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