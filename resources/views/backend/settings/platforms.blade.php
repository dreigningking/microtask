@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Platforms
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Settings</a></li>
					<li class="breadcrumb-item active" aria-current="page">Platforms</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Platforms</h5>
                            <h6 class="card-subtitle text-muted">Manage task platforms for your platform.</h6>
                        </div>

                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#createPlatformModal">
                            <i class="align-middle" data-feather="plus"></i> New Platform
                        </button>
					</div>
					<div class="card-body">
						<table id="datatables-basic" class="table table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Description</th>
									<th>Tasks</th>
									<th>Status</th>
									<th>Created</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($platforms as $platform)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											@if($platform->image)
												<img src="{{ asset($platform->image) }}" alt="{{ $platform->name }}" class="rounded me-3" width="40" height="40">
											@else
												<div class="d-flex align-items-center justify-content-center rounded bg-light me-3" style="width:40px;height:40px;">
													<i class="align-middle" data-feather="folder"></i>
												</div>
											@endif
											<div>
												<strong>{{ $platform->name }}</strong>
												<div class="text-muted small">{{ $platform->slug }}</div>
											</div>
										</div>
									</td>
									<td>{{ Str::limit($platform->description, 50) }}</td>
									<td>{{ $platform->tasks_count ?? 0 }}</td>
									<td>
										@if($platform->is_active)
											<span class="badge bg-success">Active</span>
										@else
											<span class="badge bg-danger">Inactive</span>
										@endif
									</td>
									<td>{{ $platform->created_at->format('M d, Y') }}</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-sm btn-primary edit-platform-btn" 
												data-toggle="modal" 
												data-target="#editPlatformModal" 
												data-id="{{ $platform->id }}"
												data-name="{{ $platform->name }}"
												data-description="{{ $platform->description }}"
												data-status="{{ $platform->is_active }}"
												data-image="{{ $platform->image }}">
												<i class="align-middle" data-feather="edit-2"></i>
											</button>
											<a href="#" class="btn btn-sm btn-info">
												<i class="align-middle" data-feather="eye"></i>
											</a>
											<button type="button" class="btn btn-sm btn-danger delete-platform-btn" 
												data-id="{{ $platform->id }}" 
												data-name="{{ $platform->name }}">
												<i class="align-middle" data-feather="trash-2"></i>
											</button>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
                                    <th>Name</th>
									<th>Description</th>
									<th>Tasks</th>
									<th>Status</th>
									<th>Created</th>
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

<!-- Create Platform Modal -->
<div class="modal fade" id="createPlatformModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.settings.platforms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Platform</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                        <div class="invalid-feedback">Please provide a valid platform name.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                        <small class="form-text text-muted">Optional platform image (recommended size: 200x200px)</small>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="createActiveSwitch" name="is_active" value="1" checked>
                            <label class="form-check-label" for="createActiveSwitch">Active</label>
                        </div>
                        <small class="form-text text-muted">Inactive platforms won't be displayed to users.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Platform</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Platform Modal -->
<div class="modal fade" id="editPlatformModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editPlatformForm" action="{{ route('admin.settings.platforms.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Platform</h5>
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
                        <label class="form-label">Current Image</label>
                        <div class="mb-2" id="current-image-container">
                            <img id="current-image" src="" alt="Current image" class="img-fluid rounded" style="max-height: 100px; max-width: 100%; display: none;">
                            <div id="no-image-text" class="text-muted">No image uploaded</div>
                        </div>
                        <label class="form-label">New Image</label>
                        <input type="file" class="form-control" name="image">
                        <small class="form-text text-muted">Upload new image to replace current one</small>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="editActiveSwitch" name="is_active" value="1">
                            <label class="form-check-label" for="editActiveSwitch">Active</label>
                        </div>
                        <small class="form-text text-muted">Inactive platforms won't be displayed to users.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Platform</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePlatformModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deletePlatformForm" action="{{ route('admin.settings.platforms.destroy') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="delete-id">
            <div class="modal-header">
                    <h5 class="modal-title">Delete Platform</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3">
                    <p>Are you sure you want to delete <strong id="delete-platform-name"></strong>?</p>
                    <p class="text-danger"><i class="align-middle" data-feather="alert-triangle"></i> This action cannot be undone and may affect tasks using this platform.</p>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Platform</button>
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
		$('#datatables-basic').DataTable({
			responsive: true
		});

        // Edit platform modal
        $('.edit-platform-btn').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var status = $(this).data('status');
            var image = $(this).data('image');
            
            // Fill form fields
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-description').val(description);
            $('#editActiveSwitch').prop('checked', status == 1);
            
            // Handle image preview
            if (image) {
                $('#current-image').attr('src', image).show();
                $('#no-image-text').hide();
            } else {
                $('#current-image').hide();
                $('#no-image-text').show();
            }
        });

        // Delete platform modal
        $('.delete-platform-btn').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            
            $('#delete-platform-name').text(name);
            $('#delete-id').val(id);
            $('#deletePlatformModal').modal('show');
		});
	});
</script>
@endpush