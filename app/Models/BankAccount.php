<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $connection = 'mysql';
    
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_code',
        'account_name',
        'account_number',
        'verified_at'
    ];
}
