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
            @if(Session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ Session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(Session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ Session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="boostersTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab">
                        <i class="bi bi-cart-plus me-2"></i> Buy Boosters
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="subscribed-tab" data-bs-toggle="tab" data-bs-target="#subscribed" type="button" role="tab">
                        <i class="bi bi-lightning-charge me-2"></i> Active Boosters
                    </button>
                </li>

            </ul>

            <!-- Tab Content -->
            <div wire:ignore class="tab-content" id="boostersTabsContent">
                <!-- Buy Boosters Tab -->
                <div class="tab-pane fade show active" id="buy" role="tabpanel">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h4 class="section-title">Available Boosters</h4>
                            <p class="text-muted">Select the features you need and choose your preferred duration</p>
                        </div>

                        @forelse($boosters as $booster)
                        <div wire:ignore.self class="col-lg-4 mb-4">
                            <div class="booster-card card h-100">
                                <div class="booster-header text-center">
                                    <div class="booster-icon bg-primary-subtle text-primary mx-auto">
                                        <i class="bi {{ $booster['icon'] }}"></i>
                                    </div>
                                    <h5>{{ $booster['name'] }}</h5>
                                    <p class="text-muted small">{{ $booster['description'] }}</p>
                                </div>
                                <div class="card-body">
                                    @if($booster['max_multiplier'] > 1)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Multiplier</label>
                                        <input type="number" wire:model.live="multipliers.{{ $booster['id'] }}" wire:change="updateMultiplier({{ $booster['id'] }}, $event.target.value)" min="1" max="{{ $booster['max_multiplier'] }}" value="1" class="form-control" />
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <select class="form-control" wire:model.live="durations.{{ $booster['id'] }}" wire:change="updateDuration({{ $booster['id'] }}, $event.target.value)">
                                            @foreach($booster['duration_options'] as $days)
                                            <option value="{{ $days }}">{{ $days }} days</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">${{ number_format($this->getPrice($booster['id']), 2) }}</h3>
                                        <small class="text-muted">One-time payment</small>
                                    </div>

                                    <button class="btn btn-primary w-100" data-bs-target="#buyModal" data-bs-toggle="modal" wire:click="buyNow({{ $booster['id'] }})">Buy Now</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="bi bi-lightning-charge display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">No boosters available</h5>
                                    <p class="text-muted">No boosters are currently available for purchase.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- subscribed Boosters Tab -->
                <div class="tab-pane fade" id="subscribed" role="tabpanel">
                    @php
                    $boosterSubscriptions = [];
                    foreach($activeSubscriptions as $sub) {
                        $boosterId = $sub->booster_id;
                        if (!isset($boosterSubscriptions[$boosterId])) {
                            $boosterSubscriptions[$boosterId] = [
                                'booster' => $sub->booster,
                                'subscriptions' => []
                            ];
                        }
                        $boosterSubscriptions[$boosterId]['subscriptions'][] = $sub;
                    }
                    $activeBoostersCount = count($boosterSubscriptions);
                    $expiringSoonCount = 0;
                    $totalSpent = 0;
                    foreach($activeSubscriptions as $sub) {
                        $totalSpent += $sub->cost;
                        if ($sub->expires_at->diffInDays(now()) <= 7) {
                            $expiringSoonCount++;
                        }
                    }
                    @endphp
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-primary">{{ $activeBoostersCount }}</h3>
                                    <p class="mb-0">Active Boosters</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-warning">{{ $expiringSoonCount }}</h3>
                                    <p class="mb-0">Expiring Soon</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-success">${{ number_format($totalSpent, 2) }}</h3>
                                    <p class="mb-0">Total Spent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <h4 class="section-title">Your Active Boosters</h4>
                        </div>

                        @forelse($boosterSubscriptions as $boosterData)
                        @php
                        $icon = 'bi-lightning-charge';
                        switch ($boosterData['booster']->slug) {
                            case 'task-limit-booster':
                                $icon = 'bi-briefcase';
                                break;
                            case 'submission-speed-booster':
                                $icon = 'bi-speedometer2';
                                break;
                            case 'feature-all-tasks':
                                $icon = 'bi-star';
                                break;
                            case 'broadcast-all-tasks':
                                $icon = 'bi-broadcast';
                                break;
                            case 'withdrawal-limit-booster':
                                $icon = 'bi-arrow-up-circle';
                                break;
                            case 'referral-earnings-booster':
                                $icon = 'bi-people';
                                break;
                            case 'premium-support':
                                $icon = 'bi-headset';
                                break;
                            case 'task-analytics-plus':
                                $icon = 'bi-bar-chart';
                                break;
                            case 'task-volume-booster':
                                $icon = 'bi-stack';
                                break;
                        }
                        @endphp
                        <div class="col-lg-6 mb-4">
                            <div class="booster-card card active-booster">
                                <div class="booster-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="booster-icon bg-primary-subtle text-primary">
                                                <i class="bi {{ $icon }}"></i>
                                            </div>
                                            <h5 class="mb-1">{{ $boosterData['booster']->name }}</h5>
                                            <p class="text-muted mb-0">{{ $boosterData['booster']->description }}</p>
                                        </div>
                                        <span class="feature-badge">Active</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($boosterData['subscriptions'] as $subscription)
                                    <div class="mb-3">
                                        @if($subscription->multiplier > 1)
                                        <div class="d-flex justify-content-between">
                                            <span>Multiplier: {{ $subscription->multiplier }}</span>
                                        </div>
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            <span>Validity: {{ $subscription->starts_at->format('M d, Y') }} - {{ $subscription->expires_at->format('M d, Y') }}</span>
                                            <span>Expires in {{ $subscription->expires_at->diffInDays(now()) }} days</span>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="mt-3">
                                        <button class="btn btn-outline-primary btn-sm" wire:click="extend({{ $boosterData['booster']->id }})">Extend</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="bi bi-lightning-charge display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">No active boosters</h5>
                                    <p class="text-muted">You don't have any active or future boosters.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>


            </div>
        </div>
    </section>

    <div wire:ignore.self id="buyModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ri-vip-crown-line me-2"></i>@if($isExtending) Extend @else Buy @endif @if($selectedBooster) {{ $selectedBooster['name'] }} @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                @if($selectedBooster)
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Booster Details
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <span class="display-6 fw-bold text-primary">
                                            ${{ number_format($selectedBooster['base_price'], 2) }}
                                        </span>
                                        <span class="text-muted">/month</span>
                                    </div>

                                    @if($isExtending)
                                    <h6 class="fw-semibold mb-3">Configure Extension:</h6>
                                    @if($selectedBooster['max_multiplier'] > 1)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Multiplier</label>
                                        <input type="number" wire:model.live="selectedMultiplier" min="1" max="{{ $selectedBooster['max_multiplier'] }}" value="{{ $selectedMultiplier }}" class="form-control" />
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Duration</label>
                                        <select class="form-control" wire:model.live="selectedDuration">
                                            @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $selectedBooster['minimum_duration_days'] * $i }}">{{ $selectedBooster['minimum_duration_days'] * $i }} days</option>
                                            @endfor
                                        </select>
                                    </div>
                                    @else
                                    <h6 class="fw-semibold mb-3">Selected Options:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="ri-check-line text-success me-2"></i>
                                            <span class="small">Multiplier: {{ $selectedMultiplier }}</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line text-success me-2"></i>
                                            <span class="small">Duration: {{ $selectedDuration }} days</span>
                                        </li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-settings-line me-2"></i>Payment Options
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Payment Method</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="radio"
                                                    wire:model="paymentMethod"
                                                    value="wallet"
                                                    class="form-check-input"
                                                    id="payment_wallet"
                                                    @if($walletBalance < $totalAmount) disabled @endif />
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
                                                    Pay with Card/Bank
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @if($paymentMethod === 'wallet' && $walletBalance < $totalAmount)
                                        <div class="alert alert-warning" role="alert">
                                            <i class="ri-error-warning-line me-2"></i> Insufficient wallet balance for this purchase.
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
                                    @if($paymentMethod==='wallet' && $walletBalance < $totalAmount) disabled @endif>
                                    <i class="ri-check-line me-1"></i>
                                    Buy & Pay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>

</div>

</div>