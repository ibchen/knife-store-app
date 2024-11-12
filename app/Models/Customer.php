<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
