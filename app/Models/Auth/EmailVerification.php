<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = ['email', 'token', 'expired_at'];
}
