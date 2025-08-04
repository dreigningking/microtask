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
                @if($field === 'bank_name')
                    <div class="col-md-6">
                        <label for="bank_code" class="form-label">Bank Name</label>
                        <select id="bank_code" wire:model.defer="bank_code"
                                class="form-select"
                                {{ !$isEditMode && $bankAccount ? 'disabled' : '' }}>
                            <option value="">Select a bank</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank['code'] }}">{{ ucwords($bank['name']) }}</option>
                            @endforeach
                        </select>
                        @error('bank_code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                @else
                    <div class="col-md-6">
                        <label for="{{ $field }}" class="form-label">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" id="{{ $field }}" wire:model.defer="{{ $field }}" 
                               class="form-control"
                               {{ !$isEditMode && $bankAccount ? 'disabled' : '' }}>
                        @error($field) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
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