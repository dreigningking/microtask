<?php

namespace App\Livewire\Settings;

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
    public $phone_number;
    public $bvn;
    public $branch;
    public $sort_code;
    public $ifsc_code;
    public $routing_number;
    public $iban_number;
    public $paypal_email;

    public $required_fields = [];
    public $banks = [];

    public function mount()
    {
        $user = Auth::user();
        $countrySetting = $user->country->setting;
        $gateway = $countrySetting->gateway;

        $this->storage_location = $gateway->bank_account_storage ?? 'on_premises';
        dd($gateway);
        $this->loadBankAccount();

        if ($this->storage_location === 'on_premises') {
            $this->loadEnabledBankingFields($gateway, $countrySetting);
            $this->loadBanks();
        }

        $this->loadVerificationSettings();
    }

    public function loadBankAccount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->bankAccount = $user->bank_account;

        if ($this->bankAccount && $this->bankAccount->details) {
            $details = $this->bankAccount->details;
            $this->account_name = $details['account_name'] ?? null;
            $this->account_number = $details['account_number'] ?? null;
            $this->bank_name = $details['bank_name'] ?? null;
            $this->bank_code = $details['bank_code'] ?? null;
            $this->branch_code = $details['branch_code'] ?? null;
            $this->swift_code = $details['swift_code'] ?? null;
            $this->iban = $details['iban'] ?? null;
            $this->phone_number = $details['phone_number'] ?? null;
            $this->bvn = $details['bvn'] ?? null;
            $this->branch = $details['branch'] ?? null;
            $this->sort_code = $details['sort_code'] ?? null;
            $this->ifsc_code = $details['ifsc_code'] ?? null;
            $this->routing_number = $details['routing_number'] ?? null;
            $this->iban_number = $details['iban_number'] ?? null;
            $this->paypal_email = $details['paypal_email'] ?? null;
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
    
    public function loadEnabledBankingFields($gateway, $countrySetting)
    {
        $gatewayFields = $gateway->banking_fields ?? [];
        $countryFields = $countrySetting->banking_fields ?? [];

        $enabledFields = [];
        foreach ($gatewayFields as $field) {
            $countryField = collect($countryFields)->firstWhere('slug', $field['slug']);
            if ($countryField && ($countryField['enabled'] ?? false)) {
                $enabledFields[] = $field;
            }
        }

        $this->required_fields = $enabledFields;
    }

    public function toggleEditMode()
    {
        $this->isEditMode = !$this->isEditMode;
    }
    
    public function saveBankAccount()
    {
        $rules = [];
        foreach ($this->required_fields as $field) {
            $slug = $field['slug'];
            $rules[$slug] = 'required';
            if ($field['type'] === 'number') {
                $rules[$slug] .= '|numeric';
                if (isset($field['min_length'])) {
                    $rules[$slug] .= '|min:' . $field['min_length'];
                }
                if (isset($field['max_length'])) {
                    $rules[$slug] .= '|max:' . $field['max_length'];
                }
            } elseif ($field['type'] === 'email') {
                $rules[$slug] .= '|email';
            } elseif ($field['type'] === 'text' || $field['type'] === 'tel') {
                $rules[$slug] .= '|string|max:255';
            }
        }

        $validated = $this->validate($rules);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (isset($validated['bank_code'])) {
            $selectedBank = collect($this->banks)->firstWhere('code', $validated['bank_code']);
            $validated['bank_name'] = $selectedBank['name'] ?? null;
        }

        $user->bank_account()->updateOrCreate(['user_id' => $user->id], ['details' => $validated]);

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
        return view('livewire.settings.bank-accounts');
    }
}
