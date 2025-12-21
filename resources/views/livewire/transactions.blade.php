<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Transaction History</h1>
                    <p class="mb-0">View all your payments and financial transactions</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                        <a href="{{ route('earnings.settlements') }}" class="btn btn-outline-light">Earnings</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Total Transactions</h6>
                                <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="bi bi-receipt text-primary"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Successful</h6>
                                <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="bi bi-check-circle text-success"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['successful'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Failed</h6>
                                <span class="bg-danger bg-opacity-10 rounded-circle p-2"><i class="bi bi-x-circle text-danger"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['failed'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Total Amount</h6>
                                <span class="bg-info bg-opacity-10 rounded-circle p-2"><i class="bi bi-cash text-info"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $currencySymbol }}{{ number_format($stats['total_amount'], 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select wire:model.live="type" class="form-select">
                                <option value="all">All Types</option>
                                <option value="income">Income</option>
                                <option value="withdrawal">Withdrawal</option>
                                <option value="subscription">Subscription</option>
                                <option value="promotion">Promotion</option>
                                <option value="task">Task Payment</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select wire:model.live="status" class="form-select">
                                <option value="all">All Status</option>
                                <option value="success">Success</option>
                                <option value="failed">Failed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date From</label>
                            <input type="date" wire:model.live="dateFrom" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date To</label>
                            <input type="date" wire:model.live="dateTo" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Search</label>
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Reference or ID...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">Clear Filters</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Transaction History</h5>
                    @if($payments->count() > 0)
                    <small class="text-muted">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} transactions</small>
                    @endif
                </div>
                <div class="card-body">
                    @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $payment->transaction_description }}</div>
                                        <small class="text-muted">{{ $payment->currency }}</small>
                                    </td>
                                    <td>
                                        @switch($payment->transaction_type)
                                            @case('income')
                                                <span class="badge bg-success">Income</span>
                                                @break
                                            @case('withdrawal')
                                                <span class="badge bg-warning">Withdrawal</span>
                                                @break
                                            @case('subscription')
                                                <span class="badge bg-info">Subscription</span>
                                                @break
                                            @case('promotion')
                                                <span class="badge bg-primary">Promotion</span>
                                                @break
                                            @case('task')
                                                <span class="badge bg-secondary">Task</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">{{ ucfirst($payment->transaction_type) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="fw-semibold {{ $payment->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $payment->amount >= 0 ? '+' : '' }}{{ $currencySymbol }}{{ number_format($payment->amount, 2) }}
                                        </span>
                                        @if($payment->vat_value > 0)
                                        <br><small class="text-muted">VAT: {{ $currencySymbol }}{{ number_format($payment->vat_value, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($payment->status)
                                            @case('success')
                                                <span class="badge bg-success">Success</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger">Failed</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-secondary">Cancelled</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">{{ ucfirst($payment->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td><small class="text-muted">{{ $payment->reference }}</small></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-primary btn-sm view-details-btn" data-bs-toggle="modal" data-bs-target="#transactionModal"
                                                data-reference="{{ $payment->reference }}"
                                                data-currency="{{ $payment->currency }}"
                                                data-amount="{{ number_format($payment->amount, 2) }}"
                                                data-vat="{{ number_format($payment->vat_value, 2) }}"
                                                data-status="{{ $payment->status }}"
                                                data-date="{{ $payment->created_at ? $payment->created_at->format('M j, Y H:i') : '-' }}"
                                                data-items="{{ $payment->order ? json_encode($payment->order->items) : '[]' }}"
                                                data-currency-symbol="{{ $currencySymbol }}">
                                            <i class="bi bi-eye me-1"></i> View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($payments->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $payments->links() }}
                    </div>
                    @endif
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-receipt display-4 text-muted mb-3"></i>
                        <h5 class="text-muted">No transactions found</h5>
                        <p class="text-muted">No transactions match your current filters.</p>
                        @if($search || $type !== 'all' || $status !== 'all' || $dateFrom || $dateTo)
                        <button wire:click="clearFilters" class="btn btn-outline-primary">Clear Filters</button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Transaction Details Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">
                        Transaction Details
                        <span class="text-muted" id="modalReference"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Payment Information -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Payment Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small class="text-muted">Reference</small>
                                            <div class="fw-semibold" id="modalReferenceText"></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Status</small>
                                            <div id="modalStatus"></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Currency</small>
                                            <div class="fw-semibold" id="modalCurrency"></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Date</small>
                                            <div class="fw-semibold" id="modalDate"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Amount Breakdown</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small class="text-muted">Amount</small>
                                            <div class="fw-bold text-primary" id="modalAmount"></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">VAT</small>
                                            <div class="fw-semibold" id="modalVat"></div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold">Total</span>
                                                <span class="fw-bold text-success" id="modalTotal"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card" id="orderItemsCard" style="display: none;">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Items Purchased</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm" id="orderItemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Type</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderItemsBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- No Items Alert -->
                    <div class="alert alert-info" id="noItemsAlert" style="display: none;">
                        <i class="bi bi-info-circle me-2"></i>
                        No order items found for this payment.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">Payment Transactions</h1>
                <p class="text-muted mb-0">View and manage your payment history and transaction details</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Total Payments</h6>
                        <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="ri-money-dollar-circle-line text-primary"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $payments->total() }}</h3>
</div>
</div>
</div>
<div class="col-md-3">
    <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Successful</h6>
                <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="ri-check-double-line text-success"></i></span>
            </div>
            <h3 class="fw-bold mb-0">{{ $payments->where('status', 'success')->count() }}</h3>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Failed</h6>
                <span class="bg-danger bg-opacity-10 rounded-circle p-2"><i class="ri-close-circle-line text-danger"></i></span>
            </div>
            <h3 class="fw-bold mb-0">{{ $payments->where('status', 'failed')->count() }}</h3>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Total Amount</h6>
                <span class="bg-info bg-opacity-10 rounded-circle p-2"><i class="ri-calculator-line text-info"></i></span>
            </div>
            <h3 class="fw-bold mb-0">{{ number_format($payments->sum('amount'), 2) }}</h3>
        </div>
    </div>
</div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Transaction History</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>
                            <span class="fw-semibold">{{ $payment->reference }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $payment->currency }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-primary">{{ number_format($payment->amount, 2) }}</span>
                        </td>
                        <td>
                            <span class="text-muted">{{ number_format($payment->vat_value, 2) }}</span>
                        </td>
                        <td>
                            @if($payment->status === 'success')
                            <span class="badge bg-success">Success</span>
                            @elseif($payment->status === 'failed')
                            <span class="badge bg-danger">Failed</span>
                            @else
                            <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $payment->created_at ? $payment->created_at->format('M d, Y H:i') : '-' }}</small>
                        </td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm view-details-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#transactionModal"
                                data-reference="{{ $payment->reference }}"
                                data-currency="{{ $payment->currency }}"
                                data-amount="{{ number_format($payment->amount, 2) }}"
                                data-vat="{{ number_format($payment->vat_value, 2) }}"
                                data-status="{{ $payment->status }}"
                                data-date="{{ $payment->created_at ? $payment->created_at->format('M d, Y H:i') : '-' }}"
                                data-items="{{ json_encode($payment->order->items ?? []) }}">
                                <i class="ri-eye-line me-1"></i> View Details
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="ri-money-dollar-circle-line display-4 mb-2"></i>
                            <p>No transactions found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Showing <span class="fw-semibold">{{ $payments->firstItem() }}</span> to <span class="fw-semibold">{{ $payments->lastItem() }}</span> of <span class="fw-semibold">{{ $payments->total() }}</span> results
            </div>
            <div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">
                    Transaction Details
                    <span class="text-muted" id="modalReference"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Payment Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Payment Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted">Reference</small>
                                        <div class="fw-semibold" id="modalReferenceText"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Status</small>
                                        <div id="modalStatus"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Currency</small>
                                        <div class="fw-semibold" id="modalCurrency"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Date</small>
                                        <div class="fw-semibold" id="modalDate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Amount Breakdown</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted">Amount</small>
                                        <div class="fw-bold text-primary" id="modalAmount"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">VAT</small>
                                        <div class="fw-semibold" id="modalVat"></div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Total</span>
                                            <span class="fw-bold text-success" id="modalTotal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card" id="orderItemsCard" style="display: none;">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Items Purchased</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="orderItemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItemsBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- No Items Alert -->
                <div class="alert alert-info" id="noItemsAlert" style="display: none;">
                    <i class="ri-information-line me-2"></i>
                    No order items found for this payment.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
--}}


@push('scripts')
<script>
    $(document).ready(function() {
        $('.view-details-btn').on('click', function() {
            // Get data from button attributes
            var reference = $(this).data('reference');
            var currency = $(this).data('currency');
            var amount = $(this).data('amount');
            var vat = $(this).data('vat');
            var status = $(this).data('status');
            var date = $(this).data('date');
            var items = $(this).data('items');
            var currencySymbol = $(this).data('currency-symbol') || '$';

            // Calculate total
            var amountValue = parseFloat(amount.replace(/,/g, ''));
            var vatValue = parseFloat(vat.replace(/,/g, ''));
            var total = amountValue + vatValue;

            // Update modal content
            $('#modalReference').text('(' + reference + ')');
            $('#modalReferenceText').text(reference);
            $('#modalCurrency').text(currency);
            $('#modalAmount').text(currencySymbol + amount);
            $('#modalVat').text(currencySymbol + vat);
            $('#modalDate').text(date);
            $('#modalTotal').text(currencySymbol + total.toFixed(2));

            // Update status badge
            var statusBadge = '';
            if (status === 'success') {
                statusBadge = '<span class="badge bg-success">Success</span>';
            } else if (status === 'failed') {
                statusBadge = '<span class="badge bg-danger">Failed</span>';
            } else if (status === 'pending') {
                statusBadge = '<span class="badge bg-warning">Pending</span>';
            } else if (status === 'cancelled') {
                statusBadge = '<span class="badge bg-secondary">Cancelled</span>';
            } else {
                statusBadge = '<span class="badge bg-secondary">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>';
            }
            $('#modalStatus').html(statusBadge);

            // Handle order items
            if (items && items.length > 0) {
                $('#orderItemsCard').show();
                $('#noItemsAlert').hide();

                var itemsHtml = '';
                items.forEach(function(item) {
                    var itemType = '';
                    var description = '';

                    // Determine item type and description
                    if (item.orderable_type && item.orderable_type.includes('Task')) {
                        itemType = '<span class="badge bg-primary">Task</span>';
                        description = item.orderable ? item.orderable.title : 'N/A';
                    } else if (item.orderable_type && item.orderable_type.includes('TaskPromotion')) {
                        itemType = '<span class="badge bg-info">Promotion</span>';
                        description = item.orderable ? item.orderable.type : 'N/A';
                    } else if (item.orderable_type && item.orderable_type.includes('Subscription')) {
                        itemType = '<span class="badge bg-success">Subscription</span>';
                        description = item.orderable && item.orderable.booster ? item.orderable.booster.name : 'N/A';
                    } else {
                        itemType = '<span class="badge bg-secondary">' + (item.orderable_type ? item.orderable_type.split('\\').pop() : 'Unknown') + '</span>';
                        description = 'N/A';
                    }

                    itemsHtml += '<tr>' +
                        '<td>' + itemType + '</td>' +
                        '<td>' + description + '</td>' +
                        '<td><span class="fw-semibold">' + currencySymbol + parseFloat(item.amount).toFixed(2) + '</span></td>' +
                        '</tr>';
                });

                $('#orderItemsBody').html(itemsHtml);
            } else {
                $('#orderItemsCard').hide();
                $('#noItemsAlert').show();
            }
        });
    });
</script>
@endpush