<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\CountrySetting;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Verifications extends Component
{
    use WithFileUploads;

    public $verificationRequirements = [];
    public $userVerifications = [];
    
    public $uploads = [];
    public $document_type;

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
            if (!empty($fields['gov_id']['docs'])) {
                $requirements['Government ID'] = [
                    'docs' => $fields['gov_id']['docs'],
                    'mode' => $fields['gov_id']['mode'],
                ];
            }
            if (!empty($fields['address']['docs'])) {
                $requirements['Proof of Address'] = [
                    'docs' => $fields['address']['docs'],
                    'mode' => $fields['address']['mode'],
                ];
            }
        }
        $this->verificationRequirements = $requirements;
    }

    public function saveVerification($docName)
    {
        // $docName is the actual document name (e.g. 'national_id', 'nin', etc.)
        // Find which group (gov_id or address) this docName belongs to
        $user = Auth::user();
        $countrySetting = CountrySetting::where('country_id', $user->country_id)->first();
        $fields = $countrySetting->verification_fields ?? [];

        $documentType = null;
        foreach (['gov_id', 'address'] as $type) {
            if (!empty($fields[$type]['docs']) && in_array($docName, $fields[$type]['docs'])) {
                $documentType = $type;
                break;
            }
        }
        if (!$documentType) {
            session()->flash('status', 'Invalid document type.');
            return;
        }

        $this->validate([
            "uploads.{$docName}" => 'required|mimes:jpeg,png,jpg,pdf|max:2048', // 2MB Max
        ]);

        $file = $this->uploads[$docName];
        $path = $file->store('verifications', 'public');

        \App\Models\UserVerification::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'document_type' => $documentType,
                'document_name' => $docName,
            ],
            [
                'file_path' => $path,
                'status' => 'pending',
                'remarks' => null,
            ]
        );

        $this->loadUserVerifications();
        unset($this->uploads[$docName]);

        session()->flash('status', 'verification-submitted');
    }
    
    public function loadUserVerifications()
    {
        // Now key by document_name for easier lookup
        $this->userVerifications = \App\Models\UserVerification::where('user_id', Auth::id())
            ->get()
            ->keyBy('document_name');
    }

    public function render()
    {
        return view('livewire.settings.verifications');
    }
}
