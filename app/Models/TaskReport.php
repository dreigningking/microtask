<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskReport extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'reason',
        'description',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getReasonLabelAttribute()
    {
        return match($this->reason) {
            'broken_link' => 'Broken Link',
            'unclear_instructions' => 'Unclear Instructions',
            'takes_longer_than_2_hours' => 'Takes Longer Than 2 Hours',
            'other' => 'Other',
            default => ucfirst(str_replace('_', ' ', $this->reason))
        };
    }
} 