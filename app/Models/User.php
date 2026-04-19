<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'secret',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'reported_by');
    }

    public function claimedItems()
    {
        return $this->hasMany(Item::class, 'claimed_by');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}

