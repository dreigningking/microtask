<?php

namespace App\Models;

use App\Models\Task;
use App\Observers\TaskWorkerObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TaskWorkerObserver::class])]
class TaskWorker extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'user_id',
        'task_id',       
        'saved_at',
        'accepted_at',
        'rejected_at',
        'task_review',
        'task_rating',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'saved_at'=> 'datetime',
        'accepted_at'=> 'datetime',
        'rejected_at'=> 'datetime',
        'deleted_at'=> 'datetime',
    ];

    public function getStatusAttribute(){
        
        if ($this->rejected_at) {
            return 'rejected at ' . $this->rejected_at->format('M d, Y H:i');
        }
        if ($this->accepted_at) {
            return 'accepted at ' . $this->accepted_at->format('M d, Y H:i');
        }
        if ($this->saved_at) {
            return 'saved at ' . $this->saved_at->format('M d, Y H:i');
        }
        return null;
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
