<div class="content-wrapper">
    @if($serviceUnavailable)
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="alert alert-danger text-center p-4">
                <div class="mb-2">
                    <i class="ri-error-warning-line display-4 text-danger"></i>
                </div>
                <h2 class="h5 fw-bold mb-2">Service Unavailable</h2>
                <p class="mb-1">Sorry, our job posting service is not available in {{ $unavailableCountryName ?? 'your country' }} at this time.</p>
                <p class="small text-danger">Please check back later or contact support for more information.</p>
            </div>
        </div>
    </div>
    @else
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-2">Edit Job</h1>
        <p class="text-muted mb-3">Update your job details and proceed to payment.</p>
    </div>

    @if(!$canEdit)
    <div class="alert alert-warning mb-4">
        <div class="d-flex align-items-center">
            <i class="ri-error-warning-line me-2"></i>
            <div>
                <strong class="fw-bold">This job cannot be edited.</strong>
                <span class="d-block">This job has already been paid for and cannot be modified.</span>
            </div>
        </div>
    </div>
    @endif

    <form wire:submit.prevent="submitJob" class="space-y-4">
        @if(session()->has('success'))
        <div class="alert alert-success">
            <i class="ri-check-line me-2"></i>
            {{ session('success') }}
        </div>
        @endif
        
        @if(session()->has('error'))
        <div class="alert alert-danger">
            <i class="ri-error-warning-line me-2"></i>
            {{ session('error') }}
        </div>
        @endif
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-information-line me-2 text-primary"></i>
                    Basic Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label fw-medium mb-1">Job Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" wire:model="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" placeholder="e.g. Create content for social media" required @if(!$canEdit) readonly disabled @endif>
                        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="platform_id" class="form-label fw-medium mb-1">Platform</label>
                        <input type="text" value="{{ $task->platform->name ?? 'N/A' }}" class="form-control bg-light" readonly>
                        <div class="form-text">Platform cannot be changed</div>
                    </div>
                    <div class="col-md-6">
                        <label for="template_id" class="form-label fw-medium mb-1">Task Template</label>
                        <input type="text" value="{{ $task->platformTemplate->name ?? 'N/A' }}" class="form-control bg-light" readonly>
                        <div class="form-text">Template cannot be changed</div>
                    </div>
                    <div class="col-md-6">
                        <label for="expected_completion_minutes" class="form-label fw-medium mb-1">Expected Completion Time <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" id="expected_completion_minutes" wire:model="expected_completion_minutes" min="1" class="form-control {{ $errors->has('expected_completion_minutes') ? 'is-invalid' : '' }}" placeholder="e.g. 3" required @if(!$canEdit) readonly disabled @endif>
                            <select id="time_unit" wire:model="time_unit" class="form-select {{ $errors->has('time_unit') ? 'is-invalid' : '' }}" style="max-width: 120px;" @if(!$canEdit) disabled @endif>
                                <option value="minutes" selected>Minutes</option>
                                <option value="hours">Hours</option>
                                <option value="days">Days</option>
                                <option value="weeks">Weeks</option>
                            </select>
                        </div>
                        @error('expected_completion_minutes') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="expiry_date" class="form-label fw-medium mb-1">Job Expiry Date</label>
                        <input type="date" id="expiry_date" wire:model="expiry_date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" min="{{ now()->addDay()->format('Y-m-d') }}" @if(!$canEdit) readonly disabled @endif>
                        @error('expiry_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <div class="form-text">Optional. The date this job will no longer be visible to workers.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Description -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-file-text-line me-2 text-primary"></i>
                    Job Description
                </h5>
            </div>
            <div class="card-body">
                <label for="description" class="form-label fw-medium mb-1">Write step by step instructions on what to do<span class="text-danger">*</span></label>
                <textarea id="description" wire:model="description" rows="4" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required @if(!$canEdit) readonly disabled @endif></textarea>
                @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        
        <!-- Template Fields -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-list-check me-2 text-primary"></i>
                    Template Fields
                </h5>
            </div>
            <div class="card-body">
                @livewire('tasks.task-template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
            </div>
        </div>

        <!-- Requirements -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-tools-line me-2 text-primary"></i>
                    Required Tools
                </h5>
            </div>
            <div class="card-body">
                <div wire:ignore>
                    <label for="requirements" class="form-label fw-medium mb-1">Required Tools <span class="text-danger">*</span></label>
                    <select id="requirements" class="form-control select2 {{ $errors->has('requirements') ? 'is-invalid' : '' }}" multiple @if(!$canEdit) disabled @endif>
                        @foreach($requirements as $tool)
                        <option value="{{ $tool }}" selected>{{ $tool }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Add tools or software required for this job</div>
                    @error('requirements') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        
        <!-- Restricted Countries -->
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning bg-opacity-10 border-warning">
                <h5 class="mb-0 fw-semibold text-warning">
                    <i class="ri-global-line me-2"></i>
                    Restricted Countries
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Optionally, you can restrict workers from specific countries from applying to this job.</p>
                <div wire:ignore>
                    <select id="restricted_countries" class="form-control select2 {{ $errors->has('restricted_countries') ? 'is-invalid' : '' }}" multiple @if(!$canEdit) disabled @endif>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ in_array($country->id, $restricted_countries) ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('restricted_countries') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Review Preferences -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-shield-check-line me-2 text-primary"></i>
                    Review Preferences
                </h5>
            </div>
            <div class="card-body">
                <label class="form-label fw-medium mb-3">Review Type <span class="text-danger">*</span></label>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" id="selfMonitored" wire:model="review_type" wire:change="updateTotals" value="self_review" class="form-check-input" {{ $review_type === 'self_review' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                            <label for="selfMonitored" class="form-check-label">
                                <div class="d-flex align-items-center">
                                    <i class="ri-user-settings-line me-2 text-primary"></i>
                                    <div>
                                        <div class="fw-medium">Self-Monitored</div>
                                        <small class="text-muted">You'll review and approve all work</small>
                                        <div class="badge bg-warning mt-1">{{ $currency_symbol }}{{ number_format($countrySetting->admin_review_cost ?? 0, 2) }}</div>
                                        <small class="text-success d-block">
                                            <i class="ri-refund-line me-1"></i>Refunded if no admin intervention needed
                                        </small>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" id="adminMonitored" wire:model="review_type" wire:change="updateTotals" value="admin_review" class="form-check-input" {{ $review_type === 'admin_review' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                            <label for="adminMonitored" class="form-check-label">
                                <div class="d-flex align-items-center">
                                    <i class="ri-admin-line me-2 text-primary"></i>
                                    <div>
                                        <div class="fw-medium">Admin-Monitored</div>
                                        <small class="text-muted">Our team will review work quality</small>
                                        <div class="badge bg-warning mt-1">{{ $currency_symbol }}{{ number_format($countrySetting->admin_review_cost ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    @if($enable_system_review)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" id="systemMonitored" wire:model="review_type" wire:change="updateTotals" value="system_review" class="form-check-input" {{ $review_type === 'system_review' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                            <label for="systemMonitored" class="form-check-label">
                                <div class="d-flex align-items-center">
                                    <i class="ri-robot-2-line me-2 text-primary"></i>
                                    <div>
                                        <div class="fw-medium">System-Automated</div>
                                        <small class="text-muted">Automated checks for task completion</small>
                                        <div class="badge bg-info mt-1">{{ $currency_symbol }}{{ number_format($countrySetting->system_review_cost ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
                @error('review_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Budget & Promotion Options -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-money-dollar-circle-line me-2 text-primary"></i>
                    Budget & Promotion Options
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Budget & Capacity Column -->
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">Budget & Capacity</h6>
                        
                        <!-- Budget Per Person -->
                        <div class="mb-3">
                            <label for="budget_per_submission" class="form-label fw-medium mb-1">Budget Per Submission <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $currency_symbol }}</span>
                                <input type="number" id="budget_per_submission" wire:model="budget_per_submission" wire:input="updateTotals" min="{{ $min_budget_per_submission }}" step="0.01" class="form-control {{ $errors->has('budget_per_submission') ? 'is-invalid' : '' }}" placeholder="0.00" required @if(!$canEdit) readonly disabled @endif>
                            </div>
                            @error('budget_per_submission') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Number of People -->
                        <div class="mb-3">
                            <label for="number_of_submissions" class="form-label fw-medium mb-1">Number of Submissions <span class="text-danger">*</span></label>
                            <div class="input-group" style="max-width: 200px;">
                                <button type="button" wire:click="decreaseSubmissions" class="btn btn-outline-secondary" @if(!$canEdit) disabled @endif>
                                    <i class="ri-subtract-line"></i>
                                </button>
                                <input type="number" id="number_of_submissions" wire:model="number_of_submissions" wire:input="updateTotals" min="1" class="form-control text-center" style="width: 80px;" @if(!$canEdit) readonly disabled @endif>
                                <button type="button" wire:click="increaseSubmissions" class="btn btn-outline-secondary" @if(!$canEdit) disabled @endif>
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <div class="form-text">Total number of submissions needed to complete this job</div>
                            @error('number_of_submissions') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Allow Multiple Submissions from Single User -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="allow_multiple_submissions" wire:model="allow_multiple_submissions" class="form-check-input" @if(!$canEdit) disabled @endif>
                                <label for="allow_multiple_submissions" class="form-check-label fw-medium">
                                    Allow multiple submissions from single user
                                </label>
                            </div>
                            <div class="form-text">If checked, a single worker can submit multiple times for this job</div>
                        </div>
                    </div>
                    
                    <!-- Promotion Options Column -->
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">Promotion Options</h6>
                        
                        <!-- Featured Job Option -->
                        <div class="card mb-3 border-light">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3">
                                        <input id="featured" type="checkbox" wire:model="featured" wire:change="updateTotals" class="form-check-input" @if(!$canEdit) disabled @endif>
                                        <label for="featured" class="form-check-label fw-medium">Featured Job</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small text-muted mb-2">Display prominently in search results</p>
                                        @if($featured)
                                        <div class="d-flex align-items-center">
                                            <input type="number" wire:model="featured_days" wire:input="updateTotals" min="1" class="form-control form-control-sm" style="width: 80px;" placeholder="Days" @if(!$canEdit) disabled @endif>
                                            <span class="small text-muted ms-2">days</span>
                                        </div>
                                        @endif
                                        <small class="text-muted">
                                            @if($featuredPrice == 0)
                                            <i class="ri-check-line text-success me-1"></i>Included in your subscription
                                            @else
                                            <i class="ri-money-dollar-circle-line me-1"></i>{{ $currency_symbol }}{{ number_format($featuredPrice, 2) }} per day
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Broadcast Badge Option -->
                        <div class="card border-light">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3">
                                        <input id="broadcast" type="checkbox" wire:model="broadcast" wire:change="updateTotals" class="form-check-input" @if(!$canEdit) disabled @endif>
                                        <label for="broadcast" class="form-check-label fw-medium">Broadcast Badge</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small text-muted mb-2">Add badge to attract immediate attention</p>
                                        <small class="text-muted">
                                            @if($broadcastPrice == 0)
                                            <i class="ri-check-line text-success me-1"></i>Included in your subscription
                                            @else
                                            <i class="ri-money-dollar-circle-line me-1"></i>{{ $currency_symbol }}{{ number_format($broadcastPrice, 2) }} per submission
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Summary -->
        <div class="card mb-4 border-primary">
            <div class="card-header bg-primary bg-opacity-10 border-primary">
                <h5 class="mb-0 fw-semibold text-primary">
                    <i class="ri-calculator-line me-2"></i>
                    Pricing Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Total Budget Summary -->
                    <div class="col-md-6">
                        <div class="text-center p-3 bg-light rounded">
                            <h6 class="text-muted mb-1">Total Budget</h6>
                            <div class="fw-bold text-primary fs-3">
                                {{ $currency_symbol }} {{ number_format($total, 2) }}
                            </div>
                            <p class="small text-muted mb-0">For {{ $number_of_submissions }} submission{{ $number_of_submissions > 1 ? 's' : '' }}</p>
                        </div>
                    </div>
                    
                    <!-- Pricing Breakdown -->
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Cost Breakdown</h6>
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Job Budget:</span>
                                <span class="small fw-medium">{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                            </div>
                            @if($featured)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Featured Promotion:</span>
                                <span class="small fw-medium">
                                    @if($featuredPrice == 0) 
                                    <span class="text-success">Included</span>
                                    @else 
                                    {{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }}
                                    @endif
                                </span>
                            </div>
                            @endif
                            @if($broadcast)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Broadcast Promotion:</span>
                                <span class="small fw-medium">
                                    @if($broadcastPrice == 0) 
                                    <span class="text-success">Included</span>
                                    @else 
                                    {{ $currency_symbol }} {{ number_format($broadcastPrice * $number_of_submissions, 2) }}
                                    @endif
                                </span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Platform Service Charge:</span>
                                <span class="small fw-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                            </div>
                            @if($review_fee > 0)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Review Fee:</span>
                                <span class="small fw-medium">{{ $currency_symbol }} {{ number_format($review_fee, 2) }}</span>
                            </div>
                            @if($showSystemReviewRefundNote)
                            <div class="small text-primary mt-1 ms-2">
                                <i class="ri-information-line me-1"></i>This fee will be refunded if no admin intervention is required
                            </div>
                            @endif
                            @endif
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Subtotal:</span>
                                <span class="fw-bold text-primary">{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Tax ({{ $tax_rate }}%):</span>
                                <span class="small fw-medium">{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total:</span>
                                <span class="fw-bold text-primary fs-5">{{ $currency_symbol }} {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="card mb-4 border-info">
            <div class="card-header bg-info bg-opacity-10 border-info">
                <h5 class="mb-0 fw-semibold text-info">
                    <i class="ri-file-text-line me-2"></i>
                    Terms & Conditions
                </h5>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input type="checkbox" id="terms" wire:model="terms" class="form-check-input {{ $errors->has('terms') ? 'is-invalid' : '' }}" @if(!$canEdit) disabled @endif>
                    <label for="terms" class="form-check-label">
                        I agree to the <a href="{{ route('legal.terms-conditions') }}" target="_blank" class="text-primary text-decoration-underline">Terms and Conditions</a> and <a href="{{ route('legal.privacy-policy') }}" target="_blank" class="text-primary text-decoration-underline">Privacy Policy</a>
                    </label>
                    @error('terms') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-end">
            @if($canEdit)
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="ri-secure-payment-line me-2"></i>
                Update Job
            </button>
            @else
            <div class="alert alert-info mb-0">
                <i class="ri-information-line me-2"></i>
                This job has been paid for and cannot be modified.
            </div>
            @endif
        </div>
    </form>
    @endif
</div>

@push('styles')
<link href="{{asset('frontend/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .cursor-pointer {
        cursor: pointer;
    }
    
    .w-5 {
        width: 1.25rem;
    }
    
    .h-5 {
        height: 1.25rem;
    }
    
    .w-10 {
        width: 2.5rem;
    }
    
    .h-10 {
        height: 2.5rem;
    }
    
    .w-20 {
        width: 5rem;
    }
    
    .min-w-100 {
        min-width: 100px;
    }
    
    .bg-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    .text-opacity-10 {
        color: rgba(13, 110, 253, 0.1) !important;
    }
    
    .border-opacity-10 {
        border-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    /* Promotion Options Styling */
    .card.border-light {
        transition: all 0.2s ease;
    }
    
    .card.border-light:hover {
        border-color: #0d6efd !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    /* Select2 Custom Styling */
    .select2-container .select2-selection--single {
        height: 40px !important;
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        line-height: 40px !important;
    }

    .select2-container--default .select2-selection--multiple {
        border-color: #e5e7eb;
        border-radius: 0.375rem;
        min-height: 42px;
        padding: 2px 8px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        font-size: 14px;
        border-radius: 9999px;
        padding: 2px 8px;
        margin-top: 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #0d6efd;
        margin-right: 5px;
        border: none !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        initializeSelect2();
    });
    
    function initializeSelect2() {
        if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
            // Safely destroy existing Select2 instances first
            try {
                if (jQuery('#requirements').hasClass('select2-hidden-accessible')) {
                    jQuery('#requirements').select2('destroy');
                }
                if (jQuery('#restricted_countries').hasClass('select2-hidden-accessible')) {
                    jQuery('#restricted_countries').select2('destroy');
                }
            } catch (e) {
                console.log('Select2 destroy error:', e);
            }
            
            // Initialize requirements select2
            if (jQuery('#requirements').length) {
                jQuery('#requirements').select2({
                    placeholder: "Select required tools",
                    allowClear: true,
                    width: '100%'
                }).on('change', function(e) {
                    // Get selected data
                    let data = jQuery(this).val();
                    window.Livewire.dispatch('updateSelect2', {
                        data: data,
                        element: 'requirements'
                    });
                });
            }

            // Initialize restricted countries select2
            if (jQuery('#restricted_countries').length) {
                jQuery('#restricted_countries').select2({
                    placeholder: "Select countries to restrict",
                    allowClear: true,
                    width: '100%'
                }).on('change', function(e) {
                    // Get selected data
                    let data = jQuery(this).val();
                    window.Livewire.dispatch('updateSelect2', {
                        data: data,
                        element: 'restricted_countries'
                    });
                });
            }
        }
    }
    
    // Listen for Livewire load event to reinitialize Select2 after component updates
    document.addEventListener('livewire:initialized', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });
    
    // Listen for Livewire updates to reinitialize Select2
    document.addEventListener('livewire:updated', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });
    
    // Listen for Livewire navigation to reinitialize Select2
    document.addEventListener('livewire:navigated', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });
</script>
@endpush