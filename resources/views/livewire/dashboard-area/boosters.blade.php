<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">Account Boosters</h1>
                    <p class="mb-0">Enhance your experience with temporary account features</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="earnings.html" class="btn btn-outline-light">Earnings</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="boostersTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                        <i class="bi bi-lightning-charge me-2"></i> Active Boosters
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab">
                        <i class="bi bi-cart-plus me-2"></i> Buy Boosters
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="boostersTabsContent">
                <!-- Active Boosters Tab -->
                <div class="tab-pane fade show active" id="active" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-primary">3</h3>
                                    <p class="mb-0">Active Boosters</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-warning">2</h3>
                                    <p class="mb-0">Expiring Soon</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-success">$45.00</h3>
                                    <p class="mb-0">Total Spent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <h4 class="section-title">Your Active Boosters</h4>
                        </div>

                        <!-- Active Booster 1 -->
                        <div class="col-lg-6 mb-4">
                            <div class="booster-card card active-booster">
                                <div class="booster-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="booster-icon bg-primary-subtle text-primary">
                                                <i class="bi bi-briefcase"></i>
                                            </div>
                                            <h5 class="mb-1">Task Application Booster</h5>
                                            <p class="text-muted mb-0">Apply for more tasks per month</p>
                                        </div>
                                        <span class="feature-badge">Active</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Applications: 15/20 used</span>
                                            <span>75%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">Expires in</small>
                                            <div class="fw-bold text-success">12 days</div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">Valid until</small>
                                            <div class="fw-bold">Dec 15, 2023</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-outline-primary btn-sm me-2">Extend</button>
                                        <button class="btn btn-outline-secondary btn-sm">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Booster 2 -->
                        <div class="col-lg-6 mb-4">
                            <div class="booster-card card expiring-soon">
                                <div class="booster-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="booster-icon bg-warning-subtle text-warning">
                                                <i class="bi bi-star"></i>
                                            </div>
                                            <h5 class="mb-1">Featured Task Promoter</h5>
                                            <p class="text-muted mb-0">Highlight your tasks</p>
                                        </div>
                                        <span class="feature-badge" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">Expiring Soon</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Featured Tasks: 2/3 used</span>
                                            <span>67%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 67%"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">Expires in</small>
                                            <div class="fw-bold text-warning">3 days</div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">Valid until</small>
                                            <div class="fw-bold">Dec 6, 2023</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-outline-primary btn-sm me-2">Extend</button>
                                        <button class="btn btn-outline-secondary btn-sm">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Booster 3 -->
                        <div class="col-lg-6 mb-4">
                            <div class="booster-card card active-booster">
                                <div class="booster-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="booster-icon bg-success-subtle text-success">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </div>
                                            <h5 class="mb-1">Withdrawal Limit Booster</h5>
                                            <p class="text-muted mb-0">Higher withdrawal limits</p>
                                        </div>
                                        <span class="feature-badge">Active</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Withdrawals: $450/$1000 used</span>
                                            <span>45%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 45%"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">Expires in</small>
                                            <div class="fw-bold text-success">25 days</div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">Valid until</small>
                                            <div class="fw-bold">Dec 28, 2023</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-outline-primary btn-sm me-2">Extend</button>
                                        <button class="btn btn-outline-secondary btn-sm">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expired Booster -->
                        <div class="col-lg-6 mb-4">
                            <div class="booster-card card expired">
                                <div class="booster-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="booster-icon bg-secondary-subtle text-secondary">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                            <h5 class="mb-1">Priority Support Access</h5>
                                            <p class="text-muted mb-0">Faster customer support</p>
                                        </div>
                                        <span class="feature-badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d;">Expired</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p class="text-muted mb-0">This booster has expired. Renew to continue enjoying priority support.</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">Expired on</small>
                                            <div class="fw-bold text-danger">Nov 20, 2023</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-sm me-2">Renew Now</button>
                                        <button class="btn btn-outline-secondary btn-sm">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buy Boosters Tab -->
                <div class="tab-pane fade" id="buy" role="tabpanel">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h4 class="section-title">Available Boosters</h4>
                            <p class="text-muted">Select the features you need and choose your preferred duration</p>
                        </div>

                        <!-- Booster 1 -->
                        <div class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-primary-subtle text-primary mx-auto">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <h5>Task Application Booster</h5>
                                    <p class="text-muted small">Increase your monthly task application limit</p>
                                </div>
                                <div class="card-body">
                                    <ul class="booster-features">
                                        <li><i class="bi bi-check text-success me-2"></i> Apply for 20 tasks/month (normally 10)</li>
                                        <li><i class="bi bi-check text-success me-2"></i> No additional application fees</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Priority in task matching</li>
                                    </ul>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <div class="period-selector">
                                            <button type="button" class="period-option active" data-duration="30" data-price="9.99">1 Month</button>
                                            <button type="button" class="period-option" data-duration="90" data-price="24.99">3 Months</button>
                                            <button type="button" class="period-option" data-duration="180" data-price="44.99">6 Months</button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">$9.99</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>
                                    
                                    <button class="btn btn-primary w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Booster 2 -->
                        <div class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-warning-subtle text-warning mx-auto">
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <h5>Featured Task Promoter</h5>
                                    <p class="text-muted small">Highlight your tasks to get more applicants</p>
                                </div>
                                <div class="card-body">
                                    <ul class="booster-features">
                                        <li><i class="bi bi-check text-success me-2"></i> 3 featured task slots</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Top placement in search results</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Special "Featured" badge</li>
                                    </ul>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <div class="period-selector">
                                            <button type="button" class="period-option active" data-duration="30" data-price="14.99">1 Month</button>
                                            <button type="button" class="period-option" data-duration="90" data-price="39.99">3 Months</button>
                                            <button type="button" class="period-option" data-duration="180" data-price="69.99">6 Months</button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">$14.99</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>
                                    
                                    <button class="btn btn-primary w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Booster 3 -->
                        <div class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-success-subtle text-success mx-auto">
                                        <i class="bi bi-arrow-up-circle"></i>
                                    </div>
                                    <h5>Withdrawal Limit Booster</h5>
                                    <p class="text-muted small">Increase your withdrawal limits</p>
                                </div>
                                <div class="card-body">
                                    <ul class="booster-features">
                                        <li><i class="bi bi-check text-success me-2"></i> $1000 monthly withdrawal limit (normally $500)</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Faster withdrawal processing</li>
                                        <li><i class="bi bi-check text-success me-2"></i> No additional withdrawal fees</li>
                                    </ul>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <div class="period-selector">
                                            <button type="button" class="period-option active" data-duration="30" data-price="7.99">1 Month</button>
                                            <button type="button" class="period-option" data-duration="90" data-price="19.99">3 Months</button>
                                            <button type="button" class="period-option" data-duration="180" data-price="34.99">6 Months</button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">$7.99</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>
                                    
                                    <button class="btn btn-primary w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Booster 4 -->
                        <div class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-info-subtle text-info mx-auto">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <h5>Profile Visibility Booster</h5>
                                    <p class="text-muted small">Get noticed by more task posters</p>
                                </div>
                                <div class="card-body">
                                    <ul class="booster-features">
                                        <li><i class="bi bi-check text-success me-2"></i> Top placement in worker search</li>
                                        <li><i class="bi bi-check text-success me-2"></i> "Featured Worker" badge</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Priority in task invitations</li>
                                    </ul>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <div class="period-selector">
                                            <button type="button" class="period-option active" data-duration="30" data-price="12.99">1 Month</button>
                                            <button type="button" class="period-option" data-duration="90" data-price="32.99">3 Months</button>
                                            <button type="button" class="period-option" data-duration="180" data-price="59.99">6 Months</button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">$12.99</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>
                                    
                                    <button class="btn btn-primary w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Booster 5 -->
                        <div class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-danger-subtle text-danger mx-auto">
                                        <i class="bi bi-lightning-charge"></i>
                                    </div>
                                    <h5>Urgent Task Badge</h5>
                                    <p class="text-muted small">Mark your tasks as urgent</p>
                                </div>
                                <div class="card-body">
                                    <ul class="booster-features">
                                        <li><i class="bi bi-check text-success me-2"></i> "Urgent" badge on your tasks</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Email notifications to workers</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Priority in task listings</li>
                                    </ul>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <div class="period-selector">
                                            <button type="button" class="period-option active" data-duration="30" data-price="4.99">1 Month</button>
                                            <button type="button" class="period-option" data-duration="90" data-price="12.99">3 Months</button>
                                            <button type="button" class="period-option" data-duration="180" data-price="22.99">6 Months</button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">$4.99</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>
                                    
                                    <button class="btn btn-primary w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>

                        <!-- Booster 6 -->
                        <div class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-secondary-subtle text-secondary mx-auto">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <h5>Priority Support Access</h5>
                                    <p class="text-muted small">Get faster customer support</p>
                                </div>
                                <div class="card-body">
                                    <ul class="booster-features">
                                        <li><i class="bi bi-check text-success me-2"></i> 24/7 priority email support</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Average response time: 2 hours</li>
                                        <li><i class="bi bi-check text-success me-2"></i> Dedicated support agent</li>
                                    </ul>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <div class="period-selector">
                                            <button type="button" class="period-option active" data-duration="30" data-price="19.99">1 Month</button>
                                            <button type="button" class="period-option" data-duration="90" data-price="49.99">3 Months</button>
                                            <button type="button" class="period-option" data-duration="180" data-price="89.99">6 Months</button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">$19.99</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>
                                    
                                    <button class="btn btn-primary w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

{{--  
<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">Subscription Plans</h1>
                <p class="text-muted mb-0">Choose the perfect plan for your needs</p>
            </div>
        </div>
    </div>

    <!-- Plan Type Toggle -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group">
                    <button wire:click="switchType('worker')" 
                            type="button" 
                            class="btn {{ $selectedType === 'worker' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="ri-user-line me-2"></i>Worker Plans
                    </button>
                    <button wire:click="switchType('taskmaster')" 
                            type="button" 
                            class="btn {{ $selectedType === 'taskmaster' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="ri-briefcase-line me-2"></i>Taskmaster Plans
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Grid -->
    <div class="row g-4">
        @forelse($filteredPlans as $plan)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 {{ $plan['type'] === 'worker' ? 'border-primary' : 'border-success' }} position-relative">
                @if(in_array($plan['id'], $activeSubscriptionPlanIds))
                    <div class="position-absolute top-0 start-0 w-100">
                        <div class="badge bg-success rounded-0 rounded-top-start">
                            <i class="ri-check-line me-1"></i>Active Subscription
                        </div>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <div class="text-center mb-4">
                        <h5 class="card-title mb-2">{{ $plan['name'] }}</h5>
                        <p class="text-muted mb-3">{{ $plan['description'] }}</p>
                        
                        <div class="mb-3">
                            <span class="display-6 fw-bold text-primary">
                                {{ auth()->user()->country->currency_symbol }}{{ number_format($plan['monthly_price'], 2) }}
                            </span>
                            <span class="text-muted">/month</span>
                        </div>
                    </div>

                    <div class="mb-4 flex-grow-1">
                        <h6 class="fw-semibold mb-3">Features:</h6>
                        <ul class="list-unstyled">
                            @foreach($plan['features'] as $feature)
                                <li class="mb-2">
                                    <i class="ri-check-line text-success me-2"></i>
                                    <span class="small">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-auto">
                        <button wire:click="choosePlan('{{ $plan['slug'] }}')" 
                                class="btn btn-primary w-100">
                            <i class="ri-{{ in_array($plan['id'], $activeSubscriptionPlanIds) ? 'refresh' : 'add' }}-line me-1"></i>
                            {{ in_array($plan['id'], $activeSubscriptionPlanIds) ? 'Extend Subscription' : 'Choose Plan' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ri-inbox-line display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No plans available</h5>
                    <p class="text-muted">No subscription plans are currently available for this type.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Subscription Modal -->
    @if($showModal && $selectedPlan)
    <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ri-vip-crown-line me-2"></i>Subscribe to {{ $selectedPlan['name'] }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Plan Details
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <span class="display-6 fw-bold text-primary">
                                            {{ auth()->user()->country->currency_symbol }}{{ number_format($selectedPlan['monthly_price'], 2) }}
                                        </span>
                                        <span class="text-muted">/month</span>
                                    </div>
                                    
                                    <h6 class="fw-semibold mb-3">Features:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($selectedPlan['features'] as $feature)
                                            <li class="mb-2">
                                                <i class="ri-check-line text-success me-2"></i>
                                                <span class="small">{{ $feature }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-settings-line me-2"></i>Subscription Options
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Duration (months)</label>
                                        <input type="number" 
                                               min="1" 
                                               max="24" 
                                               wire:model.live="selectedDuration" 
                                               id="duration" 
                                               class="form-control" />
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Payment Method</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="radio"
                                                       wire:model="paymentMethod"
                                                       value="wallet"
                                                       class="form-check-input"
                                                       id="payment_wallet"
                                                       @if($walletBalance < $totalAmount) disabled @endif
                                                />
                                                <label class="form-check-label" for="payment_wallet">
                                                    <i class="ri-wallet-line me-2"></i>
                                                    Wallet ({{ auth()->user()->country->currency_symbol }} {{ number_format($walletBalance, 2) }})
                                                    @if($walletBalance < $totalAmount)
                                                        <span class="badge bg-danger ms-1">Insufficient balance</span>
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" 
                                                       wire:model="paymentMethod" 
                                                       value="gateway" 
                                                       class="form-check-input" 
                                                       id="payment_gateway" />
                                                <label class="form-check-label" for="payment_gateway">
                                                    <i class="ri-bank-card-line me-2"></i>
                                                    Pay with Card/Bank (Gateway)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($paymentMethod === 'wallet' && $walletBalance < $totalAmount)
                                        <div class="alert alert-warning" role="alert">
                                            <i class="ri-error-warning-line me-2"></i>
                                            Insufficient wallet balance for this subscription.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="ri-calculator-line me-2"></i>Payment Summary
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>{{ auth()->user()->country->currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax ({{ $tax_rate }}%):</span>
                                        <span>{{ auth()->user()->country->currency_symbol }} {{ number_format($tax, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span class="text-primary">{{ auth()->user()->country->currency_symbol }} {{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <button wire:click="subscribe"
                                            class="btn btn-primary w-100"
                                            @if($paymentMethod === 'wallet' && $walletBalance < $totalAmount) disabled @endif>
                                        <i class="ri-check-line me-1"></i>
                                        Subscribe & Pay
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
</style>
@endpush
--}}