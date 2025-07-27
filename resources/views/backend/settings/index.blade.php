@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Settings Sections</h5>
                    </div>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#core" role="tab">Core Settings</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#roles" role="tab">Roles & Permissions</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#notifications" role="tab">Notifications</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#staff" role="tab">Staff</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-xl-9">
                <div class="tab-content">
                    <!-- Core Settings Tab -->
                    <div class="tab-pane fade show active" id="core" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Core System Settings</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.settings.core.save')}}" method="post">@csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group form-switch m-3">
                                                <input type="hidden" name="enable_system_monitoring" value="0">
                                                <input class="form-check-input" type="checkbox" id="enableSystemMonitoring" name="enable_system_monitoring" value="1" {{ optional($settings->where('name','enable_system_monitoring')->first())->value == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="enableSystemMonitoring">Enable System Monitoring</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-switch m-3">
                                                <input type="hidden" name="freeze_wallets_globally" value="0">
                                                <input class="form-check-input" type="checkbox" id="freezeWalletsGlobally" name="freeze_wallets_globally" value="1" {{ optional($settings->where('name','freeze_wallets_globally')->first())->value == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="freezeWalletsGlobally">Freeze Wallets Globally</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-switch m-3">
                                                <input type="hidden" name="allow_wallet_funds_exchange" value="0">
                                                <input class="form-check-input" type="checkbox" id="allowWalletFundsExchange" name="allow_wallet_funds_exchange" value="1" {{ optional($settings->where('name','allow_wallet_funds_exchange')->first())->value == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="allowWalletFundsExchange">Allow Wallet Funds Exchange</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="jobInviteExpiry">Job Invite Expiry (days)</label>
                                                <input type="number" class="form-control" id="jobInviteExpiry" name="job_invite_expiry" min="1" value="{{ optional($settings->where('name','job_invite_expiry')->first())->value ?? 7 }}">
                                                <small class="form-text text-muted">Number of days before a job invite expires.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="submissionReviewDeadline">Submission Review Deadline (hours)</label>
                                                <input type="number" class="form-control" id="submissionReviewDeadline" name="submission_review_deadline" min="1" value="{{ optional($settings->where('name','submission_review_deadline')->first())->value ?? 24 }}">
                                                <small class="form-text text-muted">Number of hours a taskmaster has to review a submission before admin takes over.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-switch m-3">
                                                <input type="hidden" name="enforce_2fa" value="0">
                                                <input class="form-check-input" type="checkbox" id="enforce2FA" name="enforce_2fa" value="1" {{ optional($settings->where('name','enforce_2fa')->first())->value == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="enforce2FA">Enforce Two-Factor Authentication (2FA) for all users</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="freeUserTaskLimit">Free Users' Task Limit (per hour)</label>
                                                <input type="number" class="form-control" id="freeUserTaskLimit" name="free_user_task_limit" min="1" value="{{ optional($settings->where('name','free_user_task_limit')->first())->value ?? 1 }}">
                                                <small class="form-text text-muted">Number of tasks a free user can do within an hour.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary w-100">Save Core Settings</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Roles & Permissions Tab -->
                    <div class="tab-pane fade" id="roles" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Roles & Permissions</h5>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRoleModal"><i class="fas fa-plus"></i> Add Role</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Role</th>
                                                <th>Permissions</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @foreach($role->permissions as $perm)
                                                    <span class="badge badge-info">{{ $perm->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary edit-role-btn" data-toggle="modal" data-target="#editRoleModal{{ $role->id }}"><i class="fas fa-edit"></i> Edit</button>
                                                    @if($role->users->count() === 0)
                                                    <form action="{{ route('admin.settings.roles.destroy', $role) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Add Role Modal -->
                        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.settings.roles.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add New Role</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="addRoleName">Role Name</label>
                                                <input type="text" class="form-control" id="addRoleName" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Permissions</label>
                                                <div class="row">
                                                    @foreach($permissions as $perm)
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="addPerm{{ $perm->id }}">
                                                            <label class="form-check-label" for="addPerm{{ $perm->id }}">{{ $perm->name }}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add Role</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Role Modal -->
                        @foreach($roles as $role)
                        <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.settings.roles.update', $role) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Role</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="editRoleName{{ $role->id }}">Role Name</label>
                                                <input type="text" class="form-control" id="editRoleName{{ $role->id }}" name="name" value="{{ $role->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Permissions</label>
                                                <div class="row">
                                                    @foreach($permissions as $perm)
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="editPerm{{ $role->id }}_{{ $perm->id }}" {{ $role->permissions->contains($perm->id) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="editPerm{{ $role->id }}_{{ $perm->id }}">{{ $perm->name }}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Email Notifications Tab -->
                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="{{route('admin.settings.notifications.save')}}" method="post">@csrf
                                    @php
                                    // Get saved settings for notifications
                                    $emailNotifications = [];
                                    $webNotifications = [];
                                    if(isset($settings)) {
                                    $emailSetting = $settings->where('name', 'email_notifications')->first();
                                    $webSetting = $settings->where('name', 'web_notifications')->first();
                                    if($emailSetting && $emailSetting->value) {
                                    $emailNotifications = json_decode($emailSetting->value, true) ?? [];
                                    }
                                    if($webSetting && $webSetting->value) {
                                    $webNotifications = json_decode($webSetting->value, true) ?? [];
                                    }
                                    }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title mb-0">Email Notifications</h5>
                                            <div class="form-group form-switch m-3">
                                                <input class="form-check-input" type="checkbox" id="notifyTaskAssigned" name="email_notifications[]" value="task_assigned"
                                                    {{ in_array('task_assigned', $emailNotifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notifyTaskAssigned">Task Assigned</label>
                                            </div>
                                            <div class="form-group form-switch m-3">
                                                <input class="form-check-input" type="checkbox" id="notifyTaskCompleted" name="email_notifications[]" value="task_completed"
                                                    {{ in_array('task_completed', $emailNotifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notifyTaskCompleted">Task Completed</label>
                                            </div>
                                            <div class="form-group form-switch m-3">
                                                <input class="form-check-input" type="checkbox" id="notifyWeeklySummary" name="email_notifications[]" value="weekly_summary"
                                                    {{ in_array('weekly_summary', $emailNotifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notifyWeeklySummary">Weekly Summary</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title mb-0">Web Notifications</h5>
                                            <div class="form-group form-switch m-3">
                                                <input class="form-check-input" type="checkbox" id="webNotifyTaskAssigned" name="web_notifications[]" value="task_assigned"
                                                    {{ in_array('task_assigned', $webNotifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="webNotifyTaskAssigned">Task Assigned</label>
                                            </div>
                                            <div class="form-group form-switch m-3">
                                                <input class="form-check-input" type="checkbox" id="webNotifyTaskCompleted" name="web_notifications[]" value="task_completed"
                                                    {{ in_array('task_completed', $webNotifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="webNotifyTaskCompleted">Task Completed</label>
                                            </div>
                                            <div class="form-group form-switch m-3">
                                                <input class="form-check-input" type="checkbox" id="webNotifyWeeklySummary" name="web_notifications[]" value="weekly_summary"
                                                    {{ in_array('weekly_summary', $webNotifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="webNotifyWeeklySummary">Weekly Summary</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Save Email Notification Settings</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Staff Tab -->
                    <div class="tab-pane fade" id="staff" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Staff</h5>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addStaffModal"><i class="fas fa-plus"></i> Add Staff</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Country</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staff as $user)
                                            <tr>
                                                <td>
                                                    {{ $user->name }}
                                                    @if(isset($user->is_active) && !$user->is_active)
                                                    <span class="badge badge-danger ml-1">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->first_role->name ?? '-' }}</td>
                                                <td>
                                                    @if($user->first_role && $user->first_role->id == 1)
                                                    Global
                                                    @elseif($user->country)
                                                    {{ $user->country->name }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary edit-staff-btn" data-toggle="modal" data-target="#editStaffModal{{ $user->id }}"><i class="fas fa-edit"></i> Edit</button>
                                                    <form action="{{ route('admin.settings.staff.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Add Staff Modal -->
                        <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.settings.staff.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add New Staff</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="addStaffName">Name</label>
                                                <input type="text" class="form-control" id="addStaffName" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="addStaffEmail">Email</label>
                                                <input type="email" class="form-control" id="addStaffEmail" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="addStaffRole">Role</label>
                                                <select class="form-control" id="addStaffRole" name="role_id" required>
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="addStaffPassword">Password</label>
                                                <input type="password" class="form-control" id="addStaffPassword" name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="addStaffCountry">Country</label>
                                                <select class="form-control" id="addStaffCountry" name="country_id">
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-switch m-3">
                                                <input type="hidden" name="is_active" value="0">
                                                <input class="form-check-input" type="checkbox" id="addStaffActive" name="is_active" value="1" checked>
                                                <label class="form-check-label" for="addStaffActive">Active</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add Staff</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Staff Modal -->
                        @foreach($staff as $user)
                        <div class="modal fade" id="editStaffModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.settings.staff.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Staff</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="editStaffName{{ $user->id }}">Name</label>
                                                <input type="text" class="form-control" id="editStaffName{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="editStaffEmail{{ $user->id }}">Email</label>
                                                <input type="email" class="form-control" id="editStaffEmail{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="editStaffRole{{ $user->id }}">Role</label>
                                                <select class="form-control" id="editStaffRole{{ $user->id }}" name="role_id" required>
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="editStaffPassword{{ $user->id }}">Password <small>(leave blank to keep current)</small></label>
                                                <input type="password" class="form-control" id="editStaffPassword{{ $user->id }}" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="editStaffCountry{{ $user->id }}">Country</label>
                                                <select class="form-control" id="editStaffCountry{{ $user->id }}" name="country_id">

                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-switch m-3">
                                                <input type="hidden" name="is_active" value="0">
                                                <input class="form-check-input" type="checkbox" id="editStaffActive{{ $user->id }}" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="editStaffActive{{ $user->id }}">Active</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection