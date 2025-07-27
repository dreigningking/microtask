<?php

namespace App\Livewire\LandingArea;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing-layout')]
class TopEarners extends Component
{
    public function render()
    {
        return view('livewire.landing-area.top-earners');
    }
}
