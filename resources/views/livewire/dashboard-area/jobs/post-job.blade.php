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
    <div class="sticky-top bg-white py-2 mb-4 shadow-sm d-flex flex-wrap gap-2 align-items-center" style="z-index:20;top:80px;">
        <label class="fw-medium mx-2">Platform:</label>
        <button wire:click="$set('platform_id', null)" class="btn btn-sm {{ !$platform_id ? 'btn-primary' : 'btn-outline-secondary' }}">All</button>
                                    @foreach($platforms as $platform)
        <button wire:click="$set('platform_id', {{ $platform->id }})" class="btn btn-sm {{ $platform_id == $platform->id ? 'btn-primary' : 'btn-outline-secondary' }}">{{ $platform->name }}</button>
                                    @endforeach
    </div>
    <div class="row g-3">
        @forelse($templates->when($platform_id, fn($q) => $q->where('platform_id', $platform_id)) as $template)
        <div class="col-md-6 col-lg-4">
            <div wire:key="template-{{ $template->id }}" wire:click="selectTemplate({{ $template->id }})" class="card h-100 cursor-pointer {{ $template_id == $template->id ? 'border-primary shadow' : 'border-light' }}">
                <div class="card-body d-flex align-items-center">
                    @if($template->image_url)
                    <img src="{{ $template->image_url }}" alt="{{ $template->name }}" class="rounded me-3" style="width:48px;height:48px;object-fit:cover;">
                    @else
                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                        <i class="ri-file-list-2-line text-secondary fs-3"></i>
                    </div>
                    @endif
                    <div>
                        <h6 class="fw-semibold mb-1">{{ $template->name }}</h6>
                        <span class="small text-muted">{{ $template->platform->name ?? '' }}</span>
                    </div>
                </div>
                <div class="card-body pt-0 pb-2">
                    <div class="text-muted small mb-2" style="min-height:48px;">{{ Str::limit($template->description, 100) }}</div>
                    @php $fieldCount = is_array($template->task_fields) ? count($template->task_fields) : 0; @endphp
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Fields: {{ $fieldCount }}</span>
                        @if($template_id == $template->id)
                        <span class="badge bg-primary">Selected</span>
                        @endif
                    </div>
                </div>
                            </div>
                        </div>
        @empty
        <div class="col-12 text-center text-muted py-4">
            <i class="ri-file-list-2-line display-4 mb-2"></i>
            <p>No templates found for this platform.</p>
        </div>
        @endforelse
    </div>
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
        <h1 class="h3 fw-bold text-gray-900 mb-2">Job Details</h1>
        <p class="text-muted mb-3">Fill in the details for your job. Required fields are marked with <span class="text-danger">*</span>.</p>
                            </div>
    <form wire:submit.prevent="nextStep" id="post-job-step2-form">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-medium text-gray-700 mb-1">Job Title <span class="text-danger">*</span></label>
                <input type="text" id="title" wire:model="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" placeholder="e.g. Create content for social media" required>
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="expected_completion_minutes" class="form-label fw-medium text-gray-700 mb-1">Expected Completion Time <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <input type="number" id="expected_completion_minutes" wire:model="expected_completion_minutes" min="1" class="form-control w-1/3 {{ $errors->has('expected_completion_minutes') ? 'is-invalid' : '' }}" placeholder="e.g. 3" required>
                                <div class="position-relative w-100">
                                    <select id="time_unit" wire:model="time_unit" class="form-select {{ $errors->has('time_unit') ? 'is-invalid' : '' }}">
                                        <option value="minutes" selected>Minutes</option>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                        <option value="weeks">Weeks</option>
                                    </select>
                                    <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                        <div class="w-5 h-5 d-flex align-items-center justify-content-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('expected_completion_minutes') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

        <div class="mt-4">
            <label for="description-editor" class="form-label fw-medium text-gray-700 mb-1">Write step by step instructions on what to do<span class="text-danger">*</span></label>
            <div class=" linenumbered-textarea">
                <div class="line-numbers"></div>
                <textarea id="description-editor" rows="2" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required>{{ $description }}</textarea>
                <input type="hidden" wire:model="description" id="description-hidden">
                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
        <div class="mt-4">
            @livewire('jobs.template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
                                    </div>
        <div wire:ignore class="mt-4">
            <label for="requirements" class="form-label fw-medium text-gray-700 mb-1">Required Tools <span class="text-danger">*</span></label>
                <div>
                <select id="requirements" class="form-control select2 {{ $errors->has('requirements') ? 'is-invalid' : '' }}" multiple>
                    @foreach($requirements as $tool)
                    <option value="{{ $tool }}" selected>{{ $tool }}</option>
                                        @endforeach
                </select>
                                    </div>
            <p class="small text-muted mt-1">Add tools or software required for this job (required)</p>
                                @error('requirements') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
        <div wire:ignore class="mt-4 bg-light p-3 rounded-3 border border-danger">
            <h3 class="small fw-medium text-danger mb-2">Restricted Countries</h3>
            <p class="small text-muted mb-3">Optionally, you can restrict workers from specific countries from applying to this job.</p>
                        <div>
                <select id="restricted_countries" class="form-control select2 {{ $errors->has('restricted_countries') ? 'is-invalid' : '' }}" multiple>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        <div class="d-flex justify-content-between mt-4 border-top border-light pt-3">
            <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">
                <span>Back <i class="ri-arrow-left-line ms-1"></i></span>
            </button>
            <div class="d-flex gap-2">
                @if($template_id && $isLoggedIn)
                <button type="button" wire:click="saveAsDraft" class="btn btn-outline-primary px-4">Save Draft</button>
                @endif
                <button type="submit" class="btn btn-primary px-4">
                    <span>Next Step <i class="ri-arrow-right-line ms-1"></i></span>
                </button>
            </div>
        </div>
    </form>
    @endif

    {{-- Step 3: Budget, Expiry, Monitoring, Promotion --}}
    @if($currentStep == 3)
    <form wire:submit.prevent="nextStep" id="post-job-step3-form">
                <div>
                    <h2 class="h4 fw-semibold text-gray-800 mb-3">Monitoring Preferences</h2>
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label class="form-label fw-medium text-gray-700 mb-2">Monitoring Type <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-4">
                            <input type="radio" id="selfMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="self_monitoring" class="form-check-input peer" {{ $monitoring_type === 'self_monitoring' ? 'checked' : '' }}>
                                    <label for="selfMonitored" class="form-check-label d-flex flex-column align-items-center p-3 border border-light rounded-3 cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-circle d-flex align-items-center justify-content-center mb-2">
                                            <div class="w-5 h-5 d-flex align-items-center justify-content-center text-primary">
                                                <i class="ri-user-settings-line"></i>
                                            </div>
                                        </div>
                                <span class="fw-medium text-gray-800">Self-Monitored (Free)</span>
                                        <span class="small text-muted text-center mt-1">You'll review and approve all work</span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                            <input type="radio" id="adminMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="admin_monitoring" class="form-check-input peer" {{ $monitoring_type === 'admin_monitoring' ? 'checked' : '' }}>
                                    <label for="adminMonitored" class="form-check-label d-flex flex-column align-items-center p-3 border border-light rounded-3 cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-circle d-flex align-items-center justify-content-center mb-2">
                                            <div class="w-5 h-5 d-flex align-items-center justify-content-center text-primary">
                                                <i class="ri-admin-line"></i>
                                            </div>
                                        </div>
                                <span class="fw-medium text-gray-800">Admin-Monitored ({{ $currency_symbol }}{{ number_format($countrySetting->admin_monitoring_cost ?? 0, 2) }})</span>
                                        <span class="small text-muted text-center mt-1">Our team will review work quality</span>
                                    </label>
                                </div>
                        @if($enable_system_monitoring)
                                <div class="col-md-4">
                            <input type="radio" id="systemMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="system_monitoring" class="form-check-input peer" {{ $monitoring_type === 'system_monitoring' ? 'checked' : '' }}>
                                    <label for="systemMonitored" class="form-check-label d-flex flex-column align-items-center p-3 border border-light rounded-3 cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-circle d-flex align-items-center justify-content-center mb-2">
                                            <div class="w-5 h-5 d-flex align-items-center justify-content-center text-primary">
                                        <i class="ri-robot-2-line"></i>
                                        </div>
                                </div>
                                <span class="fw-medium text-gray-800">System-Automated ({{ $currency_symbol }}{{ number_format($countrySetting->system_monitoring_cost ?? 0, 2) }})</span>
                                <span class="small text-muted text-center mt-1">Automated checks for task completion</span>
                            </label>
                        </div>
                        @endif
                                </div>
                        </div>
                    </div>
                </div>

        <div class="mt-4">
                    <h2 class="h4 fw-semibold text-gray-800 mb-2">Budget & Promotion Options</h2>
                    <div class="row g-3">
                        <!-- Budget & Capacity Column -->
                        <div class="col-md-6">
                            <!-- Budget Per Person -->
                            <div>
                                <label for="budget_per_person" class="form-label fw-medium text-gray-700 mb-1">Budget Per Person <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="d-flex align-items-center px-3 py-2 rounded-start-3 border border-end-0 border-light bg-light">
                                        <span class="text-muted">{{ $currency_symbol }}</span>
                                    </div>
                            <input type="number" id="budget_per_person" wire:model="budget_per_person" wire:input="updateTotals" min="{{ $min_budget_per_person }}" step="0.01" class="form-control rounded-end-3 border-start-0 {{ $errors->has('budget_per_person') ? 'is-invalid' : '' }}" placeholder="0.00" required>
                                </div>
                                    @error('budget_per_person') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            <!-- Number of People -->
                            <div>
                                <label for="number_of_people" class="form-label fw-medium text-gray-700 mb-1">Number of People <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <button type="button" wire:click="decreasePeople" class="btn btn-outline-secondary rounded-start-3">
                                        <div class="w-5 h-5 d-flex align-items-center justify-content-center">
                                            <i class="ri-subtract-line"></i>
                                        </div>
                                    </button>
                                    <input type="number" id="number_of_people" wire:model="number_of_people" wire:input="updateTotals" min="1" class="form-control text-center focus:ring-0 focus:border-light" style="width: 100px;">
                                    <button type="button" wire:click="increasePeople" class="btn btn-outline-secondary rounded-end-3">
                                        <div class="w-5 h-5 d-flex align-items-center justify-content-center">
                                            <i class="ri-add-line"></i>
                                        </div>
                                    </button>
                                </div>
                                @error('number_of_people') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                    <!-- Expiry Date -->
                    <div>
                        <label for="expiry_date" class="form-label fw-medium text-gray-700 mb-1">Job Expiry Date</label>
                        <input type="date" id="expiry_date" wire:model="expiry_date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}">
                        @error('expiry_date') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <!-- Promotion Options Column -->
                        <div class="col-md-6">
                            <!-- Featured Job Option - Inline Days -->
                            <div class="d-flex flex-wrap align-items-center gap-2 p-3 border border-light rounded-3">
                                <div class="d-flex align-items-center min-w-100">
                                    <input id="featured" type="checkbox" wire:model="featured" wire:change="updateTotals" class="form-check-input h-4 w-4 text-primary rounded-circle">
                                    <div class="ms-3">
                                        <label for="featured" class="form-check-label fw-medium text-gray-700">Featured Job</label>
                                        <p class="small text-muted">Display prominently in search results</p>
                                    </div>
                                </div>
                                @if($featured)
                        <div class="d-flex align-items-center ms-4">
                            <input type="number" wire:model="featured_days" wire:input="updateTotals" min="1" class="form-control w-20 px-2 py-1 rounded-1 {{ $errors->has('featured_days') ? 'is-invalid' : '' }}" placeholder="Days">
                            <span class="small text-muted ms-2">days</span>
                                </div>
                                @endif
                        <span class="ms-auto small text-muted">
                            @if($featuredPrice == 0)
                            Included in your subscription
                            @else
                            {{ $currency_symbol }}{{ number_format($featuredPrice, 2) }} per day
                            @endif
                        </span>
                            </div>
                    <!-- Urgent Badge Option -->
                            <div class="d-flex flex-wrap align-items-center gap-2 p-3 border border-light rounded-3">
                                <div class="d-flex align-items-center min-w-100">
                                    <input id="urgent" type="checkbox" wire:model="urgent" wire:change="updateTotals" class="form-check-input h-4 w-4 text-primary rounded-circle">
                                    <div class="ms-3">
                                        <label for="urgent" class="form-check-label fw-medium text-gray-700">Urgent Badge</label>
                                        <p class="small text-muted">Add badge to attract immediate attention</p>
                                    </div>
                                </div>
                        <span class="ms-auto small text-muted">
                            @if($urgentPrice == 0)
                            Included in your subscription
                            @else
                            {{ $currency_symbol }}{{ number_format($urgentPrice, 2) }} per person
                                @endif
                        </span>
                            </div>
                        </div>
                    </div>
                    <!-- Combined Pricing Summary -->
                    <div class="bg-light rounded-3 p-3 border border-light mt-3">
                        <div class="row g-3">
                            <!-- Total Budget Summary -->
                            <div class="col-md-6">
                                <h3 class="small fw-medium text-muted mb-1">Total Budget</h3>
                                <div class="fw-semibold text-primary fs-5">
                            {{ $currency_symbol }} {{ number_format($total, 2) }}
                                </div>
                        <p class="small text-muted mt-1">For {{ $number_of_people }} person{{ $number_of_people > 1 ? 's' : '' }}</p>
                            </div>
                            <!-- Pricing Summary -->
                            <div class="col-md-6">
                        <h3 class="small fw-bold text-gray-900 mb-1">Posting Fees</h3>
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
                                    Included
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
                                    Included
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
                                <div class="small text-primary mt-1 ms-2">This fee will be refunded if no admin intervention is required to review job submissions.</div>
                            @endif
                            @endif
                                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-light mt-1">
                                        <span class="small fw-semibold text-gray-800">Subtotal:</span>
                                        <span class="small fw-bold text-primary">{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small text-muted">Tax ({{ $tax_rate }}%):</span>
                                        <span class="small fw-medium">{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-light mt-1">
                                        <span class="small fw-semibold text-gray-800">Total:</span>
                                        <span class="small fw-bold text-primary">{{ $currency_symbol }} {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="d-flex justify-content-between mt-4 border-top border-light pt-3">
                <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">
                    <span>Back <i class="ri-arrow-left-line ms-1"></i></span>
                </button>
                <div class="d-flex gap-2">
                    @if($template_id && $isLoggedIn)
                    <button type="button" wire:click="saveAsDraft" class="btn btn-outline-primary px-4">Save Draft</button>
                    @endif
                    <button type="submit" class="btn btn-primary px-4">
                        <span>Next Step <i class="ri-arrow-right-line ms-1"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    @endif

    {{-- Step 4: Login or Review & Confirmation --}}
    @if($currentStep == 4)
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-6">
                <div class="card-body">
                    <h2 class="h4 fw-bold text-gray-900 mb-4">Payment Summary</h2>
                    <div class="border rounded-3 p-4 bg-light">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between">
                                <span>Job Budget:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                        </div>
                        @if($featured)
                            <div class="d-flex justify-content-between">
                                <span>Featured Job ({{ $featured_days }} day{{ $featured_days > 1 ? 's' : '' }}):</span>
                                <span class="fw-medium">@if($featuredPrice == 0) Included @else {{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }} @endif</span>
                        </div>
                        @endif
                        @if($urgent)
                            <div class="d-flex justify-content-between">
                                <span>Urgent Badge ({{ $number_of_people }} people):</span>
                                <span class="fw-medium">@if($urgentPrice == 0) Included @else {{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }} @endif</span>
                        </div>
                        @endif
                            <div class="d-flex justify-content-between">
                                <span>Platform Service Charge:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                        </div>
                            @if($monitoring_fee > 0)
                            <div class="d-flex justify-content-between">
                                <span>Monitoring Fee:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}</span>
                        </div>
                            @if($showSelfMonitoringRefundNote)
                                <div class="small text-primary mt-1 ml-2">This fee will be refunded if no admin intervention is required to review job submissions.</div>
                            @endif
                            @endif
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Tax ({{ $tax_rate }}%):</span>
                                <span class="fw-medium">{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold text-lg">
                                <span>Total:</span>
                                <span class="text-primary">{{ $currency_symbol }} {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                            </div>
            <div class="mb-4">
                <h3 class="h5 fw-semibold mb-2">Payment Information</h3>
                <div class="bg-light border rounded-3 p-4 d-flex align-items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-primary/10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri-shield-check-line text-primary fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <p class="fw-medium text-gray-800 mb-1">Secure Payment</p>
                        <ul class="text-muted list-unstyled list-disc ms-4">
                            <li>After submitting your job, you'll be redirected to our secure payment gateway.</li>
                            <li>Your job will be published immediately after successful payment.</li>
                            <li>We accept credit/debit cards, PayPal, and other payment methods.</li>
                        </ul>
                    </div>
                </div>
            </div>
                @if(!$isLoggedIn)
            <div class="mb-4">
                <h3 class="h5 fw-semibold mb-2">Login Required</h3>
                            <p class="small text-muted mb-3">Please login to continue with your job posting.</p>
                <form wire:submit.prevent="nextStep" class="d-flex flex-column gap-3">
                                <div>
                                    <label for="email" class="form-label fw-medium text-gray-700 mb-1">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="email" wire:model="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password" class="form-label fw-medium text-gray-700 mb-1">Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password" wire:model="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                            <input type="checkbox" id="remember" wire:model="remember" class="form-check-input h-4 w-4 text-primary rounded-circle">
                                        <label for="remember" class="ms-2 small text-muted">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="small text-primary text-decoration-underline">Forgot password?</a>
                                </div>
                    <button type="submit" class="w-100 btn btn-primary font-semibold">Login</button>
                </form>
                <div class="text-center mt-3">
                    <span class="small text-muted">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="small text-primary font-semibold text-decoration-underline">Register</a>
                        </div>
                    </div>
                @else
            <div class="mb-4">
                <form wire:submit.prevent="nextStep" class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" id="terms" wire:model="terms" class="form-check-input h-4 w-4 text-primary rounded-circle">
                        <label for="terms" class="ms-2 small text-muted">I agree to the <a href="{{ route('legal.terms-conditions') }}" target="_blank" class="text-primary text-decoration-underline">Terms and Conditions</a> and <a href="{{ route('legal.privacy-policy') }}" target="_blank" class="text-primary text-decoration-underline">Privacy Policy</a></label>
                    </div>
                    @error('terms') <span class="text-danger small">{{ $message }}</span> @enderror
                    <button type="submit" class="w-100 btn btn-primary font-semibold">Proceed to Payment</button>
                </form>
            </div>
            @endif
    </div>
        <div class="d-flex justify-content-between mt-4">
            <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">
            <div class="d-flex align-items-center">
                <div class="w-5 h-5 d-flex align-items-center justify-content-center me-1">
                    <i class="ri-arrow-left-line"></i>
                </div>
                <span>Back</span>
                </div>
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
    .progress-width-0 {
        width: 0%;
    }

    .progress-width-100 {
        width: 100%;
    }

    .progress-width {
        width: 0%;
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
        background-color: rgba(var(--primary-rgb, 79, 70, 229), 0.1);
        border-color: rgba(var(--primary-rgb, 79, 70, 229), 0.2);
        color: var(--primary, #4F46E5);
        border-radius: 9999px;
        padding: 2px 8px;
        margin-top: 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: var(--primary, #4F46E5);
        margin-right: 5px;
        border: none !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<script src="{{ asset('frontend/js/textarea-linenumbers.js') }}"></script>
<script>
    Livewire.on('step2-shown', function() {
        setTimeout(initializeSelect2, 100);
        setTimeout(window.initLineNumberedTextareas, 100);
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
</script>
@endpush