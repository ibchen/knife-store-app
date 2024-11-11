<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Изменено для поддержки аутентификации
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

//    /**
//     * Шифрование пароля перед сохранением.
//     */
//    public function setPasswordAttribute($password): void
//    {
//        $this->attributes['password'] = bcrypt($password);
//    }

//    public static function newFactory(): CustomerFactory
//    {
//        return CustomerFactory::new();
//    }
}
