<?php

namespace App\Livewire\DashboardArea;

use Livewire\Component;
use Livewire\Attributes\Layout;


class Transactions extends Component
{
    public $transactions = [];

    public function mount()
    {
        // Sample data
        $this->transactions = [
            [
                'id' => 1,
                'date' => now()->subDays(2)->format('Y-m-d'),
                'amount' => 50.00,
                'currency' => 'USD',
                'type' => 'Subscription',
                'status' => 'Completed',
                'description' => 'Pro Worker Plan',
            ],
            [
                'id' => 2,
                'date' => now()->subDays(10)->format('Y-m-d'),
                'amount' => 10.00,
                'currency' => 'USD',
                'type' => 'Task Payment',
                'status' => 'Completed',
                'description' => 'Task: Write a blog post',
            ],
            [
                'id' => 3,
                'date' => now()->subDays(15)->format('Y-m-d'),
                'amount' => 100.00,
                'currency' => 'USD',
                'type' => 'Withdrawal',
                'status' => 'Pending',
                'description' => 'Bank withdrawal',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-area.transactions');
    }
} 