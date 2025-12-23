<div>
    <!-- Page Header -->
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Edit Task</h1>
                    <p class="mb-0">Update your task details and proceed to payment.</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('tasks.posted')}}">Posted Tasks</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($hasWorkers)
            <div class="alert alert-danger mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <div>
                        <strong class="fw-bold">This task cannot be edited.</strong>
                        <span class="d-block">This task already has workers assigned and cannot be modified.</span>
                    </div>
                </div>
            </div>
            @elseif($isPaid)
            <div class="alert alert-warning mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle me-2"></i>
                    <div>
                        <strong class="fw-bold">Limited editing available.</strong>
                        <span class="d-block">This task has been paid for. You can only edit basic details, not budget or preferences.</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <!-- Task Form -->
                <div class="col-lg-8">
                    <form wire:submit.prevent="submitJob">
                        <!-- Step 1: Task Details & Template -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-semibold">
                                    <i class="bi bi-info-circle me-2 text-primary"></i>
                                    Task Details & Template
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Task Title -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Task Title *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 px-3">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="text" id="taskTitle"
                                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                            placeholder="e.g. Create social media posts for my business"
                                            wire:model.live="title"
                                            required @if(!$canEdit) readonly disabled @endif>
                                    </div>
                                    <div class="form-text">Be specific about what you need done</div>
                                    @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <!-- Job Description -->
                                <div class="mb-4">
                                    <label for="description-editor" class="form-label fw-bold">Job Description *</label>
                                    <textarea id="description-editor" rows="4" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Write step by step/line by line instructions on what the user should do" wire:model="description" required @if(!$canEdit) readonly disabled @endif>{{ $description }}</textarea>
                                    @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <!-- Select Template -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Select Template *</label>
                                    @if($isPaid)
                                        <!-- For paid tasks, show read-only template info -->
                                        <div class="form-control-plaintext bg-light p-2 rounded border">
                                            @php $selectedTemplate = \App\Models\PlatformTemplate::find($template_id); @endphp
                                            <strong>{{ $selectedTemplate ? $selectedTemplate->name : 'Unknown Template' }}</strong>
                                            <br><small class="text-muted">Platform cannot be changed for paid tasks</small>
                                        </div>
                                        <!-- Hidden input to maintain the value -->
                                        <input type="hidden" wire:model="template_id" value="{{ $template_id }}">
                                    @else
                                        <!-- For unpaid tasks, show editable select -->
                                        <div wire:ignore>
                                            <select id="templateSelect" class="form-select" wire:model="template_id" required @if(!$canEdit) disabled @endif>
                                                <option value="">Choose a template...</option>
                                                @foreach($platforms as $platform)
                                                <optgroup label="{{ $platform->name }}">
                                                    @foreach($platform->templates as $template)
                                                    <option value="{{ $template->id }}"
                                                        {{ $template_id == $template->id ? 'selected' : '' }}
                                                        data-platform-id="{{ $platform->id }}"
                                                        data-icon="{{ $platform->image ? 'bi-image' : 'bi-file-earmark' }}">
                                                        {{ $template->name }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                            <div class="form-text">Choose a template that best matches your task</div>
                                        </div>
                                    @endif
                                    @error('template_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <!-- Template Fields -->
                                <div id="templateFields" class="mt-4 @if(!$template_id) d-none @endif">
                                    <h6 class="border-bottom pb-2">Template Fields</h6>
                                    @if($template_id)
                                        @livewire('tasks.task-template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
                                    @else
                                        <p class="text-muted">Select a template to view fields.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Additional Details -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-semibold">
                                    <i class="bi bi-gear me-2 text-primary"></i>
                                    Additional Details
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Tools Required -->
                                <div wire:ignore class="mb-4">
                                    <label for="toolsSelect" class="form-label fw-bold">Tools Required</label>
                                    <input type="text" name="" value="abc,xyz" class="form-control {{ $errors->has('requirements') ? 'is-invalid' : '' }}" id="toolsSelect" @if(!$canEdit) disabled @endif>
                                    <div class="form-text">Add tools or software required for this job</div>
                                    @error('requirements') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <!-- Average Completion Time, Expiry Date, Privacy -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Average Completion Time</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control {{ $errors->has('average_completion_minutes') ? 'is-invalid' : '' }}" min="1" wire:model="average_completion_minutes" @if(!$canEdit) readonly disabled @endif>
                                                <select class="form-select" style="max-width: 120px;" wire:model="time_unit" @if(!$canEdit) disabled @endif>
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
                                            <input type="date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" wire:model="expiry_date" required @if(!$canEdit) readonly disabled @endif>
                                            <div class="form-text">When should applications close?</div>
                                            @error('expiry_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Privacy *</label>
                                            <select class="form-select {{ $errors->has('visibility') ? 'is-invalid' : '' }}" id="taskPrivacy" wire:model="visibility" @if(!$canEdit) disabled @endif>
                                                <option value="public">Public</option>
                                                <option value="private">Private</option>
                                            </select>
                                            <div class="form-text">Who can find your task</div>
                                            @error('visibility') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Geographical Restriction -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Geographical Restriction</label>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input restriction" type="radio" name="restriction" id="allow_all_countries" value="all" wire:model.live="restriction" @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label d-flex align-items-center" for="allow_all_countries">
                                                    <i class="bi bi-globe me-2"></i>Allow All Countries
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input restriction" type="radio" name="restriction" id="allow_selected_countries" value="allow" wire:model.live="restriction" @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label d-flex align-items-center" for="allow_selected_countries">
                                                    <i class="bi bi-check-circle me-2"></i>Allow Selected
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input restriction" type="radio" name="restriction" id="deny_selected_countries" value="deny" wire:model.live="restriction" @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label d-flex align-items-center" for="deny_selected_countries">
                                                    <i class="bi bi-x-circle me-2"></i>Deny Selected
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div wire:ignore class="my-3 @if($restriction == 'all') d-none @else d-block @endif" id="countriesContainer">
                                        <select name="" class="form-select {{ $errors->has('task_countries') ? 'is-invalid' : '' }}" id="countries" multiple @if(!$canEdit) disabled @endif>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('task_countries') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Budget & Preferences -->
                        @if(!$isPaid)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-semibold">
                                    <i class="bi bi-cash me-2 text-primary"></i>
                                    Budget & Preferences
                                </h5>
                            </div>
                            <div class="card-body">
                        @else
                        <div class="card mb-4 border-secondary">
                            <div class="card-header bg-secondary bg-opacity-10 border-secondary">
                                <h5 class="mb-0 fw-semibold text-secondary">
                                    <i class="bi bi-cash me-2"></i>
                                    Budget & Preferences
                                    <small class="text-muted">(Not editable for paid tasks)</small>
                                </h5>
                            </div>
                            <div class="card-body opacity-50">
                        @endif
                                <!-- Review Preference -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Review Preference</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="promotion-card">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="review_type" id="autoReview" value="system_review" wire:model="review_type" @if(!$canEdit) disabled @endif>
                                                    <label class="form-check-label fw-bold" for="autoReview">
                                                        Automatic Review
                                                    </label>
                                                </div>
                                                <p class="small text-muted mb-0">System automatically checks submissions for quality</p>
                                                <div class="mt-2">
                                                    <strong>Cost: {{ $currency_symbol }}{{ number_format($systemReviewCost ?? 0, 2) }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        @if($enable_system_review)
                                        <div class="col-md-4">
                                            <div class="promotion-card">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="review_type" id="adminReview" value="admin_review" wire:model="review_type" @if(!$canEdit) disabled @endif>
                                                    <label class="form-check-label fw-bold" for="adminReview">
                                                        Admin Review
                                                    </label>
                                                </div>
                                                <p class="small text-muted mb-0">Admin will review and approve each submission</p>
                                                <div class="mt-2">
                                                    <strong>Cost: {{ $currency_symbol }}{{ number_format($adminReviewCost ?? 0, 2) }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-4">
                                            <div class="promotion-card">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="review_type" id="selfReview" value="self_review" wire:model="review_type" @if(!$canEdit) disabled @endif>
                                                    <label class="form-check-label fw-bold" for="selfReview">
                                                        Self Review
                                                    </label>
                                                </div>
                                                <p class="small text-muted mb-0">You review and approve each submission</p>
                                                <div class="mt-2">
                                                    <strong>Cost: {{ $currency_symbol }}{{ number_format($adminReviewCost ?? 0, 2) }}</strong> (Refundable)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Number of Submissions & Budget -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Number of Submissions</label>
                                        <input type="number" class="form-control {{ $errors->has('number_of_submissions') ? 'is-invalid' : '' }}" min="1" wire:model="number_of_submissions" wire:change="updateTotals" @if(!$canEdit) readonly disabled @endif>
                                        <div class="form-text">How many workers can work on this task?</div>
                                        @error('number_of_submissions') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Budget per Submission (Min: {{ $currency_symbol.$min_budget_per_submission  }})</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                {{ $currency_symbol }}
                                            </span>
                                            <input type="number" class="form-control {{ $errors->has('budget_per_submission') ? 'is-invalid' : '' }}" min="{{ $min_budget_per_submission }}" step="0.01" wire:model="budget_per_submission" wire:change="updateTotals" @if(!$canEdit) readonly disabled @endif>
                                        </div>
                                        <div class="form-text">Amount paid for each completed submission</div>
                                        @error('budget_per_submission') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Allow Multiple Submissions -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allowMultiple" wire:model="allow_multiple_submissions" @if(!$canEdit) disabled @endif>
                                        <label class="form-check-label fw-bold" for="allowMultiple">
                                            Allow Multiple Submissions per Worker
                                        </label>
                                    </div>
                                    <div class="form-text">Workers can submit multiple times for this task</div>
                                </div>

                                <!-- Featured Job -->
                                <div class="row mt-2 align-items-center mb-4">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="featuredJob" wire:model="featured" wire:change="updateTotals" {{ $hasFeaturedSubscription ? 'checked disabled' : '' }} @if(!$canEdit) disabled @endif>
                                            <label class="form-check-label fw-bold" for="featuredJob">
                                                Featured Promotion {{ $hasFeaturedSubscription ? '(Active Subscription)' : '' }}
                                            </label>
                                        </div>
                                        <div class="form-text">
                                            @if($hasFeaturedSubscription)
                                            Your subscription covers featured promotion for {{ $featuredSubscriptionDaysRemaining ?? 0 }} days
                                            @else
                                            Advertise to different pages
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2 @if(!$featured) d-none @endif" id="featuredDays">
                                        <label class="form-label">Number of Days</label>
                                        <input type="number" class="form-control" min="1" wire:model="featured_days" wire:change="updateTotals" {{ $hasFeaturedSubscription ? 'readonly' : '' }} @if(!$canEdit) disabled @endif>
                                        <div class="form-text">
                                            @if($hasFeaturedSubscription)
                                            Days covered by your subscription
                                            @else
                                            Your task will be featured for {{ $currency_symbol }}{{ $featuredPrice }}/day
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Broadcast Badge -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="broadcastBadge" wire:model="broadcast" wire:change="updateTotals" {{ $hasBroadcastSubscription ? 'checked disabled' : '' }} @if(!$canEdit) disabled @endif>
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
                            </div>
                        </div>
                </div>

                <!-- Preview & Actions -->
                <div class="col-lg-4">
                    <!-- Review & Submit -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-semibold">
                                <i class="bi bi-check-circle me-2 text-primary"></i>
                                Review & Submit
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info small">
                                <i class="bi bi-info-circle me-1"></i>
                                Review your task details and submit for payment.
                            </div>

                            <!-- Task Summary -->
                            <div class="mb-3">
                                <h6 class="border-bottom pb-2">Task Summary</h6>
                                <div class="small">
                                    <div class="mb-2"><strong>Title:</strong> {{ Str::limit($title ?: 'No title', 30) }}</div>
                                    <div class="mb-2"><strong>Budget:</strong> {{ $currency_symbol }}{{ number_format($budget_per_submission ?: 0, 2) }}/submission</div>
                                    <div class="mb-2"><strong>Submissions:</strong> {{ $number_of_submissions ?: 1 }}</div>
                                    <div class="mb-2"><strong>Total:</strong> {{ $currency_symbol }}{{ number_format($total ?: 0, 2) }}</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                @if(!$hasWorkers)
                                <button type="button" wire:click="saveAsDraft" class="btn btn-outline-secondary">
                                    <i class="bi bi-save me-1"></i>
                                    Save as Draft
                                </button>
                                @endif

                                @if(!$isPaid)
                                <!-- Terms & Conditions for unpaid tasks -->
                                <div class="mb-3">
                                    <div class="form-check small">
                                        <input type="checkbox" id="terms" wire:model="terms" class="form-check-input {{ $errors->has('terms') ? 'is-invalid' : '' }}" @if(!$canEdit) disabled @endif>
                                        <label for="terms" class="form-check-label">
                                            I agree to <a href="{{ route('legal.terms-conditions') }}" target="_blank" class="text-decoration-underline">Terms</a>
                                        </label>
                                        @error('terms') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <button type="button" wire:click="submitJob" wire:target="submitJob" wire:loading.attr="disabled" wire:loading.class="btn-loading" class="btn btn-primary" @if(!$canEdit || !$terms) disabled @endif>
                                    <span wire:loading.class="d-none" wire:target="submitJob">
                                        <i class="bi bi-credit-card me-1"></i>
                                        Proceed to Payment
                                    </span>
                                    <span wire:loading.class="d-inline-flex" wire:target="submitJob" style="display: none;">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        Processing...
                                    </span>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Task Preview -->
                    <div class="preview-card card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Task Preview</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted small">How your task will appear to workers:</h6>
                            <div class="task-card card h-100 mt-2">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-info">{{ $task->platform->name ?? 'Platform' }}</span>
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
<script>
    // Initialize Choices.js for template select
    let templateSelectInstance = null;
    let toolsSelectInstance = null;

    function initializeTemplateSelect() {
        const templateSelect = document.getElementById('templateSelect');
        if (templateSelect && !templateSelect.choicesInstance && !templateSelect.hasAttribute('disabled')) {
            // Only initialize Choices.js for editable selects (unpaid tasks)
            templateSelectInstance = new Choices('#templateSelect', {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Search and select a template...',
                searchPlaceholderValue: 'Search templates...',
                itemSelectText: '',
                shouldSort: false, // Keep original order
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

            // Listen for template selection changes
            templateSelect.addEventListener('change', function(event) {
                const selectedValue = event.target.value;
                if (selectedValue) {
                    // Show template fields
                    document.getElementById('templateFields').classList.remove('d-none');
                } else {
                    // Hide template fields
                    document.getElementById('templateFields').classList.add('d-none');
                }
            });
        }
    }

    // Initialize tools select
    function initializeToolsSelect() {
        const toolsSelect = document.getElementById('toolsSelect');
        if (toolsSelect && !toolsSelect.choicesInstance && !toolsSelect.hasAttribute('disabled')) {
            toolsSelectInstance = new Choices('#toolsSelect', {
                addItems: true,
                allowHtml:true,
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Add tools (e.g., Photoshop, Excel)',
            });

            // Set initial values if requirements exist
            const initialRequirements = {{ json_encode($requirements) }};
            if (initialRequirements && Array.isArray(initialRequirements)) {
                initialRequirements.forEach(function(item) {
                    toolsSelectInstance.setChoiceByValue(item);
                });
            }

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
    }

    // Show template fields if template is already selected
    function showTemplateFieldsIfNeeded() {
        const templateSelect = document.getElementById('templateSelect');
        if (templateSelect && templateSelect.value) {
            document.getElementById('templateFields').classList.remove('d-none');
        }
    }

    // Initialize on page load
    document.addEventListener('livewire:init', function() {
        initializeTemplateSelect();
        initializeToolsSelect();
        showTemplateFieldsIfNeeded();
    });

    // Re-initialize when Livewire updates
    document.addEventListener('livewire:updated', function() {
        initializeTemplateSelect();
        initializeToolsSelect();
        showTemplateFieldsIfNeeded();
    });
</script>
@endpush
@push('styles')
<link href="{{ asset('frontend/css/choices.min.css') }}" rel="stylesheet" />
@endpush