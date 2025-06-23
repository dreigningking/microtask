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
									<th>Task</th>
									<th>Type</th>
									<th>Days</th>
									<th>Start At</th>
									<th>Cost</th>
									<th>Currency</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($promotions as $promotion)
								<tr>
									<td>{{ $promotion->task->title }}</td>
									<td>{{ $promotion->type }}</td>
									<td>{{ $promotion->days }}</td>
									<td>{{ $promotion->created_at->format('d-M-Y') }}</td>
									<td>{{ $promotion->cost }}</td>
									<td>{{ $promotion->currency }}</td>
									<td>
										<a href="{{ route('admin.tasks.show', $promotion->task) }}" class="btn btn-primary">View Task</a>
									</td>
								</tr>
								@endforeach	
							</tbody>
							<tfoot>
								<tr>
									<th>Task</th>
									<th>Type</th>
									<th>Days</th>
									<th>Start At</th>
									<th>Cost</th>
									<th>Currency</th>
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