<div>
    @if($walletsAreFrozen)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>
        <strong>Wallet Operations Disabled:</strong> {{ $frozenReason }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">Earnings & Withdrawals</h1>
                    <p class="mb-0">Manage your earnings, exchange currencies, and withdraw funds</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="tasks.html" class="btn btn-outline-light">Browse Tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="earningsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="earnings-tab" data-bs-toggle="tab" data-bs-target="#earnings" type="button" role="tab">
                        <i class="bi bi-wallet2 me-2"></i> Earnings
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="exchanges-tab" data-bs-toggle="tab" data-bs-target="#exchanges" type="button" role="tab">
                        <i class="bi bi-arrow-left-right me-2"></i> Exchanges
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="withdrawals-tab" data-bs-toggle="tab" data-bs-target="#withdrawals" type="button" role="tab">
                        <i class="bi bi-cash-coin me-2"></i> Withdrawals
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="earningsTabsContent">
                <!-- Earnings Tab -->
                <div class="tab-pane fade show active" id="earnings" role="tabpanel">
                    <div class="row mb-4">
                        @if($homeWallet)
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card card balance-card text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">Main Balance @if($homeWallet->is_frozen) <i class="bi bi-snow text-warning"></i> @endif</h6>
                                            <h3 class="mb-0">{{ $toCurrencySymbol }}{{ number_format($homeWallet->balance, 2) }}</h3>
                                        </div>
                                        <i class="bi bi-wallet2 fs-4 opacity-75"></i>
                                    </div>
                                    <p class="mb-0 small mt-2">Available for withdrawal or exchange</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @foreach($otherWallets as $wallet)
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card card currency-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">{{ $wallet->currency }} Balance @if($wallet->is_frozen) <i class="bi bi-snow text-warning"></i> @endif</h6>
                                            <h3 class="mb-0">{{ number_format($wallet->balance, 2) }}</h3>
                                        </div>
                                        <span class="badge bg-primary">{{ $wallet->currency }}</span>
                                    </div>
                                    <p class="mb-0 text-muted small mt-2">{{ $wallet->currency }} Balance</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="card form-card">
                        <div class="card-header bg-transparent">
                            <h5 class="section-title mb-0">Earning History</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Source</th>
                                            <th>Description</th>
                                            <th>Currency</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($settlements as $settlement)
                                        <tr>
                                            <td>
                                                @if ($settlement->settlementable_type === 'App\\Models\\TaskSubmission')
                                                <span class="badge bg-primary">Task Submission</span>
                                                @elseif ($settlement->settlementable_type === 'App\\Models\\Referral')
                                                <span class="badge bg-info">Task Invitation</span>
                                                @elseif($settlement->settlementable_type === 'App\\Models\\Invitation')
                                                <span class="badge bg-success">Referral</span>
                                                @else
                                                <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                
                                                <div class="fw-medium">{{ $settlement->description }}</div>
                                                
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $settlement->currency }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">{{ number_format($settlement->amount, 2) }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $settlement->created_at->format('M d, Y H:i') }}</small>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="ri-money-dollar-circle-line display-4 mb-2"></i>
                                                <p>No settlements found</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted small">
                                    Showing <span class="fw-semibold">{{ $settlements->firstItem() }}</span> to <span class="fw-semibold">{{ $settlements->lastItem() }}</span> of <span class="fw-semibold">{{ $settlements->total() }}</span> results
                                </div>
                                <div>
                                    {{ $settlements->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exchanges Tab -->
                <div class="tab-pane fade" id="exchanges" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card form-card mb-4">
                                <div class="card-header bg-transparent">
                                    <h5 class="section-title mb-0">Exchange Funds</h5>
                                </div>
                                <div class="card-body">
                                    <div class="exchange-rate">
                                        <h6 class="mb-2">USD Exchange Rate</h6>
                                        <div class="small">
                                            @if($exchangeRate)
                                                <span>{{$exchangeRate }}</span>
                                            @else
                                                <span>Not Available</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <form wire:submit.prevent="executeExchange">
                                        <div class="mb-3">
                                            <label for="fromCurrency" class="form-label">From Currency</label>
                                            <select class="form-select" wire:model="fromCurrency" id="fromCurrency" required>
                                                <option value="">Select currency</option>
                                                @foreach($wallets->where('is_frozen', false)->where('currency', '!=', Auth::user()->currency) as $wallet)
                                                <option value="{{ $wallet->currency }}">{{ $wallet->currency }} ({{ number_format($wallet->balance, 2) }})</option>
                                                @endforeach
                                            </select>
                                            @error('fromCurrency') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="toCurrency" class="form-label">To Currency</label>
                                            <select class="form-select" wire:model.live="toCurrency" id="toCurrency" required disabled>
                                                <option value="{{ Auth::user()->currency }}">{{ Auth::user()->currency }}</option>
                                            </select>
                                            @error('toCurrency') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Amount to Exchange</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $fromCurrency ?: 'Currency' }}</span>
                                                <input type="number" class="form-control" wire:model.live="amount" id="amount" placeholder="0.00" min="0.01" step="0.01" required>
                                            </div>
                                            @error('amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        @if($targetAmount > 0)
                                        <div class="mb-3">
                                            <label class="form-label">You Will Receive</label>
                                            <div class="alert alert-success">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span>Exchange Rate:</span>
                                                    <span class="fw-semibold">1 {{ $fromCurrency }} ≈ {{ number_format($exchangeRate, 4) }} {{ $toCurrency }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>You will receive:</span>
                                                    <span class="text-success">{{ number_format($targetAmount, 2) }} {{ $toCurrency }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <button type="submit" class="btn btn-primary w-100" @if($targetAmount <= 0 || $exchangeDisabled) disabled @endif>Exchange Funds</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-7">
                            <div class="card form-card">
                                <div class="card-header bg-transparent">
                                    <h5 class="section-title mb-0">Exchange History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Reference</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Rate</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($exchanges as $exchange)
                                                <tr>
                                                    <td>
                                                        <span class="fw-semibold">{{ $exchange->reference }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold">{{ number_format($exchange->base_amount, 2) }}</div>
                                                        <small class="text-muted">{{ $exchange->base_currency }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold">{{ number_format($exchange->target_amount, 2) }}</div>
                                                        <small class="text-muted">{{ $exchange->target_currency }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold">{{ number_format($exchange->exchange_rate, 4) }}</span>
                                                    </td>
                                                    <td>
                                                        @if($exchange->status === 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                        @elseif($exchange->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @elseif($exchange->status === 'failed')
                                                        <span class="badge bg-danger">Failed</span>
                                                        @else
                                                        <span class="badge bg-secondary">{{ ucfirst($exchange->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $exchange->created_at->format('M d, Y H:i') }}</small>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        <i class="ri-exchange-dollar-line display-4 mb-2"></i>
                                                        <p>No exchanges found</p>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div class="text-muted small">
                                            Showing <span class="fw-semibold">{{ $exchanges->firstItem() }}</span> to <span class="fw-semibold">{{ $exchanges->lastItem() }}</span> of <span class="fw-semibold">{{ $exchanges->total() }}</span> results
                                        </div>
                                        <div>
                                            {{ $exchanges->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Withdrawals Tab -->
                <div class="tab-pane fade" id="withdrawals" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-success">{{ $toCurrencySymbol }}{{ number_format($totalWithdrawn, 2) }}</h3>
                                    <p class="mb-0">Total Withdrawn</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-warning">{{ $toCurrencySymbol }}{{ number_format($pendingWithdrawals, 2) }}</h3>
                                    <p class="mb-0">Pending Requests</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-danger">{{ $toCurrencySymbol }}{{ number_format($rejectedWithdrawals, 2) }}</h3>
                                    <p class="mb-0">Rejected Requests</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card form-card mb-4">
                                <div class="card-header bg-transparent">
                                    <h5 class="section-title mb-0">Request Withdrawal</h5>
                                </div>
                                <div class="card-body">
                                    <form wire:submit.prevent="submitWithdrawal">
                                        
                                        <div class="mb-3">
                                            <label for="withdrawAmount" class="form-label">Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $toCurrency ?: 'Currency' }}</span>
                                                <input type="number" class="form-control" wire:model.live="withdrawAmount" id="withdrawAmount" placeholder="0.00" min="{{ $minWithdrawal }}" step="0.01" required>
                                            </div>
                                            @error('withdrawAmount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                            <div class="form-text">Minimum withdrawal: {{ number_format($minWithdrawal, 2) }}</div>
                                        </div>

                                        <div class="alert alert-info">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Available Balance:</span>
                                                <span class="fw-semibold">{{ number_format($availableBalance, 2) }} {{ $toCurrency }}</span>
                                            </div>

                                            @if($withdrawAmount > 0 && !$errors->has('withdrawAmount'))
                                            <hr>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Withdrawal Fee:</span>
                                                <span class="text-danger">{{ number_format($withdrawalFee, 2) }} {{ $toCurrency }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>You will receive:</span>
                                                <span class="text-primary">{{ number_format($netAmount, 2) }} {{ $toCurrency }}</span>
                                            </div>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100" @if($withdrawalDisabled) disabled @endif>Request Withdrawal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-7">
                            <div class="card form-card">
                                <div class="card-header bg-transparent">
                                    <h5 class="section-title mb-0">Withdrawal History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Reference</th>
                                                    <th>Currency</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($withdrawals as $withdrawal)
                                                <tr>
                                                    <td>
                                                        <span class="fw-semibold">{{ $withdrawal->reference }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold">{{ $withdrawal->currency }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-primary">{{ number_format($withdrawal->amount, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        @if($withdrawal->status === 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                        @elseif($withdrawal->status === 'approved')
                                                        <span class="badge bg-info">Approved</span>
                                                        @elseif($withdrawal->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @elseif($withdrawal->status === 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                        @else
                                                        <span class="badge bg-secondary">{{ ucfirst($withdrawal->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $withdrawal->created_at->format('M d, Y H:i') }}</small>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        <i class="ri-bank-card-line display-4 mb-2"></i>
                                                        <p>No withdrawals found</p>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div class="text-muted small">
                                            Showing <span class="fw-semibold">{{ $withdrawals->firstItem() }}</span> to <span class="fw-semibold">{{ $withdrawals->lastItem() }}</span> of <span class="fw-semibold">{{ $withdrawals->total() }}</span> results
                                        </div>
                                        <div>
                                            {{ $withdrawals->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>