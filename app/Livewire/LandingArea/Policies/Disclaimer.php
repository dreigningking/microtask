<?php

namespace App\Livewire\LandingArea\Policies;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing-layout')]
class Disclaimer extends Component
{
    public function render()
    {
        return view('livewire.landing-area.policies.disclaimer');
    }
}
