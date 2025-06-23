@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				User Verifications
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Verifications</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Pending and Processed Verifications</h5>
						<h6 class="card-subtitle text-muted">Review user-submitted documents for verification.</h6>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>User</th>
									<th>Document Type</th>
									<th>Submitted At</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($verifications as $verification)
								<tr>
									<td>{{ $verification->user->name }}</td>
									<td>{{ $verification->document_type }}</td>
									<td>{{ $verification->created_at->format('Y/m/d H:i') }}</td>
									<td>
										<span class="badge 
											@if($verification->status === 'approved') bg-success 
											@elseif($verification->status === 'rejected') bg-danger 
											@else bg-warning @endif">
											{{ ucfirst($verification->status) }}
										</span>
									</td>
									<td>
										<a href="{{ asset('storage/' . $verification->file_path) }}" target="_blank" class="btn btn-info btn-sm">View Document</a>
										@if($verification->status === 'pending')
											<form action="{{ route('admin.users.verifications.approve') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Approve this verification?');">
												@csrf
												<input type="hidden" name="verification_id" value="{{ $verification->id }}">
												<button type="submit" class="btn btn-success btn-sm">Approve</button>
											</form>
											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal-{{ $verification->id }}">
												Reject
											</button>
										@endif
									</td>
								</tr>

								<!-- Reject Modal -->
								<div class="modal fade" id="rejectModal-{{ $verification->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $verification->id }}" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="rejectModalLabel-{{ $verification->id }}">Reject Verification</h5>
												<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
											</div>
											<form action="{{ route('admin.users.verifications.reject') }}" method="POST">
												@csrf
												<input type="hidden" name="verification_id" value="{{ $verification->id }}">
												<div class="modal-body">
													<div class="mb-3">
														<label for="remarks-{{ $verification->id }}" class="form-label">Remarks</label>
														<textarea class="form-control" id="remarks-{{ $verification->id }}" name="remarks" rows="3" required></textarea>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
													<button type="submit" class="btn btn-danger">Confirm Rejection</button>
												</div>
											</form>
										</div>
									</div>
								</div>
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
			order: [[2, 'desc']] // Order by submitted at descending
		});
	});
</script>
@endpush