<?php

namespace Iamnotstatic\LaravelAPIAuth\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['email', 'token'];
}
