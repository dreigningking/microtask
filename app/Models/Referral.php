<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $fillable = ['referrer_id', 'task_id', 'email', 'type', 'status', 'expire_at'];
    public $casts = ['expire_at'=> 'datetime'];
    /**
     * Get the user who made the referral.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the task associated with the referral.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who was referred (the invitee).
     */
    public function invitee()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
