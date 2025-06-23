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

    public function loadUserVerifications()
    {
        $this->userVerifications = UserVerification::where('user_id', Auth::id())
            ->get()
            ->keyBy('document_type');
    }

    public function saveVerification($docType)
    {
        $this->validate([
            "uploads.{$docType}" => 'required|mimes:jpeg,png,jpg,pdf|max:2048', // 2MB Max
        ]);

        $file = $this->uploads[$docType];
        $path = $file->store('verifications', 'public');

        UserVerification::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'document_type' => $docType,
            ],
            [
                'file_path' => $path,
                'status' => 'pending',
                'remarks' => null,
            ]
        );
        
        $this->loadUserVerifications();
        unset($this->uploads[$docType]);

        session()->flash('status', 'verification-submitted');
    }
    
    public function render()
    {
        return view('livewire.settings.verifications');
    }
}
