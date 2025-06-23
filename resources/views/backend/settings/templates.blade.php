@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Templates
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Templates</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Task Templates</h5>
                            <h6 class="card-subtitle text-muted">Manage reusable task templates for your platform.</h6>
                        </div>

                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#createTemplateModal">
                            <i class="align-middle fas fa-plus"></i> New Template
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="datatables-basic" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Platform</th>
                                    <th>Task Fields</th>
                                    <th>Submission Fields</th>
                                    <th>Status</th>
                                    <th>Tasks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($templates as $template)
                                <tr>
                                    <td>
                                        <strong>{{ $template->name }}</strong>
                                    </td>
                                    <td>{{ $template->platform->name}}</td>
                                    <td>{{ count($template->task_fields) }}</td>
                                    <td>{{ count($template->submission_fields) }}</td>
                                    <td>
                                        @if($template->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $template->tasks->count() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary edit-template-btn" 
                                                data-toggle="modal" 
                                                data-target="#editTemplateModal" 
                                                data-id="{{ $template->id }}"
                                                data-name="{{ $template->name }}"
                                                data-description="{{ $template->description }}"
                                                data-task-fields="{{ json_encode($template->task_fields,true) }}"
                                                data-submission-fields="{{ json_encode($template->submission_fields,true) }}"
                                                data-status="{{ $template->is_active }}"
                                                data-platform-id="{{ $template->platform_id }}">
                                                <i class="align-middle fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info view-template-btn"
                                                data-toggle="modal"
                                                data-target="#viewTemplateModal"
                                                data-id="{{ $template->id }}"
                                                data-name="{{ $template->name }}"
                                                data-description="{{ $template->description }}"
                                                data-task-fields="{{ json_encode($template->task_fields,true) }}"
                                                data-submission-fields="{{ json_encode($template->submission_fields,true) }}"
                                                data-status="{{ $template->is_active }}"
                                                data-platform="{{ $template->platform->name }}"
                                                data-platform-id="{{ $template->platform_id }}"
                                                data-created="{{ $template->created_at->format('M d, Y') }}">
                                                <i class="align-middle fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-template-btn" 
                                                data-id="{{ $template->id }}" 
                                                data-name="{{ $template->name }}">
                                                <i class="align-middle fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Platform</th>
                                    <th>Task Fields</th>
                                    <th>Submission Fields</th>
                                    <th>Status</th>
                                    <th>Tasks</th>
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

<!-- Create Template Modal -->
<div class="modal fade" id="createTemplateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.settings.templates.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="e.g Facebook Video Share" required>
                                <div class="invalid-feedback">Please provide a valid template name.</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Plaform</label>
                                <select name="platform_id" class="form-control">
                                    @foreach ($platforms as $platform)
                                        <option value="{{$platform->id}}">{{$platform->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="createActiveSwitch" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="createActiveSwitch">Active</label>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    
                    <!-- Task Fields Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Task Fields</h5>
                            <button type="button" class="btn btn-sm btn-primary add-task-field-btn">
                                <i class="align-middle fas fa-plus"></i> Add Field
                            </button>
                        </div>
                        <p class="text-muted small mb-3">These fields will be shown when creating a task using this template.</p>
                        
                        <div id="task-fields-container">
                            <!-- Task fields will be added here dynamically -->
                        </div>
                    </div>
                    
                    <!-- Submission Fields Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Submission Fields</h5>
                            <button type="button" class="btn btn-sm btn-primary add-submission-field-btn">
                                <i class="align-middle fas fa-plus"></i> Add Field
                            </button>
                        </div>
                        <p class="text-muted small mb-3">These fields will be shown when submitting work for a task based on this template.</p>
                        
                        <div id="submission-fields-container">
                            <!-- Submission fields will be added here dynamically -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Template Modal -->
<div class="modal fade" id="viewTemplateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Template Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4 id="view-name" class="mb-1"></h4>
                        <p id="view-description" class="text-muted"></p>
                        <div class="mb-2"><span class="font-weight-bold">Platform:</span> <span id="view-platform" class="text-primary"></span></div>
                    </div>
                    <div class="col-md-4 text-right">
                        <span id="view-status" class="badge bg-success mb-2">Active</span>
                        <div class="small text-muted">Created: <span id="view-created"></span></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Task Fields</h5>
                                <h6 class="card-subtitle text-muted">Fields shown when creating a task</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" id="view-task-fields">
                                    <!-- Task fields will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Submission Fields</h5>
                                <h6 class="card-subtitle text-muted">Fields shown when submitting work</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" id="view-submission-fields">
                                    <!-- Submission fields will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="view-edit-btn">
                    <i class="align-middle fas fa-edit"></i> Edit Template
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Template Modal -->
<div class="modal fade" id="editTemplateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.settings.templates.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="edit-name" required>
                                <div class="invalid-feedback">Please provide a valid template name.</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Plaform</label>
                                <select name="platform_id" class="form-control" id="edit-platform-select">
                                    @foreach ($platforms as $platform)
                                        <option value="{{$platform->id}}">{{$platform->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="editActiveSwitch" name="is_active" value="1">
                                    <label class="form-check-label" for="editActiveSwitch">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="edit-description" rows="3" required></textarea>
                    </div>
                    
                    <!-- Task Fields Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Task Fields</h5>
                            <button type="button" class="btn btn-sm btn-primary edit-add-task-field-btn">
                                <i class="align-middle fas fa-plus"></i> Add Field
                            </button>
                        </div>
                        <p class="text-muted small mb-3">These fields will be shown when creating a task using this template.</p>
                        
                        <div id="edit-task-fields-container">
                            <!-- Task fields will be added here dynamically -->
                        </div>
                    </div>
                    
                    <!-- Submission Fields Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Submission Fields</h5>
                            <button type="button" class="btn btn-sm btn-primary edit-add-submission-field-btn">
                                <i class="align-middle fas fa-plus"></i> Add Field
                            </button>
                        </div>
                        <p class="text-muted small mb-3">These fields will be shown when submitting work for a task based on this template.</p>
                        
                        <div id="edit-submission-fields-container">
                            <!-- Submission fields will be added here dynamically -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTemplateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteTemplateForm" action="{{ route('admin.settings.templates.destroy') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="delete-id">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <p>Are you sure you want to delete <strong id="delete-template-name"></strong>?</p>
                    <p class="text-danger"><i class="align-middle fas fa-exclamation-triangle"></i> This action cannot be undone and may affect tasks using this template.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Field Template (Hidden) -->
<div id="field-template" class="d-none">
    <div class="field-item card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">Field <span class="field-number"></span></h6>
                <button type="button" class="btn btn-sm btn-danger remove-field-btn">
                    <i class="align-middle fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Field Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-title" name="field_title[]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Field Type <span class="text-danger">*</span></label>
                        <select class="form-control field-type" name="field_type[]" required>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="url">URL</option>
                            <option value="file">File Upload</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                            <option value="select">Dropdown</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row field-options" style="display: none;">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Options (comma separated) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control field-options-input" name="field_options[]" placeholder="Option 1, Option 2, Option 3">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Placeholder</label>
                        <input type="text" class="form-control field-placeholder" name="field_placeholder[]" placeholder="Enter placeholder text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input field-required" type="checkbox" name="field_required[]" value="1" checked>
                            <label class="form-check-label">Required Field</label>
                        </div>
                    </div>
                </div>
            </div>
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

        // Field counter
        let taskFieldCounter = 0;
        let submissionFieldCounter = 0;

        // Add task field
        $('.add-task-field-btn').on('click', function() {
            addField('task');
        });

        // Add submission field
        $('.add-submission-field-btn').on('click', function() {
            addField('submission');
        });

        // Add task field in edit modal
        $('.edit-add-task-field-btn').on('click', function() {
            addFieldToEdit('task');
        });

        // Add submission field in edit modal
        $('.edit-add-submission-field-btn').on('click', function() {
            addFieldToEdit('submission');
        });

        // Function to add a new field
        function addField(type) {
            const template = $('#field-template').html();
            const container = type === 'task' ? $('#task-fields-container') : $('#submission-fields-container');
            const fieldNumber = type === 'task' ? ++taskFieldCounter : ++submissionFieldCounter;
            
            // Add field-type prefix to differentiate between task and submission fields
            const fieldTypePrefix = type === 'task' ? 'task_fields' : 'submission_fields';
            
            // Create the field
            const field = $(template);
            field.find('.field-number').text(fieldNumber);
            
            // Update name attributes to include the field type prefix
            field.find('.field-title').attr('name', `${fieldTypePrefix}[${fieldNumber}][title]`);
            field.find('.field-type').attr('name', `${fieldTypePrefix}[${fieldNumber}][type]`);
            field.find('.field-options-input').attr('name', `${fieldTypePrefix}[${fieldNumber}][options]`);
            field.find('.field-placeholder').attr('name', `${fieldTypePrefix}[${fieldNumber}][placeholder]`);
            field.find('.field-required').attr('name', `${fieldTypePrefix}[${fieldNumber}][required]`);
            
            // Add to container
            container.append(field);
            
            // Add event listener for field type change
            field.find('.field-type').on('change', function() {
                toggleOptionsField($(this));
            });
            
            // Add event listener for remove button - Using direct event binding instead of delegated events
            field.find('.remove-field-btn').on('click', function() {
                $(this).closest('.field-item').remove();
            });
        }

        // Function to add a field to the edit modal
        function addFieldToEdit(type) {
            const template = $('#field-template').html();
            const container = type === 'task' ? $('#edit-task-fields-container') : $('#edit-submission-fields-container');
            const fieldNumber = type === 'task' ? ++taskFieldCounter : ++submissionFieldCounter;
            
            // Add field-type prefix to differentiate between task and submission fields
            const fieldTypePrefix = type === 'task' ? 'task_fields' : 'submission_fields';
            
            // Create the field
            const field = $(template);
            field.find('.field-number').text(fieldNumber);
            
            // Update name attributes to include the field type prefix
            field.find('.field-title').attr('name', `${fieldTypePrefix}[${fieldNumber}][title]`);
            field.find('.field-type').attr('name', `${fieldTypePrefix}[${fieldNumber}][type]`);
            field.find('.field-options-input').attr('name', `${fieldTypePrefix}[${fieldNumber}][options]`);
            field.find('.field-placeholder').attr('name', `${fieldTypePrefix}[${fieldNumber}][placeholder]`);
            field.find('.field-required').attr('name', `${fieldTypePrefix}[${fieldNumber}][required]`);
            
            // Add to container
            container.append(field);
            
            // Add event listener for field type change
            field.find('.field-type').on('change', function() {
                toggleOptionsField($(this));
            });
            
            // Add event listener for remove button - Using direct event binding instead of delegated events
            field.find('.remove-field-btn').on('click', function() {
                $(this).closest('.field-item').remove();
            });
        }

        // Toggle options field based on field type
        function toggleOptionsField(selectElement) {
            const fieldType = selectElement.val();
            const optionsRow = selectElement.closest('.row').next('.field-options');
            
            if (fieldType === 'select' || fieldType === 'checkbox' || fieldType === 'radio') {
                optionsRow.show();
                optionsRow.find('.field-options-input').attr('required', true);
            } else {
                optionsRow.hide();
                optionsRow.find('.field-options-input').attr('required', false);
            }
        }

        // View template
        $('.view-template-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');
            const taskFields = JSON.parse($(this).attr('data-task-fields'));
            const submissionFields = JSON.parse($(this).attr('data-submission-fields'));
            const status = $(this).attr('data-status');
            const created = $(this).attr('data-created');
            const platform = $(this).attr('data-platform');
            const platformId = $(this).attr('data-platform-id');
            
            // Set basic details
            $('#view-name').text(name);
            $('#view-description').text(description);
            $('#view-created').text(created);
            $('#view-platform').text(platform);
            
            // Set status badge
            if (status == 1) {
                $('#view-status').removeClass('bg-danger').addClass('bg-success').text('Active');
            } else {
                $('#view-status').removeClass('bg-success').addClass('bg-danger').text('Inactive');
            }
            
            // Clear existing fields
            $('#view-task-fields').empty();
            $('#view-submission-fields').empty();
            
            // Add task fields
            if (taskFields && taskFields.length > 0) {
                taskFields.forEach(function(field) {
                    const fieldItem = $(`
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">${field.title}</h6>
                                    <small class="text-muted">Type: ${formatFieldType(field.type)}</small>
                                </div>
                                <span class="badge ${field.required ? 'bg-danger' : 'bg-secondary'} ml-2">
                                    ${field.required ? 'Required' : 'Optional'}
                                </span>
                            </div>
                            ${field.options ? `<div class="mt-2"><small class="text-muted">Options: ${field.options}</small></div>` : ''}
                            ${field.placeholder ? `<div><small class="text-muted">Placeholder: ${field.placeholder}</small></div>` : ''}
                        </div>
                    `);
                    $('#view-task-fields').append(fieldItem);
                });
            } else {
                $('#view-task-fields').append('<div class="list-group-item text-center text-muted">No task fields defined</div>');
            }
            
            // Add submission fields
            if (submissionFields && submissionFields.length > 0) {
                submissionFields.forEach(function(field) {
                    const fieldItem = $(`
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">${field.title}</h6>
                                    <small class="text-muted">Type: ${formatFieldType(field.type)}</small>
                                </div>
                                <span class="badge ${field.required ? 'bg-danger' : 'bg-secondary'} ml-2">
                                    ${field.required ? 'Required' : 'Optional'}
                                </span>
                            </div>
                            ${field.options ? `<div class="mt-2"><small class="text-muted">Options: ${field.options}</small></div>` : ''}
                            ${field.placeholder ? `<div><small class="text-muted">Placeholder: ${field.placeholder}</small></div>` : ''}
                        </div>
                    `);
                    $('#view-submission-fields').append(fieldItem);
                });
            } else {
                $('#view-submission-fields').append('<div class="list-group-item text-center text-muted">No submission fields defined</div>');
            }

            // Set up the edit button to open edit modal with this template
            $('#view-edit-btn').off('click').on('click', function() {
                $('#viewTemplateModal').modal('hide');
                
                // Trigger edit with a slight delay to allow the first modal to close
                setTimeout(function() {
                    $('.edit-template-btn[data-id="' + id + '"]').trigger('click');
                }, 500);
            });
        });

        // Helper function to format field type for display
        function formatFieldType(type) {
            const types = {
                'text': 'Text Input',
                'textarea': 'Text Area',
                'number': 'Number',
                'email': 'Email',
                'url': 'URL',
                'file': 'File Upload',
                'date': 'Date',
                'time': 'Time',
                'select': 'Dropdown',
                'checkbox': 'Checkbox',
                'radio': 'Radio Buttons'
            };
            
            return types[type] || type;
        }

        // Edit template
        $('.edit-template-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');
            const taskFields = JSON.parse($(this).attr('data-task-fields'));
            const submissionFields = JSON.parse($(this).attr('data-submission-fields'));
            const status = $(this).attr('data-status');
            const platformId = $(this).attr('data-platform-id');
            
            // Reset counters
            taskFieldCounter = 0;
            submissionFieldCounter = 0;
            
            // Set basic fields
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-description').val(description);
            $('#editActiveSwitch').prop('checked', status == 1);
            $('#edit-platform-select').val(platformId);
            
            // Clear existing fields
            $('#edit-task-fields-container').empty();
            $('#edit-submission-fields-container').empty();
            
            // Add task fields
            if (taskFields && taskFields.length > 0) {
                taskFields.forEach(function(field, index) {
                    addEditField('task', field, index + 1);
                });
            }
            
            // Add submission fields
            if (submissionFields && submissionFields.length > 0) {
                submissionFields.forEach(function(field, index) {
                    addEditField('submission', field, index + 1);
                });
            }
        });

        // Function to add existing fields to edit form
        function addEditField(type, fieldData, index) {
            const template = $('#field-template').html();
            const container = type === 'task' ? $('#edit-task-fields-container') : $('#edit-submission-fields-container');
            const fieldNumber = index;
            
            // Update counter
            if (type === 'task' && fieldNumber > taskFieldCounter) {
                taskFieldCounter = fieldNumber;
            } else if (type === 'submission' && fieldNumber > submissionFieldCounter) {
                submissionFieldCounter = fieldNumber;
            }
            
            // Add field-type prefix to differentiate between task and submission fields
            const fieldTypePrefix = type === 'task' ? 'task_fields' : 'submission_fields';
            
            // Create the field
            const field = $(template);
            field.find('.field-number').text(fieldNumber);
            
            // Update name attributes and values
            field.find('.field-title').attr('name', `${fieldTypePrefix}[${fieldNumber}][title]`).val(fieldData.title);
            field.find('.field-type').attr('name', `${fieldTypePrefix}[${fieldNumber}][type]`).val(fieldData.type);
            field.find('.field-options-input').attr('name', `${fieldTypePrefix}[${fieldNumber}][options]`).val(fieldData.options || '');
            field.find('.field-placeholder').attr('name', `${fieldTypePrefix}[${fieldNumber}][placeholder]`).val(fieldData.placeholder || '');
            field.find('.field-required').attr('name', `${fieldTypePrefix}[${fieldNumber}][required]`).prop('checked', fieldData.required);
            
            // Show options field if needed
            if (fieldData.type === 'select' || fieldData.type === 'checkbox' || fieldData.type === 'radio') {
                field.find('.field-options').show();
                field.find('.field-options-input').attr('required', true);
            }
            
            // Add to container
            container.append(field);
            
            // Add event listener for field type change
            field.find('.field-type').on('change', function() {
                toggleOptionsField($(this));
            });
            
            // Add event listener for remove button - Using direct event binding
            field.find('.remove-field-btn').on('click', function() {
                $(this).closest('.field-item').remove();
            });
        }

        // Delete template
        $('.delete-template-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            $('#delete-id').val(id);
            $('#delete-template-name').text(name);
            
            $('#deleteTemplateModal').modal('show');
        });
        
        // Alternative approach for remove button using event delegation
        $(document).on('click', '.remove-field-btn', function() {
            $(this).closest('.field-item').remove();
        });
    });
</script>
@endpush