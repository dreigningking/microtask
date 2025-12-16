<?php

namespace App\Livewire;

use App\Models\Wallet;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Exchange;
use App\Models\Settlement;
use App\Models\Withdrawal;
use Livewire\WithPagination;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Auth;


class ListEarnings extends Component
{
    use WithPagination;
    use HelperTrait;

    // Withdrawal form
    public $withdrawAmount = '';
    public $availableBalance = 0;
    public $minWithdrawal = 10;
    public $maxWithdrawal = 10000;
    public $withdrawalFee = 0;
    public $netAmount = 0;
    public $withdrawalCharges = [];

    // Exchange form
    public $fromCurrency = '';
    public $toCurrency = '';
    public $toCurrencySymbol = '';
    public $amount = '';
    public $exchangeRate = 0;
    public $targetAmount = 0;
    public $exchangeAvailableBalance = 0;

    // Wallet freeze logic
    public $walletsAreFrozen = false;
    public $frozenReason = '';
    public $exchangeDisabled = false;
    public $withdrawalDisabled = false;

    protected function rules()
    {
        return [
            'withdrawAmount' => [
                'required',
                'numeric',
                'min:' . $this->minWithdrawal,
                'max:' . $this->maxWithdrawal,
            ],
        'fromCurrency' => 'required',
        'toCurrency' => 'required|different:fromCurrency',
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) {
                    if ($value > $this->exchangeAvailableBalance) {
                        $fail('The exchange amount cannot exceed your available balance.');
                    }
                },
            ],
        ];
    }

    protected $messages = [
        'withdrawAmount.min' => 'The minimum withdrawal amount is :min.',
        'withdrawAmount.max' => 'The maximum withdrawal amount is :max.',
    ];

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->toCurrency = $user->country->currency;
        $this->toCurrencySymbol = $user->country->currency_symbol;
        $this->exchangeRate = $this->getMarkedUpRate($this->toCurrency, $user);
        // Wallet freeze logic
        $globalFreeze = Setting::firstWhere('name', 'freeze_wallets_globally')->value('value') == 1;
        $countrySetting = $user->country->setting ?? null;
        $walletSettings = $countrySetting ? $countrySetting->wallet_settings : null;
        $countryFreeze = is_null($countrySetting) || is_null($walletSettings) || !$walletSettings['wallet_status'];
        $withdrawalSettingsExist = $countrySetting && isset($countrySetting->withdrawal_settings);
        $walletSettingsExist = $countrySetting && isset($countrySetting->wallet_settings);

        $this->exchangeDisabled = $globalFreeze || $countryFreeze || !$walletSettingsExist || !$user->is_verified;
        $this->withdrawalDisabled = $globalFreeze || $countryFreeze || !$withdrawalSettingsExist || !$user->is_verified || !$user->bank_account;
        $this->walletsAreFrozen = $this->exchangeDisabled || $this->withdrawalDisabled;

        if ($globalFreeze) {
            $this->frozenReason = 'Wallet operations are temporarily disabled for all users.';
        } elseif ($countryFreeze) {
            $this->frozenReason = 'Wallet operations are currently disabled in your country.';
        } elseif (!$user->is_verified) {
            $this->frozenReason = 'Please complete all required verifications to enable withdrawals and exchanges.';
        } elseif (!$user->bank_account) {
            $this->frozenReason = 'Please set up your bank account details in your profile to enable withdrawals.';
        } elseif (!$withdrawalSettingsExist || !$walletSettingsExist) {
            $this->frozenReason = 'Country settings are not properly configured. Please contact support.';
        }

        // Load withdrawal charges from country settings
        if ($countrySetting) {
            if ($countrySetting->withdrawal_charges) {
                $this->withdrawalCharges = $countrySetting->withdrawal_charges;
            } else {
                // Default charges if not set
                $this->withdrawalCharges = [
                    'percentage' => 1,
                    'fixed' => 50,
                    'cap' => 1000
                ];
            }
            $this->minWithdrawal = $countrySetting->min_withdrawal ?? 10;
            $max = $countrySetting->max_withdrawal ?? 10000;

            // Check for active subscription and apply multiplier
            $activeSubscription = $user->activeSubscriptions()->latest('expires_at')->first();
            if ($activeSubscription && isset($activeSubscription->booster->withdrawal_maximum_multiplier)) {
                $multiplier = $activeSubscription->booster->withdrawal_maximum_multiplier;
                if (is_numeric($multiplier) && $multiplier > 0) {
                    $max = $max * $multiplier;
                }
            }

            $this->maxWithdrawal = $max;
        }
    }

    public function updatedAmount()
    {
        $this->validateOnly('amount');
        $this->calculateExchange();
    }


    private function calculateExchange()
    {
        if (empty($this->fromCurrency) || empty($this->amount) || !is_numeric($this->amount) || $this->amount <= 0) {
            $this->exchangeRate = 0;
            $this->targetAmount = 0;
            return;
        }

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            $fromRate = $this->getMarkedUpRate($this->fromCurrency, $user);
            $toRate = $this->getMarkedUpRate($this->toCurrency, $user);

            if ($this->fromCurrency === 'USD') {
                $this->exchangeRate = $toRate;
            } elseif ($this->toCurrency === 'USD') {
                $this->exchangeRate = 1 / $fromRate;
            } else {
                $this->exchangeRate = $toRate / $fromRate;
            }
            
            $this->targetAmount = $this->amount * $this->exchangeRate;
        } catch (\Exception $e) {
            $this->exchangeRate = 0;
            $this->targetAmount = 0;
            // Optionally, flash a message to the user
            session()->flash('error', $e->getMessage());
        }
    }

    // Withdrawal methods
    

    public function updatedWithdrawAmount()
    {
        $this->validateOnly('withdrawAmount');

        if ($this->withdrawAmount > 0) {
            // Calculate withdrawal fee based on country settings
            $percentage = $this->withdrawalCharges['percentage'] ?? 0;
            $fixed = $this->withdrawalCharges['fixed'] ?? 0;
            $cap = $this->withdrawalCharges['cap'] ?? null;

            $percentageFee = ($this->withdrawAmount * $percentage) / 100;
            $totalFee = $percentageFee + $fixed;
            
            // Apply cap if it's set and total fee exceeds it
            if (!is_null($cap) && $totalFee > $cap) {
                $totalFee = $cap;
            }
            
            $this->withdrawalFee = $totalFee;
            $this->netAmount = $this->withdrawAmount - $this->withdrawalFee;
        } else {
            $this->withdrawalFee = 0;
            $this->netAmount = 0;
        }
    }

    public function submitWithdrawal()
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->bank_account) {
            session()->flash('error', 'Please set up your bank account details first.');
            return;
        }

        $wallet = $user->wallets()->where('currency', $this->toCurrency)->first();
        
        if (!$wallet) {
            session()->flash('error', 'Wallet not found.');
            return;
        }

        // Check if withdrawal amount plus fees exceeds available balance
        if ($wallet->balance < $this->withdrawAmount) {
            session()->flash('error', 'Insufficient balance for withdrawal.');
            return;
        }

        // Double-check that the total amount (withdrawal + fees) doesn't exceed balance
        $totalAmount = $this->withdrawAmount + $this->withdrawalFee;
        if ($wallet->balance < $totalAmount) {
            session()->flash('error', 'Insufficient balance to cover withdrawal amount and fees.');
            return;
        }

        // Create withdrawal record
        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'currency' => $this->toCurrency,
            'amount' => $this->withdrawAmount,
            'reference' => 'WD' . time() . $user->id,
            'meta' => [
                'fee' => $this->withdrawalFee,
                'net_amount' => $this->netAmount,
                'charges_breakdown' => [
                    'percentage' => $this->withdrawalCharges['percentage'],
                    'fixed' => $this->withdrawalCharges['fixed'],
                    'cap' => $this->withdrawalCharges['cap'],
                    'percentage_amount' => ($this->withdrawAmount * $this->withdrawalCharges['percentage']) / 100,
                    'total_fee' => $this->withdrawalFee
                ]
            ]
        ]);

        // Deduct from wallet
        $wallet->decrement('balance', $this->withdrawAmount);
        $wallet->increment('total_withdrawn', $this->withdrawAmount);

        session()->flash('message', 'Withdrawal request submitted successfully.');
    }

    // Exchange methods
    public function openExchangeModal($currency)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->fromCurrency = $currency;
        $wallet = $user->wallets()->where('currency', $currency)->first();
        $this->exchangeAvailableBalance = $wallet ? $wallet->balance : 0;
    }

    public function getExchangeAmount()
    {
        return $this->targetAmount;
    }

    public function executeExchange()
    {
        $this->validate([
            'fromCurrency' => 'required',
            'toCurrency' => 'required|different:fromCurrency',
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $this->exchangeAvailableBalance
            ],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Ensure user can only exchange to their home currency
        if ($this->toCurrency !== $user->country->currency) {
            session()->flash('error', 'You can only exchange to your home currency.');
            return;
        }

        $fromWallet = $user->wallets()->where('currency', $this->fromCurrency)->first();
        $toWallet = $user->wallets()->where('currency', $this->toCurrency)->first();

        if (!$fromWallet || !$toWallet) {
            session()->flash('error', 'Invalid wallet selection.');
            return;
        }

        if ($fromWallet->balance < $this->amount) {
            session()->flash('error', 'Insufficient balance.');
            return;
        }

        // Re-calculate before executing to ensure data is fresh
        $this->calculateExchange();
        if ($this->targetAmount <= 0) {
            session()->flash('error', 'Could not calculate exchange amount. Please try again.');
            return;
        }

        // Create exchange record
        $exchange = Exchange::create([
            'user_id' => $user->id,
            'base_currency' => $this->fromCurrency,
            'target_currency' => $this->toCurrency,
            'exchange_rate' => $this->exchangeRate,
            'base_amount' => $this->amount,
            'target_amount' => $this->targetAmount,
            'base_wallet_id' => $fromWallet->id,
            'target_wallet_id' => $toWallet->id,
            'status' => 'completed',
            'reference' => 'EX' . time() . $user->id
        ]);

        // Perform the exchange
        $fromWallet->decrement('balance', $this->amount);
        $toWallet->increment('balance', $this->targetAmount);

        session()->flash('message', 'Currency exchange completed successfully.');
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $wallets = $user->wallets;
        $homeWallet = $wallets->where('currency', $this->toCurrency)->first();
        $countrySetting = $user->country->setting ?? null;

        $settlements = Settlement::where('user_id', $user->id)
            ->with(['settlementable'])
            ->latest()
            ->paginate(10);

        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $exchanges = Exchange::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $totalWithdrawn = Withdrawal::where('user_id', $user->id)->whereNotNull('paid_at')->sum('amount');
        $pendingWithdrawals = Withdrawal::where('user_id', $user->id)->whereNull('paid_at')->sum('amount');
        $rejectedWithdrawals = Withdrawal::where('user_id', $user->id)->whereHas('moderations',function($query){$query->where('status', '!=', 'rejected');})->sum('amount');

        return view('livewire.list-earnings', [
            'wallets' => $wallets,
            'settlements' => $settlements,
            'withdrawals' => $withdrawals,
            'exchanges' => $exchanges,
            'availableCurrencies' => $wallets->pluck('currency')->toArray(),
            'homeWallet' => $homeWallet,
            'homeCurrency' => $this->toCurrency,
            'homeCurrencySymbol' => $this->toCurrencySymbol,
            'otherWallets' => $wallets->where('currency', '!=', $this->toCurrency),
            'countrySetting' => $countrySetting,
            'totalWithdrawn' => $totalWithdrawn,
            'pendingWithdrawals' => $pendingWithdrawals,
            'rejectedWithdrawals' => $rejectedWithdrawals
        ]);
    }
}
