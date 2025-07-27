<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $fillable = [
        'user_id',
        'document_type',
        'document_name',
        'file_path',
        'status',
        'remarks',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
