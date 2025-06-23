<?php

namespace App\Models;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Model;

class PlatformUser extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'platform_user';

    protected $fillable = [
        'user_id',
        'platform_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
