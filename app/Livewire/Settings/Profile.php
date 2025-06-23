<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Profile extends Component
{
    public function render()
    {
        return view('livewire.settings.profile');
    }
}
