<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    const STATUS = [
        'pending' => 0,
        'done' => 1,
    ];

    protected $fillable = [
        'tenant_id',
        'email',
        'token',
        'status',
        'user_role'
    ];
}
