<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'message',
        'sent_by',
        'recipients_count',
        'status',
    ];

    protected $casts = [
        'recipients_count' => 'integer',
    ];

    /**
     * Get the user who sent the announcement
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Scope for successful announcements
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed announcements
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
