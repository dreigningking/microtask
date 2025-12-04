@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Boosters
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Settings</a></li>
					<li class="breadcrumb-item active" aria-current="page">Boosters</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between align-items-center">
						<div>
							<h5 class="card-title mb-0">Boosters</h5>
							<h6 class="card-subtitle text-muted">Manage Boosters.</h6>
						</div>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBoosterModal">
							<i class="align-middle fas fa-plus"></i> New Booster
						</button>
					</div>
					<div class="card-body">
						<table id="plans-table" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									
									<th>Description</th>
									<th>Mim Duration</th>
									<th>Active</th>
									<th>Total</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($boosters as $booster)
								<tr>
									<td>{{ $booster->name }}</td>
									<td>{{ Str::limit($booster->description, 50) }}</td>
									<td>{{ $booster->minimum_duration_days }}</td>
									<td class="text-center">
										 <span class="badge bg-success">{{ $booster->subscriptions->where('starts_at','<',now())->where('expires_at','>',now())->count()}}</span>
									</td>
									<td class="text-center">
										 <span class="badge bg-secondary">{{  $booster->subscriptions->count()}}</span>
									</td>
									
									<td>
										@if($booster->is_active)
											<span class="badge bg-success">Active</span>
										@else
											<span class="badge bg-danger">Inactive</span>
										@endif
									</td>
									
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-sm btn-primary edit-plan-btn"
												data-toggle="modal"
												data-target="#editBoosterModal"
												data-id="{{ $booster->id }}"
												data-name="{{ $booster->name }}"
												data-description="{{ $booster->description }}"
												data-minimum_duration_days="{{ $booster->minimum_duration_days }}"
												data-status="{{ $booster->is_active }}">
												<i class="fas fa-edit"></i>
											</button>
											<button type="button" class="btn btn-sm btn-danger delete-plan-btn"
												data-id="{{ $booster->id }}"
												data-name="{{ $booster->name }}">
												<i class="fas fa-trash"></i>
											</button>
										</div>
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

<!-- Create Booster Modal -->
<div class="modal fade" id="createBoosterModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('admin.settings.boosters.store') }}" method="POST">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Create New Booster</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body m-3">
					<div class="mb-3">
						<label class="form-label">Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" id="create-name" required>
					</div>
					
					<div class="mb-3">
						<label class="form-label">Description <span class="text-danger">*</span></label>
						<textarea class="form-control" name="description" id="create-description" rows="3" required></textarea>
					</div>
					<div class="mb-2">
						<label class="form-label">Minimum Days Maximum Multiplier</label>
						<input type="number" class="form-control" name="minimum_duration_days" id="create-minimum_duration_days" min="1" value="30">
					</div>
					
					
					<div class="mb-3">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="createActiveSwitch" name="is_active" value="1" checked>
							<label class="form-check-label" for="createActiveSwitch">Active</label>
						</div>
						<small class="form-text text-muted">Inactive boosters won't be displayed to users.</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Create Booster</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Edit Booster Modal -->
<div class="modal fade" id="editBoosterModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="editBoosterForm" action="{{ route('admin.settings.boosters.update') }}" method="POST">
				@csrf
				<input type="hidden" name="id" id="edit-id">
				<div class="modal-header">
					<h5 class="modal-title">Edit Booster</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body m-3">
					<div class="mb-3">
						<label class="form-label">Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" id="edit-name" required>
					</div>
					
					<div class="mb-3">
						<label class="form-label">Description <span class="text-danger">*</span></label>
						<textarea class="form-control" name="description" id="edit-description" rows="3" required></textarea>
					</div>
					<div class="mb-2">
						<label class="form-label">Minimum Days Maximum Multiplier</label>
						<input type="number" class="form-control" name="minimum_duration_days" id="edit-minimum_duration_days" min="1" value="30">
					</div>
					
					<div class="mb-3">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="editActiveSwitch" name="is_active" value="1">
							<label class="form-check-label" for="editActiveSwitch">Active</label>
						</div>
						<small class="form-text text-muted">Inactive boosters won't be displayed to users.</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Update Booster</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Delete Booster Modal -->
<div class="modal fade" id="deleteBoosterModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="deleteBoosterForm" action="{{ route('admin.settings.boosters.destroy') }}" method="POST">
				@csrf
				<input type="hidden" name="id" id="delete-id">
				<div class="modal-header">
					<h5 class="modal-title">Delete Booster</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body m-3">
					<p>Are you sure you want to delete <strong id="delete-plan-name"></strong>?</p>
					<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone and may affect subscriptions using this booster.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Delete Booster</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	$(function() {
		// Datatables basic
		$('#plans-table').DataTable({
			responsive: true
		});

		

		

		// Edit plan modal: populate fields
		$('.edit-plan-btn').on('click', function() {
			var id = $(this).data('id');
			var name = $(this).data('name');
			
			var description = $(this).data('description');
			var type = $(this).data('type');
			var minimum_duration_days = $(this).data('minimum_duration_days');
			var status = $(this).data('status') == 1;

			$('#edit-id').val(id);
			$('#edit-name').val(name);
			
			$('#edit-description').val(description);
			$('#edit-minimum_duration_days').val(minimum_duration_days);
			$('#editActiveSwitch').prop('checked', status);
		});

		// Delete plan modal
		$('.delete-plan-btn').on('click', function() {
			var id = $(this).data('id');
			var name = $(this).data('name');
			$('#delete-id').val(id);
			$('#delete-plan-name').text(name);
			$('#deleteBoosterModal').modal('show');
		});
	});
</script>
@endpush