<div>
    <!-- Page Header -->
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Post a New Task</h1>
                    <p class="mb-0">Create a task in 4 simple steps</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Task</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Post Task</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>
    </section>
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Task Form -->
                <div class="col-lg-8">
                    <div class="step-indicator">
                        <div class="step {{ $currentStep >= 1 ? 'active' : '' }} {{ $currentStep > 1 ? 'completed' : '' }}" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-label">Details & Template</div>
                        </div>
                        <div class="step {{ $currentStep >= 2 ? 'active' : '' }} {{ $currentStep > 2 ? 'completed' : '' }}" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-label">Additional Details</div>
                        </div>
                        <div class="step {{ $currentStep >= 3 ? 'active' : '' }} {{ $currentStep > 3 ? 'completed' : '' }}" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-label">Budget</div>
                        </div>
                        <div class="step {{ $currentStep >= 4 ? 'active' : '' }}" data-step="4">
                            <div class="step-number">4</div>
                            <div class="step-label">Review</div>
                        </div>
                    </div>

                    <form id="taskWizardForm">
                        <!-- Step 1: Task Details & Template -->
                        <div class="wizard-step {{ $currentStep == 1 ? 'active' : '' }}" id="step1">
                            <div class="form-card card">
                                <div class="card-header bg-transparent">
                                    <h5 class="mb-0">Step 1: Task Details & Template</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Task Title *</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 px-3">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="text" id="taskTitle"
                                                    class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                    placeholder="e.g. Create social media posts for my business"
                                                    wire:model.live="title"
                                                    required>
                                            </div>

                                            <div class="form-text">Be specific about what you need done</div>
                                            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>

                                    </div>

                                    <div class="mb-4">
                                        <label for="description-editor" class="form-label fw-bold">Job Description *</label>
                                        <div class="linenumbered-textarea">
                                            <div class="line-numbers"></div>
                                            <textarea id="description-editor" rows="4" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Write step by step/line by line instructions on what the user should do" wire:model="description" required>{{ $description }}</textarea>
                                        </div>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div wire:ignore class="mb-4">
                                        <label for="templateSelect" class="form-label fw-bold">Select Template *</label>
                                        <select id="templateSelect" class="form-select" wire:model="template_id" required>
                                            <option value="">Choose a template...</option>
                                            @foreach($platforms as $platform)
                                            <optgroup label="{{ $platform->name }}">
                                                @foreach($platform->templates as $template)
                                                <option value="{{ $template->id }}"
                                                    data-platform-id="{{ $platform->id }}"
                                                    data-icon="{{ $platform->image ? 'bi-image' : 'bi-file-earmark' }}">
                                                    {{ $template->name }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                        <div class="form-text">Choose a template that best matches your task</div>
                                        @error('template_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Loading state for template fields -->
                                    @if($isTemplateLoading)
                                    <div class="mt-3 text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <small class="text-muted">Loading template fields...</small>
                                        </div>
                                    </div>
                                    @endif


                                    <div id="templateFields" class="mt-4 @if($templateFieldsLoaded) d-block @else d-none @endif">
                                        <h6 class="border-bottom pb-2">Template Requirements</h6>
                                        @livewire('tasks.task-template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div></div> <!-- Empty div for spacing -->
                                        <button type="button" class="btn btn-primary" wire:click="nextStep" {{ !$templateFieldsLoaded ? 'disabled' : '' }}>Next: Details</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Step 2: Additional Details -->
                        <div class="wizard-step {{ $currentStep == 2 ? 'active' : '' }}" id="step2">
                            <div class="form-card card">
                                <div class="card-header bg-transparent">
                                    <h5 class="mb-0">Step 2: Additional Details</h5>
                                </div>
                                <div class="card-body">
                                    <div wire:ignore class="mb-4">
                                        <label for="toolsSelect" class="form-label fw-bold">Tools Required</label>
                                        <input type="text" name="" class="form-control {{ $errors->has('requirements') ? 'is-invalid' : '' }}" id="toolsSelect">
                                        <div class="form-text">Add tools or software required for this job</div>
                                        @error('requirements') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Average Completion Time</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control {{ $errors->has('average_completion_minutes') ? 'is-invalid' : '' }}" min="1" wire:model="average_completion_minutes">
                                                    <select class="form-select" style="max-width: 120px;" wire:model="time_unit">
                                                        <option value="minutes">Minutes</option>
                                                        <option value="hours">Hours</option>
                                                        <option value="days" selected>Days</option>
                                                        <option value="weeks">Weeks</option>
                                                    </select>
                                                </div>
                                                @error('average_completion_minutes') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Expiry Date *</label>
                                                <input type="date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" wire:model="expiry_date" required>
                                                <div class="form-text">When should applications close?</div>
                                                @error('expiry_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Privacy *</label>
                                                <select class="form-select {{ $errors->has('visibility') ? 'is-invalid' : '' }}" id="taskPrivacy" wire:model="visibility">
                                                    <option value="public">Public</option>
                                                    <option value="private">Private</option>
                                                </select>
                                                <div class="form-text">Who can find your task</div>
                                                @error('visibility') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Geographical Restriction</label>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input restriction" type="radio" name="restriction" id="allow_all_countries" value="all" wire:model.live="restriction">
                                                    <label class="form-check-label d-flex align-items-center" for="allow_all_countries">
                                                        <i class="ri-sun-line me-2"></i>Allow All Countries
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input restriction" type="radio" name="restriction" id="allow_selected_countries" value="allow" wire:model.live="restriction">
                                                    <label class="form-check-label d-flex align-items-center" for="allow_selected_countries">
                                                        <i class="ri-moon-line me-2"></i>Allow Selected
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input restriction" type="radio" name="restriction" id="deny_selected_countries" value="deny" wire:model.live="restriction">
                                                    <label class="form-check-label d-flex align-items-center" for="deny_selected_countries">
                                                        <i class="ri-computer-line me-2"></i>Deny Selected
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div wire:ignore class="my-3 @if($restriction == 'all') d-none @else d-block @endif" id="countriesContainer">
                                            <select name="" class="form-select {{ $errors->has('task_countries') ? 'is-invalid' : '' }}" id="countries" multiple>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('task_countries') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>

                                    </div>


                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-primary" wire:click="previousStep">Previous</button>
                                        <button type="button" class="btn btn-primary" wire:click="nextStep">Next: Budget</button>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Budget -->
                        <div class="wizard-step {{ $currentStep == 3 ? 'active' : '' }}" id="step3">
                            <div class="form-card card">
                                <div class="card-header bg-transparent">
                                    <h5 class="mb-0">Step 3: Budget & Preferences</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Review Preference</label>
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="promotion-card">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="review_type" id="autoReview" value="system_review" wire:model="review_type">
                                                        <label class="form-check-label fw-bold" for="autoReview">
                                                            Automatic Review
                                                        </label>
                                                    </div>
                                                    <p class="small text-muted mb-0">System automatically checks submissions for quality</p>
                                                    <div class="mt-2">
                                                        <strong>Cost: {{ $currency_symbol }}{{ number_format($systemReviewCost, 2) }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($enable_system_submission_review)
                                            <div class="col-md-4">
                                                <div class="promotion-card">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="review_type" id="adminReview" value="admin_review" wire:model="review_type">
                                                        <label class="form-check-label fw-bold" for="adminReview">
                                                            Admin Review
                                                        </label>
                                                    </div>
                                                    <p class="small text-muted mb-0">Admin will review and approve each submission</p>
                                                    <div class="mt-2">
                                                        <strong>Cost: {{ $currency_symbol }}{{ number_format($adminReviewCost, 2) }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-md-4">
                                                <div class="promotion-card">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="review_type" id="selfReview" value="self_review" wire:model="review_type">
                                                        <label class="form-check-label fw-bold" for="selfReview">
                                                            Self Review
                                                        </label>
                                                    </div>
                                                    <p class="small text-muted mb-0">You review and approve each submission</p>
                                                    <div class="mt-2">
                                                        <strong>Cost: {{ $currency_symbol }}{{ number_format($adminReviewCost, 2) }}</strong> (Refundable)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Number of Submissions</label>
                                            <input type="number" class="form-control {{ $errors->has('number_of_submissions') ? 'is-invalid' : '' }}" min="1" wire:model="number_of_submissions" wire:change="updateTotals">
                                            <div class="form-text">How many workers can work on this task?</div>
                                            @error('number_of_submissions') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Budget per Submission (Min: {{ $currency_symbol.$min_budget_per_submission  }})</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    {{ $currency_symbol }}
                                                </span>
                                                <input type="number" class="form-control {{ $errors->has('budget_per_submission') ? 'is-invalid' : '' }}" min="{{ $min_budget_per_submission }}" step="0.01" wire:model="budget_per_submission" wire:change="updateTotals">
                                            </div>

                                            <div class="form-text">Amount paid for each completed submission</div>
                                            @error('budget_per_submission') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="allowMultiple" wire:model="allow_multiple_submissions">
                                            <label class="form-check-label fw-bold" for="allowMultiple">
                                                Allow Multiple Submissions per Worker
                                            </label>
                                        </div>
                                        <div class="form-text">Workers can submit multiple times for this task</div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="row mt-2 align-items-center">
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="featuredJob" wire:model="featured" wire:change="updateTotals" {{ $hasFeaturedSubscription ? 'checked disabled' : '' }}>
                                                    <label class="form-check-label fw-bold" for="featuredJob">
                                                        Featured Promotion {{ $hasFeaturedSubscription ? '(Active Subscription)' : '' }}
                                                    </label>
                                                </div>
                                                <div class="form-text">
                                                    @if($hasFeaturedSubscription)
                                                    Your subscription covers featured promotion for {{ $featuredSubscriptionDaysRemaining }} days
                                                    @else
                                                    Advertise to different pages
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2 @if(!$featured) d-none @endif" id="featuredDays">
                                                <label class="form-label">Number of Days</label>
                                                <input type="number" class="form-control" min="1" wire:model="featured_days" wire:change="updateTotals" {{ $hasFeaturedSubscription ? 'readonly' : '' }}>
                                                <div class="form-text">
                                                    @if($hasFeaturedSubscription)
                                                    Days covered by your subscription
                                                    @else
                                                    Your task will be featured for {{ $currency_symbol }}{{ $featuredPrice }}/day
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="broadcastBadge" wire:model="broadcast" wire:change="updateTotals" {{ $hasBroadcastSubscription ? 'checked disabled' : '' }}>
                                            <label class="form-check-label fw-bold" for="broadcastBadge">
                                                Broadcast Task {{ $hasBroadcastSubscription ? '(Active Subscription)' : '' }}
                                            </label>
                                        </div>
                                        <div class="form-text">
                                            @if($hasBroadcastSubscription)
                                            Your subscription covers broadcast promotion
                                            @else
                                            Broadcast task to all who are fit for this task for {{ $currency_symbol }}{{ $broadcastPrice }}
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Cost Summary -->
                                    <div class="card bg-light mb-4">
                                        <div class="card-body">
                                            <h6>Cost Summary</h6>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Task Budget:</span>
                                                <strong>{{ $currency_symbol }}{{ number_format($expected_budget ?: 0, 2) }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Platform Fee:</span>
                                                <strong>{{ $currency_symbol }}{{ number_format($serviceFee ?: 0, 2) }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Promotions:</span>
                                                <strong>{{ $currency_symbol }}{{ number_format(($featured ? $featuredPrice * ($featured_days ?: 0) : 0) + ($broadcast ? $broadcastPrice * ($number_of_submissions ?: 0) : 0), 2) }}</strong>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>Total:</span>
                                                <strong>{{ $currency_symbol }}{{ number_format($total ?: 0, 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-primary" wire:click="previousStep">Previous</button>
                                        <button type="button" class="btn btn-primary" wire:click="nextStep">Next: Review</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Review -->
                        <div class="wizard-step {{ $currentStep == 4 ? 'active' : '' }}" id="step4">
                            <div class="form-card card">
                                <div class="card-header bg-transparent">
                                    <h5 class="mb-0">Step 4: Review & Submit</h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <h6><i class="bi bi-info-circle"></i> Almost Done!</h6>
                                        <p class="mb-0">Review your task details below. You can go back to make changes or submit your task.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="border-bottom pb-2 mb-3">Task Summary</h6>

                                            <div class="mb-3">
                                                <strong>Title:</strong>
                                                <span class="ms-2">{{ $title ?: '-' }}</span>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Description:</strong>
                                                <div class="mt-1 p-2 bg-light rounded small">{{ Str::limit($description, 200) ?: '-' }}</div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Tools Required:</strong>
                                                <div class="mt-1">{{ $requirements ? implode(', ', $requirements) : '-' }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <strong>Completion Time:</strong>
                                                    <div class="mt-1">{{ $average_completion_minutes ?: '-' }} {{ $time_unit ?: '' }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <strong>Expiry Date:</strong>
                                                    <div class="mt-1">{{ $expiry_date ? \Carbon\Carbon::parse($expiry_date)->format('M j, Y') : '-' }}</div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Review Type:</strong>
                                                <div class="mt-1">{{ $review_type ? ucfirst(str_replace('_', ' ', $review_type)) : '-' }}</div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Visibility:</strong>
                                                <div class="mt-1">{{ $visibility ? ucfirst($visibility) : '-' }}</div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Allow Multiple Submissions:</strong>
                                                <div class="mt-1">{{ $allow_multiple_submissions ? 'Yes' : 'No' }}</div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Template:</strong>
                                                <span class="ms-2">
                                                    @if($template_id)
                                                    @php $template = \App\Models\PlatformTemplate::find($template_id); @endphp
                                                    {{ $template ? $template->name : '-' }}
                                                    @else
                                                    -
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Budget:</strong>
                                                <span class="ms-2">{{ $currency_symbol }}{{ number_format($budget_per_submission ?: 0, 2) }} per submission</span>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Promotions:</strong>
                                                <div class="mt-1">
                                                    @php
                                                    $promotions = [];
                                                    if ($featured) $promotions[] = 'Featured';
                                                    if ($broadcast) $promotions[] = 'Broadcast Badge';
                                                    @endphp
                                                    {{ $promotions ? implode(', ', $promotions) : 'None' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6>Cost Summary</h6>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Task Budget:</span>
                                                        <strong>{{ $currency_symbol }}{{ number_format($expected_budget ?: 0, 2) }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Platform Fee ({{ $tax_rate }}%):</span>
                                                        <strong>{{ $currency_symbol }}{{ number_format($serviceFee ?: 0, 2) }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Promotions:</span>
                                                        <strong>{{ $currency_symbol }}{{ number_format(($featured ? $featuredPrice * ($featured_days ?: 0) : 0) + ($broadcast ? $broadcastPrice * ($number_of_submissions ?: 0) : 0), 2) }}</strong>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between fw-bold">
                                                        <span>Total:</span>
                                                        <strong>{{ $currency_symbol }}{{ number_format($total ?: 0, 2) }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Terms & Conditions -->
                                    <div class="card mb-4 border-info">
                                        <div class="card-header bg-info-subtle border-info">
                                            <h5 class="mb-0 fw-semibold text-info">
                                                <i class="ri-file-text-line me-2"></i>
                                                Terms & Conditions
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input type="checkbox" id="terms" wire:model="terms" class="form-check-input {{ $errors->has('terms') ? 'is-invalid' : '' }}">
                                                <label for="terms" class="form-check-label">
                                                    I agree to the <a href="{{ route('legal.terms-conditions') }}" target="_blank" class="text-primary text-decoration-underline">Terms and Conditions</a> and <a href="{{ route('legal.privacy-policy') }}" target="_blank" class="text-primary text-decoration-underline">Privacy Policy</a>
                                                </label>
                                                @error('terms') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mt-4">
                                                <button type="button" wire:click="submitJob" wire:target="submitJob" wire:loading.attr="disabled" wire:loading.class="btn-loading" class="btn btn-primary w-100 fw-semibold py-3">
                                                    
                                                    <span wire:loading.class="d-none" wire:target="submitJob" class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="bi bi-arrow-up-right-circle-fill me-2"></i>
                                                        Proceed to Payment
                                                    </span>
                                                    <span wire:loading.class="d-inline-flex" wire:target="submitJob" class="align-items-center justify-content-center" style="display: none;">
                                                        <i class="bi bi-arrow-repeat me-2"></i>
                                                        Loading...
                                                    </span>
                                                    
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-primary" wire:click="previousStep">Previous</button>

                                        <div>
                                            <button type="button" class="btn btn-outline-secondary me-2" wire:click="saveAsDraft">Save as Draft</button>
                                            <!-- <button type="button" class="btn btn-success" wire:click="submitJob">Post Task</button> -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Preview & Tips -->
                <div class="col-lg-4">
                    <!-- Task Preview -->
                    <div class="preview-card card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Task Preview</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted">How your task will appear to workers:</h6>
                            <div class="task-card card h-100 mt-2">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-info">{{ $template_id ? \App\Models\PlatformTemplate::find($template_id)?->platform?->name : 'Platform' }}</span>
                                        <span class="price-tag">{{ $currency_symbol ?? '$' }}{{ number_format($budget_per_submission ?: 0, 2) }}</span>
                                    </div>
                                    <h5 class="card-title">
                                        {{ $title ?: 'Task Title Will Appear Here' }}
                                    </h5>
                                    <p class="card-text text-muted">{{ Str::words($description ?: 'Task description preview...', 10, '...') }}</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="bi bi-clock"></i> {{ $expiry_date ? \Carbon\Carbon::parse($expiry_date)->diffForHumans() : 'Deadline' }}</small>
                                        <small class="text-muted"><i class="bi bi-person"></i> 0/{{ $number_of_submissions ?: 1 }} submissions</small>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent">
                                    <button class="btn apply-btn w-100" disabled>Apply Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Tips for Better Tasks</h6>
                        </div>
                        <div class="card-body">
                            <ul class="small">
                                <li class="mb-2"><strong>Be specific</strong> about requirements and deliverables</li>
                                <li class="mb-2"><strong>Set a realistic budget</strong> based on task complexity</li>
                                <li class="mb-2"><strong>Include clear deadlines</strong> for timely completion</li>
                                <li class="mb-2"><strong>Provide examples</strong> of what you're looking for</li>
                                <li class="mb-2"><strong>Be available</strong> to answer worker questions</li>
                                <li><strong>Review applications</strong> carefully before selecting</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('scripts')
<script src="{{ asset('frontend/js/choices.min.js') }}"></script>
<script src="{{ asset('frontend/js/textarea-linenumbers.js') }}"></script>
<script>
    // Initialize line numbered textareas
    function initializeLineNumbers() {
        if (typeof window.initLineNumberedTextareas === 'function') {
            window.initLineNumberedTextareas();
        }
    }

    // Initialize Choices.js for template select
    let templateSelectInstance = null;

    // Initialize Choices.js instances
    let toolsSelectInstance = null;
    let countriesSelectInstance = null;

    function initializeStep1Select() {
        const templateSelect = document.getElementById('templateSelect');
        if (templateSelect && !templateSelect.choicesInstance) {
            templateSelectInstance = new Choices('#templateSelect', {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Search and select a template...',
                searchPlaceholderValue: 'Search templates...',
                itemSelectText: '',
                item: (item) => {
                    const icon = item.element.getAttribute('data-icon');
                    if (icon) {
                        return `<div class="d-flex align-items-center">
                            <i class="${icon} me-2"></i>
                            <span>${item.label}</span>
                        </div>`;
                    }
                    return item.label;
                },
                choice: (item) => {
                    const icon = item.element.getAttribute('data-icon');
                    if (icon) {
                        return `<div class="d-flex align-items-center">
                            <i class="${icon} me-2"></i>
                            <span>${item.label}</span>
                        </div>`;
                    }
                    return item.label;
                }
            });

            // Also listen to Choices.js choice event as backup
            templateSelect.addEventListener('choice', function(event) {
                const values = templateSelectInstance.getValue(true);
                Livewire.dispatch('choiceSelected', {
                    id: 'selectedTemplate',
                    values: values
                });
            });

        }
    }
    // Function to initialize step 2 selects
    function initializeStep2Selects() {
        console.log('step2 function')
        setTimeout(() => {
            const step2 = document.getElementById('step2');
            console.log('found step2 classes' + step2.classList)
            if (step2 && step2.classList.contains('active')) {
                console.log('step2 is active')
                // Initialize tools select if it exists
                const toolsSelect = document.getElementById('toolsSelect');
                if (toolsSelect && !toolsSelect.choicesInstance) {
                    toolsSelectInstance = new Choices('#toolsSelect', {
                        addItems: true,
                        delimiter: ',',
                        editItems: true,
                        maxItemCount: 5,
                        removeItemButton: true,
                        placeholder: true,
                        placeholderValue: 'Add tools (e.g., Photoshop, Excel)',
                    });

                    // Sync Choices.js selections with Livewire
                    toolsSelect.addEventListener('change', function(event) {
                        const values = toolsSelectInstance.getValue(true);
                        // Dispatch Livewire event
                        Livewire.dispatch('choiceSelected', {
                            id: 'toolsSelect',
                            values: values
                        });
                    });
                }

                // Initialize countries select if restriction is not 'all'
                initializeCountriesSelect();

            }
        }, 100);
    }

    // Function to initialize countries select
    function initializeCountriesSelect() {
        const countriesContainer = document.getElementById('countriesContainer');
        if (countriesContainer && !countriesContainer.classList.contains('d-none')) {
            const countriesSelect = document.getElementById('countries');
            if (countriesSelect && !countriesSelect.choicesInstance) {
                countriesSelectInstance = new Choices('#countries', {
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Select countries...',
                    searchPlaceholderValue: 'Search countries...',
                    removeItemButton: true,
                    removeItems: true,
                    itemSelectText: '',

                });

                // Sync Choices.js selections with Livewire
                countriesSelect.addEventListener('change', function(event) {
                    const values = countriesSelectInstance.getValue(true);
                    // Dispatch Livewire event
                    Livewire.dispatch('choiceSelected', {
                        id: 'countriesSelect',
                        values: values
                    });
                });
            }
        }
    }

    // Initialize on page load
    document.addEventListener('livewire:init', function() {
        initializeStep1Select();
        // Check if step 1 is active and initialize line numbers
        const step1 = document.getElementById('step1');
        if (step1 && step1.classList.contains('active')) {
            setTimeout(initializeLineNumbers, 100);
        }
        Livewire.on('step1-shown', function() {
            initializeStep1Select();
        });

        // Initialize step 2 selects when step becomes active
        Livewire.on('step2-shown', function() {
            console.log('step2-shown')
            initializeStep2Selects();
        });

        // Initialize countries select when restriction changes
        Livewire.on('restriction-changed', function() {
            setTimeout(() => {
                initializeCountriesSelect();
            }, 100);
        });

        $(document).on('change', '.restriction', function() {
            const value = $(this).val();
            if (value != 'all') {
                // Show countries container
                $('#countriesContainer').removeClass('d-none');
                // Initialize countries select
                setTimeout(() => {
                    initializeCountriesSelect();
                }, 100);
            } else {
                // Hide countries container
                $('#countriesContainer').addClass('d-none');
            }
        })

    });



    // Promotion toggles
    const featuredJob = document.getElementById('featuredJob');
    if (featuredJob) {
        featuredJob.addEventListener('change', function() {
            const featuredDays = document.getElementById('featuredDays');
            if (this.checked) {
                featuredDays.classList.remove('d-none');
            } else {
                featuredDays.classList.add('d-none');
            }
        });
    }

    // Listen for step changes to initialize selects when step 2 becomes active
    // document.addEventListener('livewire:navigated', function() {
    //     initializeStep2Selects();
    // });

    // Also listen for Livewire updates





    // Form submission
    document.getElementById('taskWizardForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Task posted successfully!');
        // Here you would typically send the form data to your backend
    });
</script>
@endpush
@push('styles')
<link href="{{ asset('frontend/css/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('frontend/css/textarea-linenumbers.css') }}" rel="stylesheet" />
<style>
    .choices__list--multiple .choices__item {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>
@endpush