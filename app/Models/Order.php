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
 * Class Order
 *
 * Представляет заказ пользователя в системе.
 *
 * @property int $id Идентификатор заказа.
 * @property int $user_id Идентификатор пользователя.
 * @property int|null $delivery_address_id Идентификатор адреса доставки.
 * @property OrderStatus $status Статус заказа.
 * @property float $total_price Общая стоимость заказа.
 * @property Carbon|null $created_at Дата и время создания.
 * @property Carbon|null $updated_at Дата и время последнего обновления.
 * @property Customer $user Пользователь, оформивший заказ.
 * @property Address|null $deliveryAddress Адрес доставки.
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
        'delivery_address_id', // Новое поле для адреса доставки
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
     * Получить адрес доставки для заказа.
     *
     * @return BelongsTo
     */
    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'delivery_address_id');
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
