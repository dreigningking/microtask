@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Dispute
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Dispute</a></li>
					<li class="breadcrumb-item active" aria-current="page">List</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Dispute</h5>
						<h6 class="card-subtitle text-muted">Highly flexible tool that many advanced features to any HTML table.</h6>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Task Id</th>
									<th>Task Author</th>
									<th>Worker</th>
									<th>Submission Date</th>
									<th>Desired Outcome</th>
									<th>Resolution</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($disputes as $dispute)
								<tr>
									<td>{{ $dispute->taskSubmission->task->id }}</td>
									<td>{{ $dispute->taskSubmission->task->user->name }}</td>
									<td>{{ $dispute->taskSubmission->taskWorker->user->name }}</td>
									<td>{{ $dispute->taskSubmission->created_at->format('d-m-Y') }}</td>
									<td>{{ $dispute->outcome }}</td>
									<td>
										@if($dispute->resolved_at)
											{{ $dispute->resolution_instruction }} at {{$dispute->resolved_at->calendar()}}
										@else 
											Pending Resolution
										@endif
									</td>
									
									<td>
										<a href="{{ route('tasks.dispute', $dispute->taskSubmission) }}" class="btn btn-primary btn-sm">View</a>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Task Id</th>
									<th>Task Author</th>
									<th>Worker</th>
									<th>Submission Date</th>
									<th>Desired Outcome</th>
									<th>Resolution</th>
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