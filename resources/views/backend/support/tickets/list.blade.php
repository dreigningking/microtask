@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Support Tickets
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Support</a></li>
					<li class="breadcrumb-item active" aria-current="page">Tickets</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Support Tickets</h5>
						<h6 class="card-subtitle text-muted">Manage and respond to customer support tickets efficiently.</h6>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Ticket ID</th>
									<th>Subject</th>
									<th>User</th>
									
									<th>Messages</th>
									<th>Assigned To</th>
									<th>Last Updated</th>
									<th>Actions</th>
									
								</tr>
							</thead>
							<tbody>
								<!-- Sample Support Ticket 1 -->
								<tr>
									<td>
										<div>
											<span class="badge bg-primary">#ST-001</span>
										</div>
										<span class="text-muted small">2024-01-15 09:30</span>
										
									</td>
									<td>
										<strong>Payment Issue - Transaction Failed</strong>
										<div class="text-muted small">Unable to complete payment for task completion</div>
										<div class="d-flex mt-2">
											<span class="badge bg-danger">High</span>
											<span class="badge bg-warning">In Progress</span>
										</div>
									</td>
									<td>
										<div class="d-flex align-items-center">
											<img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="rounded-circle me-2" style="width: 32px; height: 32px;">
											<div>
												<div class="fw-bold">John Smith</div>
												<div class="text-muted small">john.smith@email.com</div>
											</div>
										</div>
									</td>
									
									<td>
										<span class="badge bg-primary">8 messages</span>
									</td>
									<td>
										<div class="d-flex align-items-center">
											<img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Staff" class="rounded-circle me-2" style="width: 28px; height: 28px;">
											<span>Sarah Johnson</span>
										</div>
									</td>
									
									<td>2024-01-16 14:22</td>
									<td>
										<div class="d-flex gap-1">
											<a href="{{ route('admin.support.tickets.show', 2) }}" class="btn btn-primary btn-sm">
												<i class="ri-eye-line"></i> View
											</a>
											<a href="#" class="btn btn-warning btn-sm">
												<i class="ri-edit-line"></i> Reply
											</a>
											<button class="btn btn-success btn-sm">
												<i class="ri-check-line"></i> Close
											</button>
										</div>
									</td>
								</tr>

								
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
			columnDefs: [
				{
					targets: -1, // Actions column
					orderable: false,
					searchable: false,
					width: '200px'
				},
				{
					targets: 0, // Ticket ID column
					width: '100px'
				},
				{
					targets: 3, // Priority column
					width: '80px'
				},
				{
					targets: 4, // Status column
					width: '100px'
				},
				{
					targets: 5, // Messages column
					width: '120px'
				},
				{
					targets: 6, // Assigned To column
					width: '150px'
				}
			],
			order: [[7, 'desc']], // Sort by created date descending
			pageLength: 25,
			language: {
				search: "Search tickets:",
				lengthMenu: "Show _MENU_ tickets per page",
				info: "Showing _START_ to _END_ of _TOTAL_ tickets",
				infoEmpty: "Showing 0 to 0 of 0 tickets",
				infoFiltered: "(filtered from _MAX_ total tickets)"
			}
		});
	});
</script>
@endpush