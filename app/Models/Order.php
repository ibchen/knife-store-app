<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Order
 *
 * Представляет заказ пользователя в системе.
 *
 * @property int $id Идентификатор заказа.
 * @property int $user_id Идентификатор пользователя.
 * @property OrderStatus $status Статус заказа.
 * @property float $total_price Общая стоимость заказа.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления.
 * @property \App\Models\Customer $user Пользователь, оформивший заказ.
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems Элементы заказа.
 * @property \App\Models\Payment|null $payment Связанная оплата.
 */
class Order extends Model
{
    use HasFactory;

    /**
     * Доступные для массового заполнения поля.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
    ];

    /**
     * Преобразование атрибутов в определенные типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OrderStatus::class,
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
