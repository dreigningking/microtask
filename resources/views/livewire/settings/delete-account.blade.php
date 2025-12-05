<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h4 mb-0">Profile Settings</h1>
                    <p class="mb-0">Manage your account information, security, and preferences</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="earnings.html" class="btn btn-outline-light">Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">

            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4">
                    @include('livewire.settings.menu')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="card-title mb-0">
                                <i class="ri-delete-bin-line me-2"></i>Delete Account
                            </h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="alert alert-danger" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-error-warning-line me-2"></i>
                                        <div>
                                            <h6 class="alert-heading mb-1">Danger Zone</h6>
                                            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-danger">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="card-title mb-0">
                                            <i class="ri-delete-bin-line me-2"></i>Delete Account
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-4">
                                            Permanently delete your account and all of its data. This action cannot be undone.
                                        </p>

                                        <button wire:click="confirmDeletion" class="btn btn-danger">
                                            <i class="ri-delete-bin-line me-1"></i>Delete Account
                                        </button>
                                    </div>
                                </div>

                                @if($confirming)
                                <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header border-danger">
                                                <h5 class="modal-title text-danger">
                                                    <i class="ri-error-warning-line me-2"></i>Confirm Account Deletion
                                                </h5>
                                                <button type="button" class="btn-close" wire:click="$set('confirming', false)"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-warning" role="alert">
                                                    <i class="ri-alert-line me-2"></i>
                                                    <strong>Warning:</strong> This action cannot be undone. All your data will be permanently deleted.
                                                </div>

                                                <p class="mb-3">
                                                    Please enter your password to confirm you would like to permanently delete your account.
                                                </p>

                                                <div class="mb-3">
                                                    <label for="delete_password" class="form-label">Password</label>
                                                    <input wire:model.defer="password" type="password"
                                                        id="delete_password"
                                                        class="form-control"
                                                        placeholder="Enter your password">
                                                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" wire:click="$set('confirming', false)">
                                                    <i class="ri-close-line me-1"></i>Cancel
                                                </button>
                                                <button type="button" class="btn btn-danger" wire:click="deleteAccount">
                                                    <i class="ri-delete-bin-line me-1"></i>Delete Account
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-backdrop fade show"></div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>