<?php

namespace App\Livewire;


use App\Models\User;
use Livewire\Component;
use App\Models\Referral;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


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

        // // Attach computed status for each referral
        // $referrals->getCollection()->transform(function ($ref) {
        //     $inviteeUser = User::where('email', $ref->email)->first();
        //     if (!$inviteeUser) {
        //         $ref->invitee_status = 'Pending Registration';
        //     } elseif ($ref->task_id && $ref->task) {
        //         if ($ref->task->workers && $ref->task->workers->where('user_id', $inviteeUser->id)->whereHas('taskSubmissions', function($q) {
        //             $q->whereNotNull('paid_at');
        //         })->count()) {
        //             $ref->invitee_status = 'Completed';
        //         } else {
        //             $ref->invitee_status = 'Pending Completion';
        //         }
        //     } else {
        //         $ref->invitee_status = 'Registered';
        //     }
        //     return $ref;
        // });

        return view('livewire.invitees-list', [
            'referrals' => $referrals
        ]);
    }
}
