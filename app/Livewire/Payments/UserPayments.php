<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class UserPayments extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        $payments = Payment::with(['order.items.orderable'])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.payments.user-payments', [
            'payments' => $payments
        ]);
    }
}
