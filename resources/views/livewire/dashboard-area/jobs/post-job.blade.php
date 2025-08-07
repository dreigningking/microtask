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
    <!-- Progress Steps -->
    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold mb-1"
                    style="width:40px;height:40px;{{ $currentStep == 1 ? 'background:#0d6efd;color:#fff;' : 'background:#e9ecef;color:#6c757d;' }}">
                    1
                </div>
                <span class="small fw-medium {{ $currentStep == 1 ? 'text-primary' : 'text-muted' }}">Template</span>
            </div>
            <div class="flex-fill mx-2">
                <div class="progress" style="height:4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $currentStep > 1 ? '100%' : '0%' }};"></div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold mb-1"
                    style="width:40px;height:40px;{{ $currentStep == 2 ? 'background:#0d6efd;color:#fff;' : 'background:#e9ecef;color:#6c757d;' }}">
                    2
                </div>
                <span class="small fw-medium {{ $currentStep == 2 ? 'text-primary' : 'text-muted' }}">Details</span>
            </div>
            <div class="flex-fill mx-2">
                <div class="progress" style="height:4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $currentStep > 2 ? '100%' : '0%' }};"></div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold mb-1"
                    style="width:40px;height:40px;{{ $currentStep == 3 ? 'background:#0d6efd;color:#fff;' : 'background:#e9ecef;color:#6c757d;' }}">
                    3
                </div>
                <span class="small fw-medium {{ $currentStep == 3 ? 'text-primary' : 'text-muted' }}">Budget</span>
            </div>
            <div class="flex-fill mx-2">
                <div class="progress" style="height:4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $currentStep > 3 ? '100%' : '0%' }};"></div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold mb-1"
                    style="width:40px;height:40px;{{ $currentStep == 4 ? 'background:#0d6efd;color:#fff;' : 'background:#e9ecef;color:#6c757d;' }}">
                    4
                </div>
                <span class="small fw-medium {{ $currentStep == 4 ? 'text-primary' : 'text-muted' }}">Review</span>
            </div>
        </div>
    </div>

    {{-- Step 1: Template Selection --}}
    @if($currentStep == 1)
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-2">Select a Task Template</h1>
        <p class="text-muted mb-3">Choose a template that best matches your job. You can filter by platform.</p>
    </div>
    
    <!-- Platform Filter -->
    <div class="sticky-top bg-white py-3 mb-4 shadow-sm" style="z-index:20;top:80px;">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <label class="fw-medium me-3 mb-0">Platform:</label>
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="platform_filter" id="platform_all" wire:model="platform_id" value="" autocomplete="off" {{ !$platform_id ? 'checked' : '' }}>
                <label class="btn btn-outline-primary btn-sm" for="platform_all">All</label>
                
        @foreach($platforms as $platform)
                <input type="radio" class="btn-check" name="platform_filter" id="platform_{{ $platform->id }}" wire:model="platform_id" value="{{ $platform->id }}" autocomplete="off" {{ $platform_id == $platform->id ? 'checked' : '' }}>
                <label class="btn btn-outline-primary btn-sm" for="platform_{{ $platform->id }}">{{ $platform->name }}</label>
        @endforeach
    </div>
        </div>
    </div>
    
    <!-- Template Cards -->
    <div class="row g-3">
        @forelse($templates->when($platform_id, fn($q) => $q->where('platform_id', $platform_id)) as $template)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 template-card {{ $template_id == $template->id ? 'border-primary shadow' : 'border-light' }}" 
                 wire:click="selectTemplate({{ $template->id }})" 
                 style="cursor: pointer; transition: all 0.2s ease;">
                <div class="card-body d-flex flex-column">
                    <!-- Template Header -->
                    <div class="d-flex align-items-center mb-3">
                    @if($template->image_url)
                    <img src="{{ $template->image_url }}" alt="{{ $template->name }}" class="rounded me-3" style="width:48px;height:48px;object-fit:cover;">
                    @else
                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                        <i class="ri-file-list-2-line text-secondary fs-3"></i>
                    </div>
                    @endif
                        <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">{{ $template->name }}</h6>
                            <span class="badge bg-secondary">{{ $template->platform->name ?? '' }}</span>
                    </div>
                        @if($template_id == $template->id)
                        <div class="ms-2">
                            <i class="ri-check-circle-fill text-primary fs-4"></i>
                </div>
                        @endif
                    </div>
                    
                    <!-- Template Description -->
                    <div class="text-muted small mb-3" style="min-height:48px;">{{ Str::limit($template->description, 100) }}</div>
                    
                    <!-- Template Stats -->
                    @php $fieldCount = is_array($template->task_fields) ? count($template->task_fields) : 0; @endphp
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="small text-muted">
                            <i class="ri-list-check me-1"></i>{{ $fieldCount }} fields
                        </span>
                        @if($template_id == $template->id)
                        <span class="badge bg-primary">Selected</span>
                        @else
                        <span class="text-muted small">Click to select</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center text-muted py-5">
                <i class="ri-file-list-2-line display-4 mb-3"></i>
                <h5 class="mb-2">No templates found</h5>
                <p class="mb-0">No templates are available for the selected platform.</p>
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Step 1 Actions -->
    <div class="d-flex flex-column align-items-end mt-4">
        @if($errors->has('platform_id'))
        <span class="text-danger small mb-1">{{ $errors->first('platform_id') }}</span>
        @endif
        @if($errors->has('template_id'))
        <span class="text-danger small mb-1">{{ $errors->first('template_id') }}</span>
        @endif
        <button type="button" wire:click="nextStep" class="btn btn-primary px-4" @if(!$template_id) disabled @endif>
            <span>Next Step <i class="ri-arrow-right-line ms-1"></i></span>
        </button>
    </div>
    @endif

    {{-- Step 2: Job Details --}}
    @if($currentStep == 2)
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-2">Job Details</h1>
        <p class="text-muted mb-3">Fill in the details for your job. Required fields are marked with <span class="text-danger">*</span>.</p>
    </div>
    <form wire:submit.prevent="nextStep" id="post-job-step2-form">
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
                <input type="text" id="title" wire:model="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" placeholder="e.g. Create content for social media" required>
                        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                        <label for="expected_completion_minutes" class="form-label fw-medium mb-1">Expected Completion Time <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" id="expected_completion_minutes" wire:model="expected_completion_minutes" min="1" class="form-control {{ $errors->has('expected_completion_minutes') ? 'is-invalid' : '' }}" placeholder="e.g. 3" required>
                            <select id="time_unit" wire:model="time_unit" class="form-select {{ $errors->has('time_unit') ? 'is-invalid' : '' }}" style="max-width: 120px;">
                            <option value="minutes" selected>Minutes</option>
                            <option value="hours">Hours</option>
                            <option value="days">Days</option>
                            <option value="weeks">Weeks</option>
                        </select>
                            </div>
                        @error('expected_completion_minutes') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                <label for="description-editor" class="form-label fw-medium mb-1">Write step by step instructions on what to do<span class="text-danger">*</span></label>
            <div class="linenumbered-textarea">
                <div class="line-numbers"></div>
                    <textarea id="description-editor" rows="4" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required>{{ $description }}</textarea>
                <input type="hidden" wire:model="description" id="description-hidden">
            </div>
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
            @livewire('dashboard-area.jobs.template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
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
                <select id="requirements" class="form-control select2 {{ $errors->has('requirements') ? 'is-invalid' : '' }}" multiple>
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
                <select id="restricted_countries" class="form-control select2 {{ $errors->has('restricted_countries') ? 'is-invalid' : '' }}" multiple>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                    @error('restricted_countries') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        </div>
        
        <!-- Step Actions -->
        <div class="d-flex justify-content-between mt-4 border-top border-light pt-3">
            <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">
                <i class="ri-arrow-left-line me-1"></i>
                <span>Back</span>
            </button>
            <div class="d-flex gap-2">
                @if($template_id && $isLoggedIn)
                <button type="button" wire:click="saveAsDraft" class="btn btn-outline-primary px-4">Save Draft</button>
                @endif
                <button type="submit" class="btn btn-primary px-4">
                    <span>Next Step</span>
                    <i class="ri-arrow-right-line ms-1"></i>
                </button>
            </div>
        </div>
    </form>
    @endif

    {{-- Step 3: Budget, Expiry, Monitoring, Promotion --}}
    @if($currentStep == 3)
    <form wire:submit.prevent="nextStep" id="post-job-step3-form">
        <!-- Monitoring Preferences -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="ri-shield-check-line me-2 text-primary"></i>
                    Monitoring Preferences
                </h5>
            </div>
            <div class="card-body">
                <label class="form-label fw-medium mb-3">Monitoring Type <span class="text-danger">*</span></label>
                    <div class="row g-3">
                        <div class="col-md-4">
                        <div class="monitoring-option">
                            <input type="radio" id="selfMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="self_monitoring" class="btn-check" {{ $monitoring_type === 'self_monitoring' ? 'checked' : '' }}>
                            <label for="selfMonitored" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center p-3 {{ $monitoring_type === 'self_monitoring' ? 'active' : '' }}">
                                <div class="w-10 h-10 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-2">
                                    <i class="ri-user-settings-line text-primary fs-4"></i>
                                </div>
                                <span class="fw-semibold mb-1">Self-Monitored</span>
                                <span class="small text-muted text-center">You'll review and approve all work</span>
                                <span class="badge bg-warning mt-2">{{ $currency_symbol }}{{ number_format($countrySetting->admin_monitoring_cost ?? 0, 2) }}</span>
                                <small class="text-success mt-1">
                                    <i class="ri-refund-line me-1"></i>Refunded if no admin intervention needed
                                </small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="monitoring-option">
                            <input type="radio" id="adminMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="admin_monitoring" class="btn-check" {{ $monitoring_type === 'admin_monitoring' ? 'checked' : '' }}>
                            <label for="adminMonitored" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center p-3 {{ $monitoring_type === 'admin_monitoring' ? 'active' : '' }}">
                                <div class="w-10 h-10 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-2">
                                    <i class="ri-admin-line text-primary fs-4"></i>
                                </div>
                                <span class="fw-semibold mb-1">Admin-Monitored</span>
                                <span class="small text-muted text-center">Our team will review work quality</span>
                                <span class="badge bg-warning mt-2">{{ $currency_symbol }}{{ number_format($countrySetting->admin_monitoring_cost ?? 0, 2) }}</span>
                            </label>
                        </div>
                    </div>
                    @if($enable_system_monitoring)
                    <div class="col-md-4">
                        <div class="monitoring-option">
                            <input type="radio" id="systemMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="system_monitoring" class="btn-check" {{ $monitoring_type === 'system_monitoring' ? 'checked' : '' }}>
                            <label for="systemMonitored" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center p-3 {{ $monitoring_type === 'system_monitoring' ? 'active' : '' }}">
                                <div class="w-10 h-10 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-2">
                                    <i class="ri-robot-2-line text-primary fs-4"></i>
                                </div>
                                <span class="fw-semibold mb-1">System-Automated</span>
                                <span class="small text-muted text-center">Automated checks for task completion</span>
                                <span class="badge bg-info mt-2">{{ $currency_symbol }}{{ number_format($countrySetting->system_monitoring_cost ?? 0, 2) }}</span>
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
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
                            <label for="budget_per_person" class="form-label fw-medium mb-1">Budget Per Person <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $currency_symbol }}</span>
                                <input type="number" id="budget_per_person" wire:model="budget_per_person" wire:input="updateTotals" min="{{ $min_budget_per_person }}" step="0.01" class="form-control {{ $errors->has('budget_per_person') ? 'is-invalid' : '' }}" placeholder="0.00" required>
                            </div>
                            @error('budget_per_person') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Number of People -->
                        <div class="mb-3">
                            <label for="number_of_people" class="form-label fw-medium mb-1">Number of People <span class="text-danger">*</span></label>
                            <div class="input-group" style="max-width: 250px;">
                                <button type="button" wire:click="decreasePeople" class="btn btn-outline-secondary">
                                    <i class="fa fa-minus"></i>
                            </button>
                                <input type="number" id="number_of_people" wire:model="number_of_people" wire:input="updateTotals" min="1" class="form-control text-center" style="width: 80px;">
                                <button type="button" wire:click="increasePeople" class="btn btn-outline-secondary">
                                    <i class="fa fa-plus"></i>
                            </button>
                        </div>
                            @error('number_of_people') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                        
                    <!-- Expiry Date -->
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label fw-medium mb-1">Job Expiry Date</label>
                        <input type="date" id="expiry_date" wire:model="expiry_date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}">
                            @error('expiry_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                        <input id="featured" type="checkbox" wire:model="featured" wire:change="updateTotals" class="form-check-input ms-0">
                                        <label for="featured" class="form-check-label fw-medium">Featured Job</label>
                            </div>
                                    <div class="flex-grow-1">
                                        <p class="small text-muted mb-2">Display prominently in search results</p>
                        @if($featured)
                                        <div class="d-flex align-items-center">
                                            <input type="number" wire:model="featured_days" wire:input="updateTotals" min="1" class="form-control form-control-sm" style="width: 80px;" placeholder="Days">
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
                        
                        <!-- Urgent Badge Option -->
                        <div class="card border-light">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3">
                                        <input id="urgent" type="checkbox" wire:model="urgent" wire:change="updateTotals" class="form-check-input">
                                        <label for="urgent" class="form-check-label fw-medium">Urgent Badge</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small text-muted mb-2">Add badge to attract immediate attention</p>
                                        <small class="text-muted">
                            @if($urgentPrice == 0)
                                            <i class="ri-check-line text-success me-1"></i>Included in your subscription
                            @else
                                            <i class="ri-money-dollar-circle-line me-1"></i>{{ $currency_symbol }}{{ number_format($urgentPrice, 2) }} per person
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
                            <p class="small text-muted mb-0">For {{ $number_of_people }} person{{ $number_of_people > 1 ? 's' : '' }}</p>
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
                            @if($urgent)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Urgent Promotion:</span>
                                <span class="small fw-medium">
                                    @if($urgentPrice == 0)
                                    <span class="text-success">Included</span>
                                    @else
                                    {{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }}
                                    @endif
                                </span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Platform Service Charge:</span>
                                <span class="small fw-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                            </div>
                            @if($monitoring_fee > 0)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Monitoring Fee:</span>
                                <span class="small fw-medium">
                                    {{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}
                                    @if($monitoring_type === 'admin_monitoring' || $monitoring_type === 'system_monitoring')
                                    <span class="small text-muted">({{ $currency_symbol }}{{ number_format($monitoring_fee / $number_of_people, 2) }} x {{ $number_of_people }} people)</span>
                                    @endif
                                </span>
                            </div>
                            @if($showSelfMonitoringRefundNote)
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
        
        <!-- Step Actions -->
            <div class="d-flex justify-content-between mt-4 border-top border-light pt-3">
                <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">
                <i class="ri-arrow-left-line me-1"></i>
                <span>Back</span>
                </button>
                <div class="d-flex gap-2">
                    @if($template_id && $isLoggedIn)
                    <button type="button" wire:click="saveAsDraft" class="btn btn-outline-primary px-4">Save Draft</button>
                    @endif
                    <button type="submit" class="btn btn-primary px-4">
                    <span>Next Step</span>
                    <i class="ri-arrow-right-line ms-1"></i>
                    </button>
            </div>
        </div>
    </form>
    @endif

    {{-- Step 4: Login or Review & Confirmation --}}
    @if($currentStep == 4)
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Payment Summary Card -->
            <div class="card mb-6">
                <div class="card-header bg-primary bg-opacity-10 border-primary">
                    <h4 class="mb-0 fw-bold text-primary">
                        <i class="ri-bill-line me-2"></i>
                        Payment Summary
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Summary Overview -->
                        <div class="col-md-6">
                            <div class="text-center p-4 bg-light rounded">
                                <h5 class="text-muted mb-2">Total Amount</h5>
                                <div class="fw-bold text-primary display-6">
                                    {{ $currency_symbol }} {{ number_format($total, 2) }}
                                </div>
                                <p class="small text-muted mb-0">For {{ $number_of_people }} person{{ $number_of_people > 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                        
                        <!-- Detailed Breakdown -->
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-3">Cost Breakdown</h6>
                        <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Job Budget:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                            </div>
                            @if($featured)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Featured Job ({{ $featured_days }} day{{ $featured_days > 1 ? 's' : '' }}):</span>
                                    <span class="fw-medium">
                                        @if($featuredPrice == 0) 
                                        <span class="text-success">Included</span>
                                        @else 
                                        {{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }}
                                        @endif
                                    </span>
                            </div>
                            @endif
                            @if($urgent)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Urgent Badge ({{ $number_of_people }} people):</span>
                                    <span class="fw-medium">
                                        @if($urgentPrice == 0) 
                                        <span class="text-success">Included</span>
                                        @else 
                                        {{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }}
                                        @endif
                                    </span>
                            </div>
                            @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Platform Service Charge:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                            </div>
                            @if($monitoring_fee > 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Monitoring Fee:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}</span>
                            </div>
                            @if($showSelfMonitoringRefundNote)
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
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
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

            <!-- Payment Information -->
            <div class="card mb-4 border-success">
                <div class="card-header bg-success bg-opacity-10 border-success">
                    <h5 class="mb-0 fw-semibold text-success">
                        <i class="ri-shield-check-line me-2"></i>
                        Secure Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-shield-check-line text-success fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold mb-2">Secure Payment Process</h6>
                            <ul class="text-muted list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="ri-check-line text-success me-2"></i>
                                    After submitting your job, you'll be redirected to our secure payment gateway.
                                </li>
                                <li class="mb-2">
                                    <i class="ri-check-line text-success me-2"></i>
                                    Your job will be published immediately after successful payment.
                                </li>
                                <li class="mb-0">
                                    <i class="ri-check-line text-success me-2"></i>
                                    We accept credit/debit cards, PayPal, and other payment methods.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

                @if(!$isLoggedIn)
            <!-- Login Form -->
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning bg-opacity-10 border-warning">
                    <h5 class="mb-0 fw-semibold text-warning">
                        <i class="ri-user-line me-2"></i>
                        Login Required
                    </h5>
                        </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Please login to continue with your job posting.</p>
                    <form wire:submit.prevent="nextStep" class="row g-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-medium mb-1">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-mail-line"></i>
                                </span>
                                <input type="email" id="email" wire:model="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Enter your email" required>
                        </div>
                            @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-medium mb-1">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-lock-line"></i>
                                </span>
                                <input type="password" id="password" wire:model="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Enter your password" required>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input type="checkbox" id="remember" wire:model="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label small text-muted">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="small text-primary text-decoration-underline">Forgot password?</a>
                        </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                                <i class="ri-login-box-line me-2"></i>
                                Login & Continue
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-4 pt-3 border-top">
                        <span class="small text-muted">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="small text-primary fw-semibold text-decoration-underline ms-1">Register here</a>
                    </div>
                    </div>
                </div>
                @else
            <!-- Terms & Conditions -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info bg-opacity-10 border-info">
                    <h5 class="mb-0 fw-semibold text-info">
                        <i class="ri-file-text-line me-2"></i>
                        Terms & Conditions
                    </h5>
                        </div>
                <div class="card-body">
                    <form wire:submit.prevent="nextStep">
                        <div class="form-check">
                            <input type="checkbox" id="terms" wire:model="terms" class="form-check-input {{ $errors->has('terms') ? 'is-invalid' : '' }}">
                            <label for="terms" class="form-check-label">
                                I agree to the <a href="{{ route('legal.terms-conditions') }}" target="_blank" class="text-primary text-decoration-underline">Terms and Conditions</a> and <a href="{{ route('legal.privacy-policy') }}" target="_blank" class="text-primary text-decoration-underline">Privacy Policy</a>
                            </label>
                            @error('terms') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 fw-semibold py-3">
                                <i class="ri-arrow-right-line me-2"></i>
                                Proceed to Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Step Actions -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">
                    <i class="ri-arrow-left-line me-1"></i>
                        <span>Back</span>
                </button>
            </div>
        </div>
        @endif

        @endif
    </div>

@push('styles')
<link href="{{asset('frontend/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{ asset('frontend/css/textarea-linenumbers.css') }}" rel="stylesheet" />
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
    
    /* Template Cards Styling */
    .template-card {
        transition: all 0.2s ease;
        border: 2px solid #e9ecef;
    }
    
    .template-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #0d6efd;
    }
    
    .template-card.border-primary {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.02);
    }
    
    .template-card.border-primary:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    /* Platform Filter Button Group */
    .btn-group .btn-check:checked + .btn {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .btn-group .btn-check:not(:checked) + .btn:hover {
        background-color: #e9ecef;
        border-color: #0d6efd;
        color: #0d6efd;
    }
    
    /* Monitoring Options Styling */
    .monitoring-option {
        position: relative;
    }
    
    .monitoring-option .btn {
        transition: all 0.2s ease;
        border: 1px solid #e9ecef;
        min-height: 140px;
        background-color: transparent;
    }
    
    .monitoring-option .btn:hover {
        border-color: #0d6efd !important;
        background-color: transparent !important;
        transform: none;
        box-shadow: none;
    }
    
    .monitoring-option .btn-check:checked + .btn {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.05) !important;
        color: #0d6efd !important;
    }
    
    .monitoring-option .btn-check:checked + .btn .bg-primary {
        background-color: #0d6efd !important;
    }
    
    .monitoring-option .btn-check:checked + .btn .text-primary {
        color: #0d6efd !important;
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
    
    /* Payment Summary Styling */
    .display-6 {
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .w-12 {
        width: 3rem;
    }
    
    .h-12 {
        height: 3rem;
    }
    
    /* Login Form Styling */
    .input-group-text i {
        color: #6c757d;
    }
    
    .card.border-warning .card-header {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    .card.border-info .card-header {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
    
    .card.border-success .card-header {
        background-color: rgba(25, 135, 84, 0.1) !important;
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
    /* background-color: rgba(13, 110, 253, 0.1);
    border-color: rgba(13, 110, 253, 0.2); */
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
    
    /* Line numbers styling improvements */
    .linenumbered-textarea {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        overflow: hidden;
    }
    
    .linenumbered-textarea .line-numbers {
        background-color: #f8f9fa;
        border-right: 1px solid #dee2e6;
        color: #6c757d;
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }
    
    .linenumbered-textarea textarea {
        border: none;
        background-color: #fff;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .linenumbered-textarea textarea:focus {
        box-shadow: none;
        border: none;
        outline: none;
        }
</style>
@endpush

@push('scripts')
    <script src="{{asset('frontend/js/select2.min.js')}}"></script>
    <script src="{{ asset('frontend/js/textarea-linenumbers.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    
        Livewire.on('step2-shown', function() {
            setTimeout(initializeSelect2, 100);
            setTimeout(initLineNumberedTextareas, 100);
        });

        function initializeSelect2() {
            if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                if (jQuery('#requirements').length) {
                    if (jQuery('#requirements').hasClass('select2-hidden-accessible')) {
                        jQuery('#requirements').select2('destroy');
                    }
                    jQuery('#requirements').select2({
                        placeholder: "Select tools required",
                        allowClear: true,
                        tags: true,
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
                if (jQuery('#restricted_countries').length) {
                    if (jQuery('#restricted_countries').hasClass('select2-hidden-accessible')) {
                        jQuery('#restricted_countries').select2('destroy');
                    }
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
    
    function initLineNumberedTextareas() {
        if (typeof window.initLineNumberedTextareas === 'function') {
            window.initLineNumberedTextareas();
        }
    }
})
    </script>
    @endpush