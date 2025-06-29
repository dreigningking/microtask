<?php

namespace App\Livewire\Policies;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public $title = 'Privacy Policy | Wonegig';
    public $meta_title = 'Privacy Policy - Wonegig';
    public $meta_description = 'Read Wonegig\'s privacy policy to learn how we protect your data and privacy.';

    public function render()
    {
        return view('livewire.policies.privacy-policy');
    }
}
