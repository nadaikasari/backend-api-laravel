<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    // Get the identifier for the JWT.
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Get custom claims for the JWT.
    public function getJWTCustomClaims()
    {
        return [];
    }
}
