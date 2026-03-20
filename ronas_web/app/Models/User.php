<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'is_active',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }

}
