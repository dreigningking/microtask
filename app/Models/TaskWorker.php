<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskWorker extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'user_id',
        'task_id',       
        'submission_restricted_at',
        'worker_review',
        'worker_rating',
    ];

    protected $casts = [
        
    ];


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
