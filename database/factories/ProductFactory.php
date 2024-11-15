<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Список осмысленных продуктов
        $products = [
            ["name" => "Охотничий нож \"Тайга\"", "description" => "Прочный и надежный нож для охоты в любых погодных условиях."],
            ["name" => "Кухонный нож \"Шеф\"", "description" => "Идеальный инструмент для профессиональной нарезки."],
            ["name" => "Складной нож \"Универсал\"", "description" => "Компактный нож для повседневного использования."],
            ["name" => "Нож для резьбы \"Мастер\"", "description" => "Художественный нож для резьбы по дереву."],
            ["name" => "Коллекционный нож \"Легенда\"", "description" => "Эксклюзивный нож с уникальной гравировкой."],
            // Добавьте еще до 50 записей
        ];

        // Выбираем случайный продукт без уникальности
        $product = $this->faker->randomElement($products);

        // Список локальных изображений
        $localImages = [
            'images/products/default_knife_1.webp',
            'images/products/default_knife_2.webp',
            'images/products/default_knife_3.jpg',
            'images/products/default_knife_4.jpg',
            'images/products/default_knife_5.webp',
        ];

        // Генерация массива изображений
        $imagePaths = $this->faker->randomElements($localImages, rand(3, 5));

        return [
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'stock' => $this->faker->numberBetween(10, 200),
            'image_path' => json_encode($imagePaths),
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
        ];
    }
}
