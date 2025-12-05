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
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-bank-line me-2"></i>Bank Accounts
                            </h5>
                        </div>
                        <div class="card-body">
                            <div>
                                @if ($storage_location === 'on_premises')
                                @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="ri-check-line me-2"></i>{{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if(!empty($verification_settings['required']) && $bankAccount)
                                <div class="alert {{ $bankAccount->verified_at ? 'alert-success' : 'alert-warning' }} alert-dismissible fade show" role="alert">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($bankAccount->verified_at)
                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                            @else
                                            <i class="ri-error-warning-fill text-warning"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0">
                                                @if($bankAccount->verified_at)
                                                Your bank account has been verified.
                                                @else
                                                Your bank account is pending verification.
                                                @endif
                                            </p>
                                        </div>
                                        @if(!$bankAccount->verified_at)
                                        <div class="ms-3">
                                            <button wire:click="verifyAccount" class="btn btn-sm btn-outline-warning">
                                                Verify Now <i class="ri-arrow-right-line ms-1"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <form wire:submit.prevent="saveBankAccount">
                                    <div class="row g-3">
                                        @foreach($required_fields as $field)
                                        @if($field['type'] === 'select')
                                        <div class="col-md-6">
                                            <label for="{{ $field['slug'] }}" class="form-label">{{ $field['title'] }}</label>
                                            <select id="{{ $field['slug'] }}" wire:model.defer="{{ $field['slug'] }}"
                                                class="form-select"
                                                {{ !$isEditMode && $bankAccount ? 'disabled' : '' }}>
                                                <option value="">{{ $field['placeholder'] }}</option>
                                                @if($field['slug'] === 'bank_code')
                                                @foreach($banks as $bank)
                                                <option value="{{ $bank['code'] }}">{{ ucwords($bank['name']) }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error($field['slug']) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <label for="{{ $field['slug'] }}" class="form-label">{{ $field['title'] }}</label>
                                            <input type="{{ $field['type'] }}" id="{{ $field['slug'] }}" wire:model.defer="{{ $field['slug'] }}"
                                                class="form-control"
                                                placeholder="{{ $field['placeholder'] }}"
                                                {{ !$isEditMode && $bankAccount ? 'disabled' : '' }}>
                                            @error($field['slug']) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>

                                    <div class="mt-4 d-flex justify-content-end gap-2">
                                        @if($isEditMode || !$bankAccount)
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Save
                                        </button>
                                        @if($bankAccount)
                                        <button type="button" wire:click="toggleEditMode" class="btn btn-secondary">
                                            <i class="ri-close-line me-1"></i>Cancel
                                        </button>
                                        @endif
                                        @else
                                        <button type="button" wire:click="toggleEditMode" class="btn btn-primary">
                                            <i class="ri-edit-line me-1"></i>Edit
                                        </button>
                                        @endif
                                    </div>
                                </form>
                                @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="ri-bank-line display-4 text-muted"></i>
                                    </div>
                                    <h4 class="mb-3">Bank Account Management</h4>
                                    @if($bankAccount)
                                    <p class="text-muted mb-4">
                                        Your bank account is securely connected via our payment provider.
                                    </p>
                                    <button class="btn btn-primary">
                                        <i class="ri-refresh-line me-1"></i>Reconnect Account
                                    </button>
                                    @else
                                    <p class="text-muted mb-4">
                                        To manage your bank account details, please connect to our payment provider.
                                    </p>
                                    <button class="btn btn-primary">
                                        <i class="ri-link me-1"></i>Connect Bank Account
                                    </button>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>