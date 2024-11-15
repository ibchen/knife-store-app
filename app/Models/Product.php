<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

/**
 * Class Product
 *
 * Представляет продукт в интернет-магазине.
 */
class Product extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    /**
     * Массово назначаемые атрибуты.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image_path',
    ];

    protected $casts = [
        'image_path' => 'array',
    ];

    protected array $allowedFilters = [
        'name' => Like::class,
        'price' => Like::class,
        'stock' => Like::class,
        'created_at' => Like::class,
    ];

    protected array $allowedSorts = [
        'name',
        'price',
        'stock',
        'created_at',
    ];

    /**
     * Получить категорию, к которой относится продукт.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Получить элементы корзины, связанные с продуктом.
     *
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Получить элементы заказа, связанные с продуктом.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Возвращает полный URL к изображению продукта.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
