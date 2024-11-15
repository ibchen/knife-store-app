<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

/**
 * Class ProductSeeder
 *
 * Заполняет базу данных начальными категориями и продуктами.
 */
class ProductSeeder extends Seeder
{
    /**
     * Запустить заполнение базы данных продуктами.
     *
     * @return void
     */
    public function run(): void
    {
        Product::factory()->count(20)->create();
    }
}
