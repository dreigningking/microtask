<?php

namespace App\Livewire\Policies;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing')]
class PaymentDisputeChargebacks extends Component
{
    public function render()
    {
        return view('livewire.policies.payment-dispute-chargebacks');
    }
}
