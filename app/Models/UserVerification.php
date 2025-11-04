<?php

namespace App\Models;

use App\Models\Moderation;
use Illuminate\Database\Eloquent\Model;
use App\Observers\UserVerificationObserver;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([UserVerificationObserver::class])]
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

    public function moderations(): MorphMany
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    public function latestModeration(): MorphOne
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
    }
}
