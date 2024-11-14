<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

/**
 * Class ProductCategory
 *
 * Представляет категорию продуктов в интернет-магазине.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class ProductCategory extends Model
{
    use HasFactory, AsSource;

    /**
     * Получить продукты, относящиеся к данной категории.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
