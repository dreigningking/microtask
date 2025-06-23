<?php

namespace App\Livewire\Referrals;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\User;
use App\Models\Task;

class InviteesList extends Component
{
    use WithPagination;

    public $perPage = 10;

    public function render()
    {
        $user = Auth::user();
        $referrals = Referral::where('referrer_id', $user->id)
            ->with('task')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        // Attach computed status for each referral
        $referrals->getCollection()->transform(function ($ref) {
            $inviteeUser = User::where('email', $ref->email)->first();
            if (!$inviteeUser) {
                $ref->invitee_status = 'Pending Registration';
            } elseif ($ref->task_id && $ref->task) {
                if ($ref->task->workers && $ref->task->workers->where('user_id', $inviteeUser->id)->whereNotNull('completed_at')->count()) {
                    $ref->invitee_status = 'Completed';
                } else {
                    $ref->invitee_status = 'Pending Completion';
                }
            } else {
                $ref->invitee_status = 'Registered';
            }
            return $ref;
        });

        return view('livewire.referrals.invitees-list', [
            'referrals' => $referrals
        ]);
    }
}
