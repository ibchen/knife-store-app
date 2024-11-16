<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

/**
 * Класс CartItem
 *
 * Представляет элемент в корзине пользователя.
 *
 * @property int $id Идентификатор элемента корзины.
 * @property int $user_id Идентификатор пользователя, которому принадлежит элемент.
 * @property int $product_id Идентификатор продукта.
 * @property int $quantity Количество продукта.
 * @property bool $is_purchased Указывает, был ли элемент куплен.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания элемента.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления элемента.
 */
class CartItem extends Model
{
    use HasFactory, AsSource;

    /**
     * Поля, доступные для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'is_purchased',
    ];

    /**
     * Получить пользователя, которому принадлежит элемент корзины.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Получить продукт, связанный с элементом корзины.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
