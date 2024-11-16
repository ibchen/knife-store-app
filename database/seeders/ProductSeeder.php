<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Class ProductSeeder
 *
 * Сидер для заполнения базы данных начальными продуктами.
 */
class ProductSeeder extends Seeder
{
    /**
     * Выполняет заполнение базы данных начальными продуктами.
     *
     * Метод создает 20 случайных продуктов с использованием фабрики `ProductFactory`.
     * Категории продуктов предварительно должны быть созданы для корректного распределения.
     *
     * @return void
     */
    public function run(): void
    {
        // Создание 20 случайных продуктов
        Product::factory()
            ->count(20) // Указываем количество создаваемых продуктов
            ->create(); // Выполняем создание записей в базе данных
    }
}
