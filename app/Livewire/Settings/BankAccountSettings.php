<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\BankAccount;
use App\Models\Moderation;
use App\Http\Traits\PaymentTrait;
use Illuminate\Support\Facades\Auth;

class BankAccountSettings extends Component
{
    use PaymentTrait;
    
    public $user;
    public $gateway;
    public $countrySetting;

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
    public $moderation;
    

    public function mount()
    {
        $this->user = Auth::user();
        $this->countrySetting = $this->user->country->setting;
        $this->gateway = $this->countrySetting ? $this->countrySetting->gateway: null;

        $this->storage_location = $this->gateway->bank_account_storage ?? 'on_premises';
        $this->loadBankAccount();

        if ($this->storage_location === 'on_premises') {
            $this->loadEnabledBankingFields();
            $this->loadBanks();
        }

        $this->loadVerificationSettings();
    }

    public function loadBankAccount()
    {

        $this->bankAccount = $this->user->bank_account;

        if ($this->bankAccount) {
            $this->moderation = Moderation::where('moderatable_id', $this->bankAccount->id)
                ->where('moderatable_type', BankAccount::class)
                ->latest()
                ->first();

            if ($this->bankAccount->details) {
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
    }

    public function loadVerificationSettings()
    {
        $countrySetting = $this->countrySetting;
        if ($countrySetting && $countrySetting->banking_settings) {
            $this->verification_settings = [
                'required' => $countrySetting->banking_settings['account_verification_required'],
                'method' => $countrySetting->banking_settings['account_verification_method'],
            ];
        }
    }

    public function loadBanks()
    {
        $gateway = $this->gateway ?? null;
        $countryName = $this->user->country->name;
        if ($gateway) {
            $allBanks = $this->listBanks($gateway->slug, $countryName);
            if(is_array($allBanks)) {
                $userCurrency = $this->user->currency;
                $this->banks = collect($allBanks)->where('currency', $userCurrency)->all();
            }
        }
    }
    
    public function loadEnabledBankingFields()
    {
        $gatewayFields = $this->gateway->banking_fields ?? [];
        $countryFields = $this->countrySetting->banking_fields ?? [];
        //dd($countryFields);
        $enabledFields = [];
        foreach ($gatewayFields as $field) {
            $slug = $field['slug'];
            $countryField = collect($countryFields)->firstWhere('slug', $slug);
            $enabledFields[] = array_merge($field, ['country_config' => $countryField]);
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
            if ($field['country_config'] && ($field['country_config']['enable'] ?? false)) {
                $slug = $field['slug'];
                $isRequired = $field['country_config']['required'] ?? false;
                $rules[$slug] = $isRequired ? 'required' : 'nullable';
                if ($field['type'] === 'number') {
                    $rules[$slug] .= '|numeric';
                } elseif ($field['type'] === 'email') {
                    $rules[$slug] .= '|email';
                } elseif ($field['type'] === 'text' || $field['type'] === 'tel') {
                    $rules[$slug] .= '|string';
                }
                if (isset($field['min_length'])) {
                    $rules[$slug] .= '|min:' . $field['min_length'];
                }
                if (isset($field['max_length'])) {
                    $rules[$slug] .= '|max:' . $field['max_length'];
                }
            }
        }

        $validated = $this->validate($rules);
        $details = [];
        foreach ($this->required_fields as $field) {
            $slug = $field['slug'];
            $details[$slug] = $validated[$slug] ?? null;
        }
        if (isset($details['bank_code'])) {
            $selectedBank = collect($this->banks)->firstWhere('code', $details['bank_code']);
            $details['bank_name'] = $selectedBank['name'] ?? null;
        }
        BankAccount::updateOrCreate(['user_id' => $this->user->id,'gateway_id'=> $this->gateway->id], ['details' => $details, 'verified_at' => null]);

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
            Moderation::create([
                'moderatable_id' => $this->bankAccount->id,
                'moderatable_type' => BankAccount::class,
                'purpose' => 'bank account update',
                'status' => 'pending',
            ]);
            session()->flash('status', 'Bank account verification request submitted successfully.');
            $this->loadBankAccount();
        } else {
            /** @var \App\Models\User $user */
            $gateway = $this->gateway ?? null;

            if ($this->verifyBankAccount($gateway->slug, $this->bank_code, $this->account_number,strtolower($this->account_name))) {
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
        return view('livewire.settings.bank-account-settings');
    }
}
