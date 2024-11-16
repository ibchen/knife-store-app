<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

/**
 * Class ProductCategorySeeder
 *
 * Сидер для заполнения базы данных начальными категориями продуктов.
 * Используется для создания тестовых категорий в базе данных.
 */
class ProductCategorySeeder extends Seeder
{
    /**
     * Выполняет заполнение базы данных начальными категориями продуктов.
     *
     * Метод создает 10 случайных категорий продуктов с использованием фабрики `ProductCategoryFactory`.
     *
     * @return void
     */
    public function run(): void
    {
        // Создание 10 случайных категорий продуктов
        ProductCategory::factory()
            ->count(10) // Указываем количество создаваемых категорий
            ->create(); // Выполняем создание записей в базе данных
    }
}
