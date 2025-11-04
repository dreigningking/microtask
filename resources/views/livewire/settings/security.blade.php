<div>
    <h5 class="mb-4">Security Settings</h5>

    {{-- 2FA Section --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="ri-shield-keyhole-line me-2"></i>Two-Factor Authentication (2FA)
            </h6>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="fw-medium">Status:</span>
                <span class="badge {{ $two_factor_enabled ? 'bg-success' : 'bg-secondary' }}">
                    {{ $two_factor_enabled ? 'Enabled' : 'Disabled' }}
                </span>
                <button wire:click="toggle2FA" @if($enforce_2fa) disabled @endif 
                        class="btn btn-sm {{ $two_factor_enabled ? 'btn-danger' : 'btn-primary' }}">
                    <i class="ri-{{ $two_factor_enabled ? 'close' : 'shield-check' }}-line me-1"></i>
                    {{ $two_factor_enabled ? 'Disable 2FA' : 'Enable 2FA' }}
                </button>
            </div>
            @if($enforce_2fa)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="ri-error-warning-line me-2"></i>2FA is enforced by the platform and cannot be disabled.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <small class="text-muted">All 2FA codes are sent to your email address.</small>
        </div>
    </div>

    {{-- Password Update Section --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="ri-lock-password-line me-2"></i>Update Password
            </h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ri-check-line me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form wire:submit.prevent="updatePassword">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Current Password</label>
                        <input type="password" wire:model.defer="current_password" class="form-control">
                        @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">New Password</label>
                        <input type="password" wire:model.defer="password" class="form-control">
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" wire:model.defer="password_confirmation" class="form-control">
                        @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Recent Logins Section --}}
    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="ri-history-line me-2"></i>Login History
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>IP ADDRESS</th>
                            <th>DATE & TIME</th>
                            <th>DEVICE</th>
                            <th>OPERATING SYSTEM</th>
                            <th>BROWSER</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_logins as $login)
                        <tr @if($login->is_current) class="table-primary" @endif>
                            <td class="fw-bold font-monospace">{{ $login->ip_address }}</td>
                            <td>{{ $login->created_at->format('M j, Y g:i A') }}</td>
                            <td>{{ $login->device }}</td>
                            <td>{{ $login->os }}</td>
                            <td>{{ $login->browser }}</td>
                            <td>
                                @if($login->status === 'Active')
                                    <span class="badge bg-primary">Active</span>
                                @elseif($login->status === 'Success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($login->status === 'Unusual location')
                                    <span class="badge bg-warning">Unusual location</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 