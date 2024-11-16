<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Screen\AsSource;

/**
 * Класс Customer
 *
 * Представляет клиента, который может аутентифицироваться, получать уведомления и управлять адресами.
 *
 * @property int $id Уникальный идентификатор клиента.
 * @property string $name Имя клиента.
 * @property string $email Электронная почта клиента.
 * @property string $password Хэш пароля клиента.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания клиента.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления клиента.
 */
class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, AsSource;

    /**
     * Поля, доступные для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Поля, которые должны быть скрыты в JSON-ответах.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Получить адреса, связанные с клиентом.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
