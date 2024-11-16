<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Orchid\Screen\AsSource;

/**
 * Класс Order
 *
 * Представляет заказ пользователя в системе.
 *
 * @property int $id Уникальный идентификатор заказа.
 * @property int $user_id Идентификатор пользователя, который оформил заказ.
 * @property array|null $delivery_address JSON-адрес доставки.
 * @property OrderStatus $status Текущий статус заказа.
 * @property float $total_price Общая стоимость заказа.
 * @property Carbon|null $created_at Дата и время создания заказа.
 * @property Carbon|null $updated_at Дата и время последнего обновления заказа.
 * @property Customer $user Пользователь, оформивший заказ.
 * @property Collection|OrderItem[] $orderItems Элементы заказа.
 * @property Payment|null $payment Связанная оплата.
 */
class Order extends Model
{
    use HasFactory, AsSource;

    /**
     * Доступные для массового заполнения поля.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'delivery_address', // Поле для JSON-адреса доставки.
    ];

    /**
     * Преобразование атрибутов в определенные типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OrderStatus::class, // Преобразование статуса заказа в enum.
        'delivery_address' => 'array', // Преобразование delivery_address в массив.
    ];

    /**
     * Получить пользователя, который оформил заказ.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Получить элементы, связанные с заказом.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Получить оплату, связанную с заказом.
     *
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
