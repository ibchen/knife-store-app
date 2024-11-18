<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

/**
 * Класс Product
 *
 * Представляет продукт в интернет-магазине.
 *
 * @property int $id Уникальный идентификатор продукта.
 * @property string $name Название продукта.
 * @property string|null $description Описание продукта.
 * @property float $price Цена продукта.
 * @property int $stock Количество доступного товара на складе.
 * @property int|null $category_id Идентификатор категории продукта.
 * @property array|string|null $image_paths Путь или массив путей к изображениям продукта.
 * @property Carbon|null $created_at Дата и время создания продукта.
 * @property Carbon|null $updated_at Дата и время последнего обновления продукта.
 * @property ProductCategory|null $category Категория продукта.
 * @property Collection|CartItem[] $cartItems Элементы корзины, связанные с продуктом.
 * @property Collection|OrderItem[] $orderItems Элементы заказа, связанные с продуктом.
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
        'image_paths',
    ];

    /**
     * Преобразование атрибутов в определенные типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'image_paths' => 'array',
    ];

    /**
     * Доступные фильтры для модели.
     *
     * @var array<string, string>
     */
    protected array $allowedFilters = [
        'name' => Like::class,
        'price' => Like::class,
        'stock' => Like::class,
        'created_at' => Like::class,
    ];

    /**
     * Доступные сортировки для модели.
     *
     * @var array<int, string>
     */
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
        return $this->image_paths ? asset('storage/' . $this->image_paths) : null;
    }
}
