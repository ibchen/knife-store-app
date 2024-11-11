<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

/**
 * Class ProductCategorySeeder
 *
 * Заполняет базу данных начальными категориями продуктов.
 */
class ProductCategorySeeder extends Seeder
{
    /**
     * Запустить заполнение базы данных категориями продуктов.
     *
     * @return void
     */
    public function run(): void
    {
        // Создание 10 случайных категорий
        ProductCategory::factory()->count(10)->create();
    }
}
