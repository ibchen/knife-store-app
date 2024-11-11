<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    use HasFactory;

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
