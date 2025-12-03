<div>
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
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card card balance-card text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">Total Balance</h6>
                                            <h3 class="mb-0">$1,247.50</h3>
                                        </div>
                                        <i class="bi bi-wallet2 fs-4 opacity-75"></i>
                                    </div>
                                    <p class="mb-0 small mt-2">Available for withdrawal or exchange</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card card currency-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">USD Balance</h6>
                                            <h3 class="mb-0">$847.50</h3>
                                        </div>
                                        <span class="badge bg-primary">USD</span>
                                    </div>
                                    <p class="mb-0 text-muted small mt-2">US Dollar</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card card currency-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">EUR Balance</h6>
                                            <h3 class="mb-0">€320.25</h3>
                                        </div>
                                        <span class="badge bg-success">EUR</span>
                                    </div>
                                    <p class="mb-0 text-muted small mt-2">Euro</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card card currency-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title">GBP Balance</h6>
                                            <h3 class="mb-0">£79.75</h3>
                                        </div>
                                        <span class="badge bg-info">GBP</span>
                                    </div>
                                    <p class="mb-0 text-muted small mt-2">British Pound</p>
                                </div>
                            </div>
                        </div>
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
                                            <th>Date</th>
                                            <th>Task</th>
                                            <th>Amount</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2023-11-15</td>
                                            <td>Social Media Graphics</td>
                                            <td>$45.00</td>
                                            <td>USD</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2023-11-12</td>
                                            <td>Blog Article Writing</td>
                                            <td>$60.00</td>
                                            <td>USD</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2023-11-10</td>
                                            <td>Data Entry Project</td>
                                            <td>€85.50</td>
                                            <td>EUR</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2023-11-08</td>
                                            <td>Logo Design</td>
                                            <td>£75.00</td>
                                            <td>GBP</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2023-11-05</td>
                                            <td>Website Development</td>
                                            <td>$120.00</td>
                                            <td>USD</td>
                                            <td><span class="status-badge status-warning">Pending</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <nav aria-label="Earnings pagination">
                                <ul class="pagination justify-content-center mt-4">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
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
                                        <h6 class="mb-2">Current Exchange Rates</h6>
                                        <div class="d-flex justify-content-between small">
                                            <span>1 USD = 0.92 EUR</span>
                                            <span>1 USD = 0.79 GBP</span>
                                            <span>1 EUR = 0.86 GBP</span>
                                        </div>
                                    </div>
                                    
                                    <form id="exchangeForm">
                                        <div class="mb-3">
                                            <label class="form-label">From Currency</label>
                                            <div class="row g-2">
                                                <div class="col-4">
                                                    <div class="wallet-card text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="fromCurrency" id="fromUSD" value="USD" checked>
                                                            <label class="form-check-label fw-bold" for="fromUSD">
                                                                USD
                                                            </label>
                                                        </div>
                                                        <div class="mt-2">$847.50</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="wallet-card text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="fromCurrency" id="fromEUR" value="EUR">
                                                            <label class="form-check-label fw-bold" for="fromEUR">
                                                                EUR
                                                            </label>
                                                        </div>
                                                        <div class="mt-2">€320.25</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="wallet-card text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="fromCurrency" id="fromGBP" value="GBP">
                                                            <label class="form-check-label fw-bold" for="fromGBP">
                                                                GBP
                                                            </label>
                                                        </div>
                                                        <div class="mt-2">£79.75</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">To Currency</label>
                                            <div class="row g-2">
                                                <div class="col-4">
                                                    <div class="wallet-card text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="toCurrency" id="toUSD" value="USD">
                                                            <label class="form-check-label fw-bold" for="toUSD">
                                                                USD
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="wallet-card text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="toCurrency" id="toEUR" value="EUR" checked>
                                                            <label class="form-check-label fw-bold" for="toEUR">
                                                                EUR
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="wallet-card text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="toCurrency" id="toGBP" value="GBP">
                                                            <label class="form-check-label fw-bold" for="toGBP">
                                                                GBP
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Amount to Exchange</label>
                                            <input type="number" class="form-control" placeholder="0.00" min="1" step="0.01" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">You Will Receive</label>
                                            <div class="alert alert-info">
                                                <div class="d-flex justify-content-between">
                                                    <span>Estimated Amount:</span>
                                                    <strong id="estimatedAmount">€0.00</strong>
                                                </div>
                                                <small class="text-muted">Exchange fee: 1%</small>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary w-100">Exchange Funds</button>
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
                                                    <th>Date</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Amount</th>
                                                    <th>Received</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2023-11-10</td>
                                                    <td>$100.00 USD</td>
                                                    <td>€92.00 EUR</td>
                                                    <td>$100.00</td>
                                                    <td>€92.00</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>2023-11-05</td>
                                                    <td>€50.00 EUR</td>
                                                    <td>£43.00 GBP</td>
                                                    <td>€50.00</td>
                                                    <td>£43.00</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>2023-10-28</td>
                                                    <td>$75.00 USD</td>
                                                    <td>€69.00 EUR</td>
                                                    <td>$75.00</td>
                                                    <td>€69.00</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>2023-10-15</td>
                                                    <td>£30.00 GBP</td>
                                                    <td>$38.10 USD</td>
                                                    <td>£30.00</td>
                                                    <td>$38.10</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                    <h3 class="text-success">$2,450.00</h3>
                                    <p class="mb-0">Total Withdrawn</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-warning">$350.00</h3>
                                    <p class="mb-0">Pending Requests</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stats-card card">
                                <div class="card-body text-center">
                                    <h3 class="text-danger">$120.00</h3>
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
                                    <form id="withdrawalForm">
                                        <div class="mb-3">
                                            <label class="form-label">Withdrawal Method</label>
                                            <select class="form-select" required>
                                                <option value="">Select method</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="bank">Bank Transfer</option>
                                                <option value="skrill">Skrill</option>
                                                <option value="payoneer">Payoneer</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Currency</label>
                                            <select class="form-select" required>
                                                <option value="USD">US Dollar (USD)</option>
                                                <option value="EUR">Euro (EUR)</option>
                                                <option value="GBP">British Pound (GBP)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Amount</label>
                                            <input type="number" class="form-control" placeholder="0.00" min="10" step="0.01" required>
                                            <div class="form-text">Minimum withdrawal: $10.00</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Account Details</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter your account details..." required></textarea>
                                        </div>
                                        
                                        <div class="alert alert-info">
                                            <h6><i class="bi bi-info-circle"></i> Important Information</h6>
                                            <ul class="mb-0 small">
                                                <li>Withdrawals are processed within 3-5 business days</li>
                                                <li>A 2% processing fee applies to all withdrawals</li>
                                                <li>Minimum withdrawal amount is $10.00</li>
                                            </ul>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary w-100">Request Withdrawal</button>
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
                                                    <th>Date</th>
                                                    <th>Method</th>
                                                    <th>Amount</th>
                                                    <th>Currency</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2023-11-08</td>
                                                    <td>PayPal</td>
                                                    <td>$200.00</td>
                                                    <td>USD</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Details</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2023-11-01</td>
                                                    <td>Bank Transfer</td>
                                                    <td>€150.00</td>
                                                    <td>EUR</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Details</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2023-10-25</td>
                                                    <td>PayPal</td>
                                                    <td>$100.00</td>
                                                    <td>USD</td>
                                                    <td><span class="status-badge status-completed">Completed</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Details</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2023-10-15</td>
                                                    <td>Skrill</td>
                                                    <td>£75.00</td>
                                                    <td>GBP</td>
                                                    <td><span class="status-badge status-pending">Pending</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Details</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2023-10-10</td>
                                                    <td>Bank Transfer</td>
                                                    <td>$50.00</td>
                                                    <td>USD</td>
                                                    <td><span class="status-badge status-rejected">Rejected</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Details</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
    @if($walletsAreFrozen)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>
        <strong>Wallet Operations Disabled:</strong> {{ $frozenReason }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Header -->
<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h4 mb-0">
                @switch($activeTab)
                @case('withdrawals')
                Withdrawals
                @break
                @case('exchanges')
                Currency Exchanges
                @break
                @case('settlements')
                @default
                Earnings & Settlements
                @endswitch
            </h1>
            <p class="text-muted mb-0">
                @switch($activeTab)
                @case('withdrawals')
                Manage your withdrawal requests and track payment status
                @break
                @case('exchanges')
                View your currency exchange history and rates
                @break
                @case('settlements')
                @default
                Track your earnings from completed tasks and referrals
                @endswitch
            </p>
        </div>
    </div>
</div>

<!-- Wallet Cards -->
<div class="row g-3 mb-4">
    @foreach($wallets as $wallet)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-muted mb-1">{{ $wallet->currency }}</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($wallet->balance, 2) }}</h3>
                    </div>
                    <div class="d-flex gap-1">
                        @if($wallet->balance > 0)
                        @if($wallet->currency === Auth::user()->country->currency)
                        <button wire:click="openWithdrawModal('{{ $wallet->currency }}')"
                            class="btn btn-outline-secondary btn-sm"
                            @if($walletsAreFrozen || $wallet->is_frozen) disabled @endif>
                            <i class="ri-bank-card-line me-1"></i> Withdraw
                        </button>
                        @endif
                        @if(count($wallets) > 1 && $wallet->currency !== Auth::user()->country->currency)
                        <button wire:click="openExchangeModal('{{ $wallet->currency }}')"
                            class="btn btn-outline-primary btn-sm"
                            @if($walletsAreFrozen || $wallet->is_frozen) disabled @endif>
                            <i class="ri-exchange-dollar-line me-1"></i> Exchange
                        </button>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="border-top pt-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted">Total Earned</small>
                            <div class="fw-semibold">{{ number_format($wallet->total_earned, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Total Withdrawn</small>
                            <div class="fw-semibold">{{ number_format($wallet->total_withdrawn, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Navigation Tabs -->
<div class="card mb-4">
    <div class="card-body">
        <div class="btn-group w-100" role="group">
            <a href="{{ route('earnings.settlements') }}" class="btn {{ $activeTab === 'settlements' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Settlements
            </a>
            <a href="{{ route('earnings.withdrawals') }}" class="btn {{ $activeTab === 'withdrawals' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Withdrawals
            </a>
            <a href="{{ route('earnings.exchanges') }}" class="btn {{ $activeTab === 'exchanges' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Exchanges
            </a>
        </div>
    </div>
</div>

<!-- Content Tabs -->
<div class="card">
    <div class="card-body">
        <!-- Settlements Tab -->
        @if($activeTab === 'settlements')
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Source</th>
                        <th>Title</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settlements as $settlement)
                    <tr>
                        <td>
                            @if ($settlement->settlementable_type === 'App\\Models\\Task')
                            <span class="badge bg-primary">Task</span>
                            @elseif ($settlement->settlementable_type === 'App\\Models\\Referral')
                            @if ($settlement->settlementable->type === 'internal')
                            <span class="badge bg-info">Task Invitation</span>
                            @else
                            <span class="badge bg-success">Referral</span>
                            @endif
                            @else
                            <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($settlement->settlementable_type === 'App\\Models\\Task' && $settlement->settlementable)
                            <div class="fw-medium">{{ $settlement->settlementable->title }}</div>
                            @elseif ($settlement->settlementable_type === 'App\\Models\\Referral' && $settlement->settlementable)
                            <div class="fw-medium">{{ $settlement->settlementable->email }}</div>
                            @else
                            <div class="text-muted">-</div>
                            @endif
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
        @endif

        <!-- Withdrawals Tab -->
        @if($activeTab === 'withdrawals')
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
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
        @endif

        <!-- Exchanges Tab -->
        @if($activeTab === 'exchanges')
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
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
        @endif
    </div>
</div>

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

<!-- Withdrawal Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw {{ $withdrawCurrency }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="withdrawAmount" class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">{{ $withdrawCurrency }}</span>
                        <input type="number"
                            id="withdrawAmount"
                            wire:model.live="withdrawAmount"
                            step="0.01"
                            class="form-control"
                            placeholder="0.00">
                    </div>
                    @error('withdrawAmount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="alert alert-info">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Available Balance:</span>
                        <span class="fw-semibold">{{ number_format($availableBalance, 2) }} {{ $withdrawCurrency }}</span>
                    </div>

                    @if($withdrawAmount > 0 && !$errors->has('withdrawAmount'))
                    <hr>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Withdrawal Fee:</span>
                        <span class="text-danger">{{ number_format($withdrawalFee, 2) }} {{ $withdrawCurrency }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>You will receive:</span>
                        <span class="text-primary">{{ number_format($netAmount, 2) }} {{ $withdrawCurrency }}</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" wire:click="submitWithdrawal" class="btn btn-primary">Submit Withdrawal</button>
            </div>
        </div>
    </div>
</div>

<!-- Exchange Modal -->
<div class="modal fade" id="exchangeModal" tabindex="-1" aria-labelledby="exchangeModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exchangeModalLabel">Exchange Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>From Currency:</span>
                        <span class="fw-semibold">{{ $fromCurrency }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Available Balance:</span>
                        <span class="fw-semibold">{{ number_format($exchangeAvailableBalance, 2) }} {{ $fromCurrency }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>To Currency:</span>
                        <span class="fw-semibold">{{ $toCurrency }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount to Exchange</label>
                    <div class="input-group">
                        <span class="input-group-text">{{ $fromCurrency }}</span>
                        <input type="number"
                            id="amount"
                            wire:model.live="amount"
                            step="0.01"
                            class="form-control"
                            placeholder="0.00">
                    </div>
                    @error('amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                @if($targetAmount > 0)
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
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" wire:click="executeExchange" class="btn btn-primary" @if($targetAmount <=0) disabled @endif>Confirm Exchange</button>
            </div>
        </div>
    </div>
</div>
</div>
--}}


@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('openWithdrawModal', () => {
            new bootstrap.Modal(document.getElementById('withdrawModal')).show();
        });

        Livewire.on('closeWithdrawModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('withdrawModal')).hide();
        });

        Livewire.on('openExchangeModal', () => {
            new bootstrap.Modal(document.getElementById('exchangeModal')).show();
        });

        Livewire.on('closeExchangeModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('exchangeModal')).hide();
        });
    });
</script>
@endpush