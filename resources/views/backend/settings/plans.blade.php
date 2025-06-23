@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Plans
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Settings</a></li>
					<li class="breadcrumb-item active" aria-current="page">Plans</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between align-items-center">
						<div>
							<h5 class="card-title mb-0">Plans</h5>
							<h6 class="card-subtitle text-muted">Manage subscription plans.</h6>
						</div>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPlanModal">
							<i class="align-middle fas fa-plus"></i> New Plan
						</button>
					</div>
					<div class="card-body">
						<table id="plans-table" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									
									<th>Description</th>
									<th>Type</th>
									<th>Featured Promotion</th>
									<th>Urgency Promotion</th>
									<th>Active Tasks/Hour</th>
									<th>Withdrawal Multiplier</th>
									<th>Status</th>
									<th>Created</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($plans as $plan)
								<tr>
									<td>{{ $plan->name }}</td>
									<td>{{ Str::limit($plan->description, 50) }}</td>
									<td>{{ ucfirst($plan->type) }}</td>
									<td class="text-center">
										@if($plan->type == 'taskmaster')
											<span class="badge {{ $plan->featured_promotion ? 'bg-success' : 'bg-secondary' }}">{{ $plan->featured_promotion ? 'Yes' : 'No' }}</span>
										@endif
									</td>
									<td class="text-center">
										@if($plan->type == 'taskmaster')
											<span class="badge {{ $plan->urgency_promotion ? 'bg-success' : 'bg-secondary' }}">{{ $plan->urgency_promotion ? 'Yes' : 'No' }}</span>
										@endif
									</td>
									<td class="text-center">
										@if($plan->type == 'worker')
											{{ $plan->active_tasks_per_hour }}
										@endif
									</td>
									<td class="text-center">
										@if($plan->type == 'worker')
											{{ $plan->withdrawal_maximum_multiplier }}
										@endif
									</td>
									<td>
										@if($plan->is_active)
											<span class="badge bg-success">Active</span>
										@else
											<span class="badge bg-danger">Inactive</span>
										@endif
									</td>
									<td>{{ $plan->created_at->format('M d, Y') }}</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-sm btn-primary edit-plan-btn"
												data-toggle="modal"
												data-target="#editPlanModal"
												data-id="{{ $plan->id }}"
												data-name="{{ $plan->name }}"
												data-description="{{ $plan->description }}"
												data-type="{{ $plan->type }}"
												data-featured_promotion="{{ $plan->featured_promotion }}"
												data-urgency_promotion="{{ $plan->urgency_promotion }}"
												data-active_tasks_per_hour="{{ $plan->active_tasks_per_hour }}"
												data-withdrawal_maximum_multiplier="{{ $plan->withdrawal_maximum_multiplier }}"
												data-status="{{ $plan->is_active }}">
												<i class="fas fa-edit"></i>
											</button>
											<button type="button" class="btn btn-sm btn-danger delete-plan-btn"
												data-id="{{ $plan->id }}"
												data-name="{{ $plan->name }}">
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

<!-- Create Plan Modal -->
<div class="modal fade" id="createPlanModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('admin.settings.plans.store') }}" method="POST">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Create New Plan</h5>
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
					<div class="mb-3">
						<label class="form-label">Type <span class="text-danger">*</span></label>
						<select class="form-control" name="type" id="create-type" required>
							<option value="taskmaster">Taskmaster</option>
							<option value="worker">Worker</option>
						</select>
					</div>
					<div id="create-taskmaster-fields">
						<div class="form-check mb-2">
							<input class="form-check-input" type="checkbox" name="featured_promotion" id="create-featured-promotion" value="1">
							<label class="form-check-label" for="create-featured-promotion">Featured Promotion</label>
						</div>
						<div class="form-check mb-2">
							<input class="form-check-input" type="checkbox" name="urgency_promotion" id="create-urgency-promotion" value="1">
							<label class="form-check-label" for="create-urgency-promotion">Urgency Promotion</label>
						</div>
					</div>
					<div id="create-worker-fields" style="display:none;">
						<div class="mb-2">
							<label class="form-label">Active Tasks Per Hour</label>
							<input type="number" class="form-control" name="active_tasks_per_hour" id="create-active-tasks-per-hour" min="1" value="1">
						</div>
						<div class="mb-2">
							<label class="form-label">Withdrawal Maximum Multiplier</label>
							<input type="number" class="form-control" name="withdrawal_maximum_multiplier" id="create-withdrawal-multiplier" min="1" value="1">
						</div>
					</div>
					<div class="mb-3">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="createActiveSwitch" name="is_active" value="1" checked>
							<label class="form-check-label" for="createActiveSwitch">Active</label>
						</div>
						<small class="form-text text-muted">Inactive plans won't be displayed to users.</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Create Plan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Edit Plan Modal -->
<div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="editPlanForm" action="{{ route('admin.settings.plans.update') }}" method="POST">
				@csrf
				<input type="hidden" name="id" id="edit-id">
				<div class="modal-header">
					<h5 class="modal-title">Edit Plan</h5>
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
					<div class="mb-3">
						<label class="form-label">Type <span class="text-danger">*</span></label>
						<select class="form-control" name="type" id="edit-type" required>
							<option value="taskmaster">Taskmaster</option>
							<option value="worker">Worker</option>
						</select>
					</div>
					<div id="edit-taskmaster-fields">
						<div class="form-check mb-2">
							<input class="form-check-input" type="checkbox" name="featured_promotion" id="edit-featured-promotion" value="1">
							<label class="form-check-label" for="edit-featured-promotion">Featured Promotion</label>
						</div>
						<div class="form-check mb-2">
							<input class="form-check-input" type="checkbox" name="urgency_promotion" id="edit-urgency-promotion" value="1">
							<label class="form-check-label" for="edit-urgency-promotion">Urgency Promotion</label>
						</div>
					</div>
					<div id="edit-worker-fields" style="display:none;">
						<div class="mb-2">
							<label class="form-label">Active Tasks Per Hour</label>
							<input type="number" class="form-control" name="active_tasks_per_hour" id="edit-active-tasks-per-hour" min="1" value="1">
						</div>
						<div class="mb-2">
							<label class="form-label">Withdrawal Maximum Multiplier</label>
							<input type="number" class="form-control" name="withdrawal_maximum_multiplier" id="edit-withdrawal-multiplier" min="1" value="1">
						</div>
					</div>
					<div class="mb-3">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="editActiveSwitch" name="is_active" value="1">
							<label class="form-check-label" for="editActiveSwitch">Active</label>
						</div>
						<small class="form-text text-muted">Inactive plans won't be displayed to users.</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Update Plan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Delete Plan Modal -->
<div class="modal fade" id="deletePlanModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="deletePlanForm" action="{{ route('admin.settings.plans.destroy') }}" method="POST">
				@csrf
				<input type="hidden" name="id" id="delete-id">
				<div class="modal-header">
					<h5 class="modal-title">Delete Plan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body m-3">
					<p>Are you sure you want to delete <strong id="delete-plan-name"></strong>?</p>
					<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone and may affect subscriptions using this plan.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Delete Plan</button>
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

		// Show/hide fields in create modal
		$('#create-type').on('change', function() {
			if ($(this).val() === 'taskmaster') {
				$('#create-taskmaster-fields').show();
				$('#create-worker-fields').hide();
			} else {
				$('#create-taskmaster-fields').hide();
				$('#create-worker-fields').show();
			}
		}).trigger('change');

		// Show/hide fields in edit modal
		$('#edit-type').on('change', function() {
			if ($(this).val() === 'taskmaster') {
				$('#edit-taskmaster-fields').show();
				$('#edit-worker-fields').hide();
			} else {
				$('#edit-taskmaster-fields').hide();
				$('#edit-worker-fields').show();
			}
		});

		// Edit plan modal: populate fields
		$('.edit-plan-btn').on('click', function() {
			var id = $(this).data('id');
			var name = $(this).data('name');
			
			var description = $(this).data('description');
			var type = $(this).data('type');
			var featured = $(this).data('featured_promotion') == 1;
			var urgency = $(this).data('urgency_promotion') == 1;
			var activeTasks = $(this).data('active_tasks_per_hour');
			var withdrawal = $(this).data('withdrawal_maximum_multiplier');
			var status = $(this).data('status') == 1;

			$('#edit-id').val(id);
			$('#edit-name').val(name);
			
			$('#edit-description').val(description);
			$('#edit-type').val(type).trigger('change');
			$('#edit-featured-promotion').prop('checked', featured);
			$('#edit-urgency-promotion').prop('checked', urgency);
			$('#edit-active-tasks-per-hour').val(activeTasks);
			$('#edit-withdrawal-multiplier').val(withdrawal);
			$('#editActiveSwitch').prop('checked', status);
		});

		// Delete plan modal
		$('.delete-plan-btn').on('click', function() {
			var id = $(this).data('id');
			var name = $(this).data('name');
			$('#delete-id').val(id);
			$('#delete-plan-name').text(name);
			$('#deletePlanModal').modal('show');
		});
	});
</script>
@endpush