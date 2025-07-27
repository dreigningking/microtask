<?php

namespace App\Livewire\LandingArea;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing-layout')]
class JobCreators extends Component
{
    public function render()
    {
        return view('livewire.landing-area.job-creators');
    }
}
