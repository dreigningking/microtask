<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $fillable = ['user_id','referree_id','task_id','status'];
    
    /**
     * Get the user who made the referral.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referree()
    {
        return $this->belongsTo(User::class, 'referree_id');
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
