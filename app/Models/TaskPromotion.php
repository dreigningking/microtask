<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPromotion extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'type',
        'days',
        'start_at',
        'cost',
        'currency',
        'created_at',
        'updated_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExpiresAtAttribute(){
        return $this->created_at->addDays($this->days);
    }
}
