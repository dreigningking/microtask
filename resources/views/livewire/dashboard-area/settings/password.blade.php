<div>
    <h5 class="mb-4">Update Password</h5>
    
    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="ri-lock-password-line me-2"></i>Password Security
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">Ensure your account is using a long, random password to stay secure.</p>
            
            <form wire:submit="updatePassword">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" 
                               wire:model="current_password" 
                               id="current_password" 
                               class="form-control" 
                               required 
                               autocomplete="current-password">
                        @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" 
                               wire:model="password" 
                               id="new_password" 
                               class="form-control" 
                               required 
                               autocomplete="new-password">
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" 
                               wire:model="password_confirmation" 
                               id="password_confirmation" 
                               class="form-control" 
                               required 
                               autocomplete="new-password">
                        @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Save Changes
                    </button>
                </div>
            </form>
            
            @if (session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="ri-check-line me-2"></i>Password updated successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
</div>
