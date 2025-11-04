<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;


class Profile extends Component
{
    public $activeSection = 'basic';

    public function setActiveSection($section)
    {
        $this->activeSection = $section;
    }

    public function render()
    {
        return view('livewire.settings.profile');
    }
}
