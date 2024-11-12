<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CartItem
 *
 * Представляет элемент в корзине пользователя.
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property bool $is_purchased
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class CartItem extends Model
{
    use HasFactory;

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
