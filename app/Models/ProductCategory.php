<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

/**
 * Класс ProductCategory
 *
 * Представляет категорию продуктов в интернет-магазине.
 *
 * @property int $id Уникальный идентификатор категории.
 * @property string $name Название категории.
 * @property string $description Описание категории.
 * @property \Illuminate\Support\Carbon|null $created_at Дата и время создания категории.
 * @property \Illuminate\Support\Carbon|null $updated_at Дата и время последнего обновления категории.
 * @property \Illuminate\Database\Eloquent\Collection|Product[] $products Продукты, относящиеся к данной категории.
 */
class ProductCategory extends Model
{
    use HasFactory, AsSource;

    /**
     * Поля, доступные для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Получить продукты, относящиеся к данной категории.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
