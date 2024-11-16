<?php

namespace App\Models;

use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Platform\Models\User as Authenticatable;

/**
 * Класс User
 *
 * Представляет пользователя в системе.
 *
 * @property int $id Уникальный идентификатор пользователя.
 * @property string $name Имя пользователя.
 * @property string $email Электронная почта пользователя.
 * @property string|null $password Хэшированный пароль пользователя.
 * @property \Illuminate\Support\Carbon|null $email_verified_at Дата и время подтверждения электронной почты.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания пользователя.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления пользователя.
 * @property array|null $permissions Разрешения пользователя.
 */
class User extends Authenticatable
{
    /**
     * Атрибуты, доступные для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Атрибуты, скрытые из JSON-представления модели.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Атрибуты, по которым можно использовать фильтры в URL.
     *
     * @var array<string, string>
     */
    protected $allowedFilters = [
        'id' => Where::class,
        'name' => Like::class,
        'email' => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * Атрибуты, по которым можно использовать сортировку в URL.
     *
     * @var array<int, string>
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];
}
