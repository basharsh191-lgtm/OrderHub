<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class otp_user extends Model
{
   protected $fillable = ['phone_Number','otp','expires_at'];
protected $casts = [
        'expires_at' => 'datetime',
    ];
}
