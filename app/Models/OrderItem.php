<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

/**
 * Класс OrderItem
 *
 * Представляет элемент в заказе.
 *
 * @property int $id Уникальный идентификатор элемента заказа.
 * @property int $order_id Идентификатор связанного заказа.
 * @property int $product_id Идентификатор связанного продукта.
 * @property int $quantity Количество товара в элементе заказа.
 * @property float $price Цена товара на момент заказа.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания элемента.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления элемента.
 * @property Order $order Заказ, которому принадлежит элемент.
 * @property Product $product Продукт, связанный с элементом заказа.
 */
class OrderItem extends Model
{
    use HasFactory, AsSource;

    /**
     * Доступные для массового заполнения поля.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Получить заказ, которому принадлежит элемент заказа.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Получить продукт, связанный с элементом заказа.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
