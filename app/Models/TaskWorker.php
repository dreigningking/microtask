<?php

namespace App\Models;

use App\Models\Task;
use App\Observers\TaskWorkerObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TaskWorkerObserver::class])]
class TaskWorker extends Model
{


    protected $fillable = [
        'task_id',
        'user_id',
        'status',
        'saved_at',
        'accepted_at',
        'cancelled_at',
        'submitted_at',
        'paid_at',
        'disputed_at',
        'resolved_at',
        'completed_at',
        'submissions',
        'review',
        'rating',
        'created_at',
        'updated_at'
    ];

    protected $casts = ['saved_at'=> 'datetime',
        'accepted_at'=> 'datetime',
        'cancelled_at'=> 'datetime',
        'submitted_at'=> 'datetime',
        'paid_at'=> 'datetime',
        'disputed_at'=> 'datetime',
        'resolved_at'=> 'datetime',
        'completed_at'=> 'datetime',
        'submissions'=> 'array'
    ];

    public function getStatusAttribute(){
        if ($this->completed_at) {
            return 'completed at ' . $this->completed_at->format('M d, Y H:i');
        }
        if ($this->resolved_at) {
            return 'resolved at ' . $this->resolved_at->format('M d, Y H:i');
        }
        if ($this->disputed_at) {
            return 'disputed at ' . $this->disputed_at->format('M d, Y H:i');
        }
        if ($this->paid_at) {
            return 'paid at ' . $this->paid_at->format('M d, Y H:i');
        }
        if ($this->submitted_at) {
            return 'submitted at ' . $this->submitted_at->format('M d, Y H:i');
        }
        if ($this->cancelled_at) {
            return 'cancelled at ' . $this->cancelled_at->format('M d, Y H:i');
        }
        if ($this->accepted_at) {
            return 'accepted at ' . $this->accepted_at->format('M d, Y H:i');
        }
        if ($this->saved_at) {
            return 'saved at ' . $this->saved_at->format('M d, Y H:i');
        }
        return 'pending';
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
