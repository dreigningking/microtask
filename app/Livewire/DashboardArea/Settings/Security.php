<?php

namespace App\Livewire\DashboardArea\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\LoginActivity;

class Security extends Component
{
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';
    public $two_factor_enabled;
    public $enforce_2fa;
    public $recent_logins = [];

    public function mount()
    {
        $user = Auth::user();
        $this->two_factor_enabled = (bool) $user->two_factor_enabled;
        $this->enforce_2fa = (bool) Setting::getValue('enable_2fa', false);
        $this->recent_logins = LoginActivity::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();
    }

    protected function rules()
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function updatePassword()
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('status', 'Password updated successfully.');
    }

    public function toggle2FA()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($this->enforce_2fa) {
            // Do not allow user to disable if enforced
            $this->two_factor_enabled = true;
            return;
        }
        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->save();
        $this->two_factor_enabled = $user->two_factor_enabled;
        session()->flash('success', $user->two_factor_enabled ? 'Two-factor authentication enabled.' : 'Two-factor authentication disabled.');
    }

    public function logoutAllDevices()
    {
        $user = Auth::user();
        // Invalidate all sessions except current
        DB::table('sessions')->where('user_id', $user->id)->where('id', '!=', Session::getId())->delete();
        session()->flash('success', 'Logged out from all other devices.');
    }

    public function render()
    {
        return view('livewire.dashboard-area.settings.security');
    }
}
