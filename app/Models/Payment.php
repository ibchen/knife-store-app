<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

/**
 * Класс Payment
 *
 * Представляет оплату для заказа.
 *
 * @property int $id Уникальный идентификатор записи оплаты.
 * @property int $order_id Идентификатор связанного заказа.
 * @property float $amount Сумма оплаты.
 * @property PaymentStatus $status Статус оплаты.
 * @property \Illuminate\Support\Carbon|null $payment_date Дата и время оплаты.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания записи.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления записи.
 * @property Order $order Заказ, связанный с оплатой.
 */
class Payment extends Model
{
    use HasFactory, AsSource;

    /**
     * Доступные для массового заполнения поля.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'payment_date',
    ];

    /**
     * Преобразование атрибутов в определенные типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => PaymentStatus::class, // Преобразование статуса оплаты в enum.
        'payment_date' => 'datetime', // Преобразование даты оплаты в объект Carbon.
    ];

    /**
     * Получить заказ, связанный с оплатой.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
