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
    protected $fillable = ['user_id','subject','description','priority','status'];

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
        if (auth()->user()->admin->hasRole('super-admin')) {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', auth()->user()->country_id);
            });
        });
    }
}
