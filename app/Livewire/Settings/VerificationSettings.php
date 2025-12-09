<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\CountrySetting;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class VerificationSettings extends Component
{
    use WithFileUploads;

    public $verificationRequirements = [];
    public $userVerifications = [];

    public $uploads = [];
    public $document_type;
    public $submitting = [];
    public $issued_at = [];
    public $expiry_at = [];
    public $never_expires = [];

    public function mount()
    {
        $this->loadRequirements();
        $this->loadUserVerifications();
    }

    public function loadRequirements()
    {
        $user = Auth::user();
        $countrySetting = CountrySetting::where('country_id', $user->country_id)->first();
        
        $requirements = [];
        if ($countrySetting && !empty($countrySetting->verification_fields)) {
            $fields = $countrySetting->verification_fields;
            if (!empty($fields['govt_id']['file'])) {
                $requirements['Government ID'] = [
                    'docs' => $fields['govt_id']['file'],
                    'mode' => $fields['govt_id']['require'],
                    'issue_date' => $fields['govt_id']['issue_date'] ?? false,
                    'expiry_date' => $fields['govt_id']['expiry_date'] ?? false,
                ];
            }
            if (!empty($fields['address']['file'])) {
                $requirements['Proof of Address'] = [
                    'docs' => $fields['address']['file'],
                    'mode' => $fields['address']['require'],
                    'issue_date' => $fields['address']['issue_date'] ?? false,
                    'expiry_date' => $fields['address']['expiry_date'] ?? false,
                ];
            }
        }
        $this->verificationRequirements = $requirements;
    }

    public function saveVerification($docName)
    {
        $this->submitting[$docName] = true;

        /*Previously
         $docName is the actual document name (e.g. 'national_id', 'nin', etc.)
         Find which group (gov_id or address) this docName belongs to
         Now
        document: e.g 'govt_id','address'
        document_name e.g "utility_bill,national_id, nin"
        */
        $user = Auth::user();
        $countrySetting = CountrySetting::where('country_id', $user->country_id)->first();
        $fields = $countrySetting->verification_fields ?? [];

        $document = null;
        $fieldConfig = null;
        foreach (['govt_id', 'address'] as $type) {
            if (!empty($fields[$type]['file']) && in_array($docName, $fields[$type]['file'])) {
                $document = $type;
                $fieldConfig = $fields[$type];
                break;
            }
        }
        if (!$document) {
            $this->submitting[$docName] = false;
            session()->flash('status', 'Invalid document type.');
            return;
        }

        $rules = [
            "uploads.{$docName}" => 'required|mimes:jpeg,png,jpg,pdf|max:2048', // 2MB Max
        ];

        $rules["issued_at.{$docName}"] = 'required|date';

        if (!($this->never_expires[$docName] ?? false)) {
            $rules["expiry_at.{$docName}"] = 'required|date|after:today';
        }

        $this->validate($rules);

        $file = $this->uploads[$docName];
        $path = $file->store('verifications', 'public');

        $expireAt = null;
        if (!($this->never_expires[$docName] ?? false)) {
            $expireAt = $this->expiry_at[$docName];
        }

        UserVerification::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'document' => $document,
                'document_name' => $docName,
            ],
            [
                'file_path' => $path,
                'issued_at' => $this->issued_at[$docName] ?? null,
                'expire_at' => $expireAt,
            ]
        );

        $this->loadUserVerifications();
        unset($this->uploads[$docName]);
        unset($this->issued_at[$docName]);
        unset($this->expiry_at[$docName]);
        unset($this->never_expires[$docName]);

        $this->submitting[$docName] = false;

        session()->flash('status', 'verification-submitted');
    }
    
    public function loadUserVerifications()
    {
        // Now key by document_name for easier lookup
        $this->userVerifications = \App\Models\UserVerification::where('user_id', Auth::id())
            ->with('latestModeration')
            ->get()
            ->keyBy('document_name');
    }

    public function render()
    {
        return view('livewire.settings.verification-settings');
    }
}
