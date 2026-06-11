<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    public function isAdmin() {
        return $this->role === 'administrators';
    }

    public function isMaster() {
        return $this->role === 'meistars';
    }

    public function isClient() {
        return $this->role === 'klients';
    }

    public function klients()
    {
        return $this->hasOne(Klients::class, 'user_id', 'id');
    }

    public function meistars()
    {
        return $this->hasOne(Meistars::class, 'user_id', 'id');
    }
}