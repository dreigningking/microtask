<?php

namespace App\Livewire\DashboardArea\Settings;

use App\Http\Traits\PaymentTrait;
use App\Models\BankAccount;
use App\Models\CountrySetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BankAccounts extends Component
{
    use PaymentTrait;
    
    public $bankAccount;
    public $isEditMode = false;
    public $storage_location;
    public $verification_settings = [];

    public $account_name;
    public $account_number;
    public $bank_name;
    public $bank_code;
    public $branch_code;
    public $swift_code;
    public $iban;

    public $required_fields = [];
    public $banks = [];

    public function mount()
    {
        $this->storage_location = Auth::user()->country->setting->bank_account_storage ?? 'on_premises';
        $this->loadBankAccount();
        $this->loadRequiredFields();
        if ($this->storage_location === 'on_premises') {
            $this->loadBanks();
        }
        $this->loadVerificationSettings();
    }

    public function loadBankAccount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->bankAccount = $user->bank_account;

        if ($this->bankAccount) {
            $this->account_name = $this->bankAccount->account_name;
            $this->account_number = $this->bankAccount->account_number;
            $this->bank_name = $this->bankAccount->bank_name;
            $this->bank_code = $this->bankAccount->bank_code;
            $this->branch_code = $this->bankAccount->branch_code;
            $this->swift_code = $this->bankAccount->swift_code;
            $this->iban = $this->bankAccount->iban;
        }
    }

    public function loadVerificationSettings()
    {
        $countrySetting = CountrySetting::where('country_id', Auth::user()->country_id)->first();
        if ($countrySetting) {
            $this->verification_settings = [
                'required' => $countrySetting->bank_verification_required,
                'method' => $countrySetting->bank_verification_method,
            ];
        }
    }

    public function loadBanks()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $gateway = $user->country->setting->gateway ?? null;
        $countryName = $user->country->name;

        if ($gateway) {
            $allBanks = $this->listBanks($gateway, $countryName);
            if(is_array($allBanks)) {
                $userCurrency = $user->country->currency;
                $this->banks = collect($allBanks)->where('currency', $userCurrency)->all();
            }
        }
    }
    
    public function loadRequiredFields()
    {
        $countrySetting = CountrySetting::where('country_id', Auth::user()->country_id)->first();
        if ($countrySetting && isset($countrySetting->banking_fields)) {
            $this->required_fields = $countrySetting->banking_fields;
        } else {
            $this->required_fields = ['bank_name', 'account_name', 'account_number'];
        }
    }

    public function toggleEditMode()
    {
        $this->isEditMode = !$this->isEditMode;
    }
    
    public function saveBankAccount()
    {
        $rules = [];
        foreach ($this->required_fields as $field) {
            if ($field !== 'bank_name') {
                $rules[$field] = 'required|string|max:255';
            }
        }
        $rules['bank_code'] = 'required';

        $validated = $this->validate($rules);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $selectedBank = collect($this->banks)->firstWhere('code', $this->bank_code);
        $validated['bank_name'] = $selectedBank['name'] ?? null;

        $user->bank_account()->updateOrCreate(['user_id' => $user->id], $validated);
        
        session()->flash('status', 'Bank account details saved successfully.');
        $this->loadBankAccount();
        $this->isEditMode = false;
    }

    public function verifyAccount()
    {
        if (empty($this->verification_settings['required'])) {
            return;
        }

        if ($this->verification_settings['method'] === 'manual') {
            $this->bankAccount->update(['verified_at' => now()]);
            session()->flash('status', 'Bank account verified successfully.');
            $this->loadBankAccount();
        } else {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $gateway = $user->country->setting->gateway ?? null;

            if ($this->verifyBankAccount($gateway, $this->bank_code, $this->account_number,$this->account_name)) {
                $this->bankAccount->update(['verified_at' => now()]);
                session()->flash('status', 'Bank account verified successfully.');
                $this->loadBankAccount();
            } else {
                session()->flash('error', 'We could not verify your bank account at this time. Please try again later.');
            }
        }
    }
    
    public function render()
    {
        return view('livewire.dashboard-area.settings.bank-accounts');
    }
}
