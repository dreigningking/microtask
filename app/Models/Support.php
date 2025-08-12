<?php

namespace App\Models;

use App\Models\User;
use App\Models\Trail;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'priority',
        'status'
    ];

    protected $casts = [
        'priority' => 'string',
        'status' => 'string'
    ];

    // Priority constants
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_CRITICAL = 'critical';

    // Status constants
    const STATUS_OPEN = 'open';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CLOSED = 'closed';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function trails(){
        return $this->morphMany(Trail::class,'trailable');
    }

    public function scopeLocalize($query)
    {
        if (auth()->user()->first_role->name == 'Super Admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', auth()->user()->country_id);
            });
        });
    }
}
