<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Trail extends Model
{

    protected $fillable = ['trailable_id','trailable_type','user_id','assigned_by','message'];

    public function trailable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function assigner(){
        return $this->belongsTo(User::class,'assigned_by');
    }
}
