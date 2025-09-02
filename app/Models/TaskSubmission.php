<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskWorker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TaskSubmission extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'task_id',
        'task_worker_id',
        'paid_at',
        'disputed_at',
        'resolved_at',
        'completed_at',
        'submissions',
        'review',
        'review_reason',
    ];

    protected $casts = [
        'paid_at'=> 'datetime',
        'disputed_at'=> 'datetime',
        'resolved_at'=> 'datetime',
        'completed_at'=> 'datetime',
        'deleted_at'=> 'datetime',
        'submissions'=> 'array'
    ];

    public function getStatusAttribute(){
        $hours = Setting::getValue('submission_review_deadline');
        if ($this->completed_at) {
            return 'completed at ' . $this->completed_at->format('M d, Y H:i');
        }
        if ($this->disputed_at) {
            if ($this->resolved_at) {
                return 'dispute resolved at ' . $this->resolved_at->format('M d, Y H:i');
            }
            return 'disputed at ' . $this->disputed_at->format('M d, Y H:i');
        }
        
        if ($this->paid_at) {
            return 'paid at ' . $this->paid_at->format('M d, Y H:i');
        }
        if ($this->created_at->diffInHours($this->completed_at) > $hours) {
            return 'overdue review';
        }
        
        return 'pending review since ' . $this->created_at->format('M d, Y H:i');
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function task_worker(){
        return $this->belongsTo(TaskWorker::class);
    }
    
    
}
