<?php

namespace App\Livewire\Policies;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing')]
class Disclaimer extends Component
{
    public function render()
    {
        return view('livewire.policies.disclaimer');
    }
}
