@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                {{ $country->name }} Settings
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.countries') }}">Countries</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $country->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-3 col-xl-3">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Country Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#banking" role="tab">
                            Banking Settings
                        </a>

                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#transactions" role="tab">
                            Transactions
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#tasks_related" role="tab">
                            Tasks
                        </a>

                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#subscriptions" role="tab">
                            Subscriptions
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#templates" role="tab">
                            Templates
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#notifications" role="tab">
                            Notification Emails
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#verification" role="tab">
                            Verification Settings
                        </a>

                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="banking" role="tabpanel">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions float-right">
                                    <a href="#" class="mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw align-middle">
                                            <polyline points="23 4 23 10 17 10"></polyline>
                                            <polyline points="1 20 1 14 7 14"></polyline>
                                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                        </svg>
                                    </a>
                                    <div class="d-inline-block dropdown show">
                                        <a href="#" data-toggle="dropdown" data-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical align-middle">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Public info</h5>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Banking Configuration</h5>
                                    <h6 class="card-subtitle text-muted">Manage banking settings for {{ $country->name }}.</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.settings.countries.banking') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="country_id" value="{{ $country->id }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="mb-4">Account Settings</h5>

                                                        <div class="form-group mb-4">
                                                            <label class="form-label">Bank Account Storage</label>
                                                            <select class="form-control" name="bank_account_storage" id="bank_account_storage">
                                                                <option value="on_premises" {{ old('bank_account_storage', $settings->bank_account_storage) == 'on_premises' ? 'selected' : '' }}>On-Premises</option>
                                                                <option value="off_premises" {{ old('bank_account_storage', $settings->bank_account_storage) == 'off_premises' ? 'selected' : '' }}>Off-Premises (Gateway)</option>
                                                            </select>
                                                            <small class="text-muted">Choose where to store user bank account details.</small>
                                                        </div>

                                                        <div class="mb-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Account Number Length</label>
                                                                <input type="number" class="form-control" name="account_length" value="{{ old('account_length', $settings->account_length) }}">
                                                                <small class="text-muted">Number of digits in account number</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">Tax Rate (%)</label>
                                                                <input type="number" class="form-control" name="tax_rate" value="{{ old('tax_rate', $settings->tax_rate) }}">
                                                                <small class="text-muted">Leave blank to not include tax in prices and transactions</small>
                                                            </div>
                                                        </div>

                                                        <div class="mb-4" id="banking_fields_container">
                                                            <label class="form-label">Required Banking Fields</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_account_name" name="banking_fields[]" value="account_name" {{ in_array('account_name', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_account_name">Account Name</label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_bank_name" name="banking_fields[]" value="bank_name" {{ in_array('bank_name', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_bank_name">Bank Name</label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_branch_code" name="banking_fields[]" value="branch_code" {{ in_array('branch_code', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_branch_code">Branch Code</label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_iban" name="banking_fields[]" value="iban_number" {{ in_array('iban_number', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_iban">IBAN Number</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="banking_routing" name="banking_fields[]" value="routing_number" {{ in_array('routing_number', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_routing">Routing Number</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_account_number" name="banking_fields[]" value="account_number" {{ in_array('account_number', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_account_number">Account Number</label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_phone" name="banking_fields[]" value="phone_number" {{ in_array('phone_number', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_phone">Phone Number</label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_swift" name="banking_fields[]" value="swift_code" {{ in_array('swift_code', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_swift">SWIFT Code</label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="checkbox" id="banking_ifsc" name="banking_fields[]" value="ifsc_code" {{ in_array('ifsc_code', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_ifsc">IFSC Code</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="banking_bvn" name="banking_fields[]" value="bvn" {{ in_array('bvn', old('banking_fields', $settings->banking_fields ?? [])) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="banking_bvn">BVN</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">



                                                        <div class="mb-4">
                                                            <label class="form-label">Bank Account Verification</label>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="bank_verification_required" name="bank_verification_required" {{ old('bank_verification_required', $settings->bank_verification_required) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="bank_verification_required">Require Account Verification</label>
                                                            </div>
                                                            <small class="text-muted d-block mt-1">Account details will be verified before activation</small>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label class="form-label">Bank Account Verification Method</label>
                                                            <select class="form-control" name="bank_verification_method">
                                                                <option value="manual" {{ old('bank_verification_method', $settings->bank_verification_method) == 'manual' ? 'selected' : '' }}>Manual Verification</option>
                                                                <option value="gateway" {{ old('bank_verification_method', $settings->bank_verification_method) == 'gateway' ? 'selected' : '' }}>Gateway Verification</option>
                                                            </select>
                                                        </div>


                                                        <div class="mb-3">
                                                            <label class="form-label">USD Exchange Rate Markup</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">$1 +</span>
                                                                <input type="number" class="form-control" name="usd_exchange_rate" value="{{ old('usd_exchange_rate', $settings->usd_exchange_rate) }}" step="0.0001">
                                                                <span class="input-group-text">%</span>
                                                                @php
                                                                $markup = old('usd_exchange_rate_percentage', $settings->usd_exchange_rate_percentage ?? 0);
                                                                $total = $exchangeRate * (1 + ($markup / 100));
                                                                @endphp
                                                                <span class="input-group-text">= {{ $country->currency_symbol }}{{ number_format($total,1) }}</span>
                                                            </div>
                                                            <small class="text-muted">Current rate: {{ $country->currency_symbol }}{{ number_format($exchangeRate, 1) }} . Markup is applied as a percentage.</small>
                                                        </div>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="transactions" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Transaction & Withdrawal Settings</h5>
                                <h6 class="card-subtitle text-muted">Manage transaction and withdrawal settings for {{ $country->name }}.</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.countries.transactions') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="mb-4">Transaction Charges</h5>

                                                <div class="mb-3">
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="transaction_percentage" value="{{ isset($settings->transaction_charges['percentage']) ? $settings->transaction_charges['percentage'] : 2 }}" step="0.01">
                                                                <span class="input-group-text">%</span>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="input-group">
                                                                <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                                <input type="number" class="form-control" name="transaction_fixed" value="{{ isset($settings->transaction_charges['fixed']) ? $settings->transaction_charges['fixed'] : 100 }}" step="0.01">
                                                                <span class="input-group-text">Fixed</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                        <input type="number" class="form-control" name="transaction_cap" value="{{ isset($settings->transaction_charges['cap']) ? $settings->transaction_charges['cap'] : 2000 }}" step="0.01">
                                                        <span class="input-group-text">Cap</span>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Select Payment Gateway</label>
                                                    <select class="form-control" name="gateway">
                                                        <option value="">None</option>
                                                        <option value="stripe" {{ $settings->gateway == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                                        <option value="paypal" {{ $settings->gateway == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                                        <option value="adyen" {{ $settings->gateway == 'adyen' ? 'selected' : '' }}>Adyen</option>
                                                        <option value="square" {{ $settings->gateway == 'square' ? 'selected' : '' }}>Square</option>
                                                        <option value="checkout" {{ $settings->gateway == 'checkout' ? 'selected' : '' }}>Checkout.com</option>
                                                        <option value="mollie" {{ $settings->gateway == 'mollie' ? 'selected' : '' }}>Mollie</option>
                                                        <option value="wise" {{ $settings->gateway == 'wise' ? 'selected' : '' }}>Wise</option>
                                                        <option value="gocardless" {{ $settings->gateway == 'gocardless' ? 'selected' : '' }}>GoCardless</option>
                                                        <option value="paystack" {{ $settings->gateway == 'paystack' ? 'selected' : '' }}>Paystack</option>
                                                        <option value="flutterwave" {{ $settings->gateway == 'flutterwave' ? 'selected' : '' }}>Flutterwave</option>
                                                        <option value="interswitch" {{ $settings->gateway == 'interswitch' ? 'selected' : '' }}>Interswitch</option>
                                                        <option value="okra" {{ $settings->gateway == 'okra' ? 'selected' : '' }}>Okra</option>
                                                        <option value="paga" {{ $settings->gateway == 'paga' ? 'selected' : '' }}>Paga</option>
                                                        <option value="cellulant" {{ $settings->gateway == 'cellulant' ? 'selected' : '' }}>Cellulant</option>
                                                        <option value="dpo" {{ $settings->gateway == 'dpo' ? 'selected' : '' }}>DPO Group</option>
                                                        <option value="kuda" {{ $settings->gateway == 'kuda' ? 'selected' : '' }}>Kuda</option>
                                                        <option value="chipper" {{ $settings->gateway == 'chipper' ? 'selected' : '' }}>Chipper Cash</option>
                                                        <option value="opay" {{ $settings->gateway == 'opay' ? 'selected' : '' }}>OPay</option>
                                                        <option value="palmpay" {{ $settings->gateway == 'palmpay' ? 'selected' : '' }}>PalmPay</option>
                                                        <option value="mfs" {{ $settings->gateway == 'mfs' ? 'selected' : '' }}>MFS Africa</option>
                                                        <option value="plaid" {{ $settings->gateway == 'plaid' ? 'selected' : '' }}>Plaid</option>
                                                        <option value="truelayer" {{ $settings->gateway == 'truelayer' ? 'selected' : '' }}>TrueLayer</option>
                                                        <option value="tink" {{ $settings->gateway == 'tink' ? 'selected' : '' }}>Tink</option>
                                                        <option value="nordigen" {{ $settings->gateway == 'nordigen' ? 'selected' : '' }}>Nordigen</option>
                                                        <option value="belvo" {{ $settings->gateway == 'belvo' ? 'selected' : '' }}>Belvo</option>
                                                        <option value="akoya" {{ $settings->gateway == 'akoya' ? 'selected' : '' }}>Akoya</option>
                                                        <option value="mono" {{ $settings->gateway == 'mono' ? 'selected' : '' }}>Mono</option>
                                                        <option value="mpesa" {{ $settings->gateway == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                                        <option value="mtn" {{ $settings->gateway == 'mtn' ? 'selected' : '' }}>MTN Mobile Money</option>
                                                        <option value="airtel" {{ $settings->gateway == 'airtel' ? 'selected' : '' }}>Airtel Money</option>
                                                        <option value="orange" {{ $settings->gateway == 'orange' ? 'selected' : '' }}>Orange Money</option>
                                                        <option value="gcash" {{ $settings->gateway == 'gcash' ? 'selected' : '' }}>GCash</option>
                                                        <option value="paytm" {{ $settings->gateway == 'paytm' ? 'selected' : '' }}>Paytm</option>
                                                        <option value="wave" {{ $settings->gateway == 'wave' ? 'selected' : '' }}>Wave</option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="mb-4">Withdrawal Settings</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">Withdrawal Charges</label>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="input-group mb-2">
                                                                <input type="number" class="form-control" name="withdrawal_percentage" value="{{ isset($settings->withdrawal_charges['percentage']) ? $settings->withdrawal_charges['percentage'] : 1 }}" step="0.01">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="input-group mb-2">
                                                                <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                                <input type="number" class="form-control" name="withdrawal_fixed" value="{{ isset($settings->withdrawal_charges['fixed']) ? $settings->withdrawal_charges['fixed'] : 50 }}" step="0.01">
                                                                <span class="input-group-text">Fixed</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                        <input type="number" class="form-control" name="withdrawal_cap" value="{{ isset($settings->withdrawal_charges['cap']) ? $settings->withdrawal_charges['cap'] : 1000 }}" step="0.01">
                                                        <span class="input-group-text">Cap</span>
                                                    </div>
                                                </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Minimum Withdrawal</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                            <input type="number" class="form-control" name="min_withdrawal" value="{{ old('min_withdrawal', $settings->min_withdrawal) }}" step="0.01">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Maximum Withdrawal</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                            <input type="number" class="form-control" name="max_withdrawal" value="{{ old('max_withdrawal', $settings->max_withdrawal) }}" step="0.01">
                                                        </div>
                                                    </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Wallet Status</label>
                                                    <div class="d-flex">
                                                        <div class="form-check mr-auto">
                                                            <input class="form-check-input" type="radio" name="wallet_status" id="enable_wallets" value="enabled" {{ old('wallet_status', $settings->wallet_status) == 'enabled' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="enable_wallets">
                                                                Enable Wallets
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="wallet_status" id="disable_wallets" value="disabled" {{ old('wallet_status', $settings->wallet_status) == 'disabled' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="disable_wallets">
                                                                Freeze Wallets
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Control whether users can access their wallets in this country</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Payout Method</label>
                                                    <select class="form-control" name="payout_method">
                                                        <option value="manual" {{ $settings->payout_method == 'manual' ? 'selected' : '' }}>Manual</option>
                                                        <option value="gateway" {{ $settings->payout_method == 'gateway' ? 'selected' : '' }}>Gateway</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="weekend_payout" name="weekend_payout" {{ old('weekend_payout', $settings->weekend_payout) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="weekend_payout">Weekend Payout</label>
                                                    </div>

                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="holiday_payout" name="holiday_payout" {{ old('holiday_payout', $settings->holiday_payout) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="holiday_payout">Holiday Payout</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="mt-4 d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save Transaction Settings</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tasks_related" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Task Related Settings</h5>
                                <h6 class="card-subtitle text-muted">Manage task-related rates and settings for {{ $country->name }}.</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.countries.tasks') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="mb-4">Promotional Rates</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">Feature Rate per day</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                        <input type="number" class="form-control" name="feature_rate" value="{{ old('feature_rate', $settings->feature_rate) }}" step="0.01">
                                                    </div>
                                                    <small class="text-muted">Cost to feature a job posting per day</small>
                                                </div>

                                                <div class="mb-3">
                                                        <label class="form-label">Broadcast Rate per email </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                        <input type="number" class="form-control" name="broadcast_rate" value="{{ old('broadcast_rate', $settings->broadcast_rate) }}" step="0.01">
                                                        </div>
                                                        <small class="text-muted">Cost to send broadcast email per recipient</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="mb-4">Review Costs</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">Admin Review Cost</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                        <input type="number" class="form-control" name="admin_review_cost" value="{{ old('admin_review_cost', $settings->admin_review_cost) }}" step="0.01">
                                                    </div>
                                                    <small class="text-muted">Cost for admin-monitored tasks</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">System Review Cost</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                        <input type="number" class="form-control" name="system_review_cost" value="{{ old('system_review_cost', $settings->system_review_cost) }}" step="0.01">
                                                    </div>
                                                    <small class="text-muted">Cost for system-automated review</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="mb-4">Commission Settings</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">Invitee Commission Percentage</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="invitee_commission_percentage" value="{{ old('invitee_commission_percentage', $settings->invitee_commission_percentage) }}" step="0.01" min="0" max="100">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <small class="text-muted">Percentage commission for invited workers</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Referral Earnings Percentage</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="referral_earnings_percentage" value="{{ old('referral_earnings_percentage', $settings->referral_earnings_percentage) }}" step="0.01" min="0" max="100">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <small class="text-muted">Percentage earnings for successful referrals</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                                    <div class="mt-4 d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <div>
                                    <button type="submit" class="btn btn-primary">Save Task Settings</button>
                                </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="subscriptions" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Boosters</h5>
                                <h6 class="card-subtitle text-muted">Manage booster pricing for {{ $country->name }}.</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.countries.booster_prices') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                    
                                    @if($boosters->count() > 0)
                                        <div class="row">
                                            @foreach($boosters as $booster)
                                                <div class="col-md-6 col-lg-4 mb-4">
                                                    <div class="card h-100">
                                                        <div class="card-header">
                                                            <h6 class="card-title mb-0">{{ $booster->name }}</h6>
                                                            <small class="text-muted">{{ ucfirst($booster->type) }} Booster</small>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text text-muted small mb-3">
                                                                {{ Str::limit($booster->description, 100) }}
                                                            </p>
                                                            <div class="mb-3">
                                                                <label class="form-label">Booster Price</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                                    <input type="number" 
                                                                           class="form-control" 
                                                                           name="booster_prices[{{ $booster->id }}]" 
                                                                           value="{{ old('booster_prices.' . $booster->id, isset($countryPricesByKey[App\Models\Booster::class][$booster->id]) ? $countryPricesByKey[App\Models\Booster::class][$booster->id]->amount : '') }}" 
                                                                           step="0.01" 
                                                                           min="0"
                                                                           placeholder="0.00">
                                                                </div>
                                                                <small class="text-muted">Set the price for this booster in {{ $country->currency_symbol }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-4 d-flex justify-content-between align-items-center">
                                            <div class="text-muted small">
                                                <i class="fas fa-info-circle"></i> 
                                                {{ $boosters->count() }} active booster(s) found
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Save Subscription Settings</button>
                                                <a href="{{ route('admin.settings.countries') }}" class="btn btn-secondary ms-2">Cancel</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                                <p>No active subscription boosters found.</p>
                                                <p class="small">Create subscription boosters first to configure pricing.</p>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="templates" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Task Templates</h5>
                                <h6 class="card-subtitle text-muted">Manage minimum task budgets for each template in {{ $country->name }}.</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.countries.template_prices') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                    
                                    @if($templates->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 40%">Template Name</th>
                                                        <th style="width: 35%">Description</th>
                                                        <th style="width: 25%">Minimum Budget ({{ $country->currency_symbol }})</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($templates as $template)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $template->name }}</strong>
                                                                <div class="small text-muted">
                                                                    {{ count($template->task_fields) }} task fields, {{ count($template->submission_fields) }} submission fields
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="text-muted small">
                                                                    {{ Str::limit($template->description, 80) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-md">
                                                                    <span class="input-group-text">{{ $country->currency_symbol }}</span>
                                                                    <input type="number" 
                                                                           class="form-control" 
                                                                           name="template_prices[{{ $template->id }}]" 
                                                                           value="{{ old('template_prices.' . $template->id, isset($countryPricesByKey[App\Models\TaskTemplate::class][$template->id]) ? $countryPricesByKey[App\Models\TaskTemplate::class][$template->id]->amount : '') }}" 
                                                                           step="0.01" 
                                                                           min="0"
                                                                           placeholder="0.00">
                                                                </div>
                                                                <small class="text-muted">Minimum allowed budget</small>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-between align-items-center">
                                            <div class="text-muted small">
                                                <i class="fas fa-info-circle"></i> 
                                                {{ $templates->count() }} active template(s) found
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Save Template Settings</button>
                                                <a href="{{ route('admin.settings.countries') }}" class="btn btn-secondary ms-2">Cancel</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                                <p>No active task templates found.</p>
                                                <p class="small">Create task templates first to configure minimum budgets.</p>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Notification Emails</h5>
                                <h6 class="card-subtitle text-muted">Set notification email addresses for {{ $country->name }}.</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.countries.notification_emails') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                    <div class="mb-3">
                                        <label class="form-label">Task Notification Email</label>
                                        <input type="email" class="form-control @error('notification_emails.task') is-invalid @enderror" name="notification_emails[task]" value="{{ old('notification_emails.task', $settings->notification_emails['task'] ?? '') }}" placeholder="task@domain.com">
                                        @error('notification_emails.task')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Support/Dispute Notification Email</label>
                                        <input type="email" class="form-control @error('notification_emails.support') is-invalid @enderror" name="notification_emails[support]" value="{{ old('notification_emails.support', $settings->notification_emails['support'] ?? '') }}" placeholder="support@domain.com">
                                        @error('notification_emails.support')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Payment Notification Email</label>
                                        <input type="email" class="form-control @error('notification_emails.payment') is-invalid @enderror" name="notification_emails[payment]" value="{{ old('notification_emails.payment', $settings->notification_emails['payment'] ?? '') }}" placeholder="payment@domain.com">
                                        @error('notification_emails.payment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Disbursement Notification Email</label>
                                        <input type="email" class="form-control @error('notification_emails.disbursement') is-invalid @enderror" name="notification_emails[disbursement]" value="{{ old('notification_emails.disbursement', $settings->notification_emails['disbursement'] ?? '') }}" placeholder="disbursement@domain.com">
                                        @error('notification_emails.disbursement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-4 d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save Notification Emails</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="verification" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Verification Settings</h5>
                                <h6 class="card-subtitle text-muted">Configure required verification fields and method for {{ $country->name }}.</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.countries.verification_settings') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                    <div class="mb-3">
                                        <label class="form-label">Verification Provider</label>
                                        <select class="form-control" name="verification_provider" id="verification_provider_select">
                                            <option value="manual" {{ old('verification_provider', $settings->verification_provider ?? 'manual') == 'manual' ? 'selected' : '' }}>Manual</option>
                                            <option value="smileid" {{ old('verification_provider', $settings->verification_provider ?? '') == 'smileid' ? 'selected' : '' }}>SmileID</option>
                                            <option value="passbase" {{ old('verification_provider', $settings->verification_provider ?? '') == 'passbase' ? 'selected' : '' }}>Passbase</option>
                                            <option value="verifyme" {{ old('verification_provider', $settings->verification_provider ?? '') == 'verifyme' ? 'selected' : '' }}>VerifyMe</option>
                                            <option value="identitypass" {{ old('verification_provider', $settings->verification_provider ?? '') == 'identitypass' ? 'selected' : '' }}>IdentityPass</option>
                                            <option value="shuftipro" {{ old('verification_provider', $settings->verification_provider ?? '') == 'shuftipro' ? 'selected' : '' }}>ShuftiPro</option>
                                            <option value="veriff" {{ old('verification_provider', $settings->verification_provider ?? '') == 'veriff' ? 'selected' : '' }}>Veriff</option>
                                            <option value="onfido" {{ old('verification_provider', $settings->verification_provider ?? '') == 'onfido' ? 'selected' : '' }}>Onfido</option>
                                            <option value="sumsub" {{ old('verification_provider', $settings->verification_provider ?? '') == 'sumsub' ? 'selected' : '' }}>Sumsub</option>
                                            <option value="yoti" {{ old('verification_provider', $settings->verification_provider ?? '') == 'yoti' ? 'selected' : '' }}>Yoti</option>
                                            <option value="idnow" {{ old('verification_provider', $settings->verification_provider ?? '') == 'idnow' ? 'selected' : '' }}>IDnow</option>
                                            <option value="persona" {{ old('verification_provider', $settings->verification_provider ?? '') == 'persona' ? 'selected' : '' }}>Persona</option>
                                            <option value="trulioo" {{ old('verification_provider', $settings->verification_provider ?? '') == 'trulioo' ? 'selected' : '' }}>Trulioo</option>
                                        </select>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="verifications_can_expire" name="verifications_can_expire" {{ old('verifications_can_expire', $settings->verifications_can_expire ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="verifications_can_expire">Verifications can expire</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Government ID Documents</label>
                                                <div class="input-group mb-2">
                                                    <label class="input-group-text">Require</label>
                                                    <select class="form-select" name="verification_fields[gov_id][mode]">
                                                        <option value="all" {{ (old('verification_fields.gov_id.mode', $settings->verification_fields['gov_id']['mode'] ?? '') == 'all') ? 'selected' : '' }}>All</option>
                                                        <option value="one" {{ (old('verification_fields.gov_id.mode', $settings->verification_fields['gov_id']['mode'] ?? '') == 'one') ? 'selected' : '' }}>One</option>
                                                    </select>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[gov_id][docs][]" value="national_id" id="field_national_id" {{ in_array('national_id', old('verification_fields.gov_id.docs', $settings->verification_fields['gov_id']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_national_id">National ID Card</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[gov_id][docs][]" value="drivers_license" id="field_drivers_license" {{ in_array('drivers_license', old('verification_fields.gov_id.docs', $settings->verification_fields['gov_id']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_drivers_license">Driver's License</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[gov_id][docs][]" value="adhar_card" id="field_adhar_card" {{ in_array('adhar_card', old('verification_fields.gov_id.docs', $settings->verification_fields['gov_id']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_adhar_card">Adhar Card</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[gov_id][docs][]" value="nin" id="field_nin" {{ in_array('nin', old('verification_fields.gov_id.docs', $settings->verification_fields['gov_id']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_nin">NIN</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[gov_id][docs][]" value="voters_card" id="field_voters_card" {{ in_array('voters_card', old('verification_fields.gov_id.docs', $settings->verification_fields['gov_id']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_voters_card">Voter's Card</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[gov_id][docs][]" value="passport" id="field_passport" {{ in_array('passport', old('verification_fields.gov_id.docs', $settings->verification_fields['gov_id']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_passport">Passport</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Proof of Address Documents</label>
                                                <div class="input-group mb-2">
                                                    <label class="input-group-text">Require</label>
                                                    <select class="form-select" name="verification_fields[address][mode]">
                                                        <option value="all" {{ (old('verification_fields.address.mode', $settings->verification_fields['address']['mode'] ?? '') == 'all') ? 'selected' : '' }}>All</option>
                                                        <option value="one" {{ (old('verification_fields.address.mode', $settings->verification_fields['address']['mode'] ?? '') == 'one') ? 'selected' : '' }}>One</option>
                                                    </select>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[address][docs][]" value="electricity_bill" id="field_electricity_bill" {{ in_array('electricity_bill', old('verification_fields.address.docs', $settings->verification_fields['address']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_electricity_bill">Electricity Bill</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[address][docs][]" value="waste_bill" id="field_waste_bill" {{ in_array('waste_bill', old('verification_fields.address.docs', $settings->verification_fields['address']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_waste_bill">Waste Bill</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[address][docs][]" value="internet_bill" id="field_internet_bill" {{ in_array('internet_bill', old('verification_fields.address.docs', $settings->verification_fields['address']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_internet_bill">Internet Bill</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="verification_fields[address][docs][]" value="bank_statement" id="field_bank_statement" {{ in_array('bank_statement', old('verification_fields.address.docs', $settings->verification_fields['address']['docs'] ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="field_bank_statement">Bank Statement</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mt-4 d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save Verification Settings</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const storageSelect = document.getElementById('bank_account_storage');
        const fieldsContainer = document.getElementById('banking_fields_container');

        function toggleFields() {
            if (storageSelect.value === 'on_premises') {
                fieldsContainer.style.display = 'block';
            } else {
                fieldsContainer.style.display = 'none';
            }
        }

        storageSelect.addEventListener('change', toggleFields);
        toggleFields(); // Initial check
    });
</script>
<script>
    $(function() {
        $('#verification_provider_select').on('change', function() {
            if ($(this).val() === 'provider') {
                $('#verification_provider_group').show();
            } else {
                $('#verification_provider_group').hide();
            }
        });
    });
</script>
@endpush