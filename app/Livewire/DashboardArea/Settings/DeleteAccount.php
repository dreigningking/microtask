<?php

namespace App\Livewire\DashboardArea\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteAccount extends Component
{
    public $password = '';
    public bool $confirming = false;

    public function confirmDeletion()
    {
        $this->resetErrorBag();
        $this->password = '';
        $this->confirming = true;
    }

    public function deleteAccount()
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Add this line to fix linter error
        if ($user) {
            $user->delete();
            Auth::logout();
            return redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.dashboard-area.settings.delete-account');
    }
}
