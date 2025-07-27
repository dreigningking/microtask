<?php

namespace App\Livewire\DashboardArea\Settings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;


class Profile extends Component
{
    public function render()
    {
        return view('livewire.dashboard-area.settings.profile');
    }
}
