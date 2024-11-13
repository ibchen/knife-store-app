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
        // Массив с путями к локальным изображениям
        $localImages = [
            'images/products/default_knife_1.webp',
            'images/products/default_knife_2.webp',
            'images/products/default_knife_3.jpg',
            'images/products/default_knife_4.jpg',
            'images/products/default_knife_5.webp',
        ];

        // Генерация массива изображений из от трех до пяти случайных элементов
        $imagePaths = $this->faker->randomElements($localImages, rand(3, 5));

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 5, 500),
            'stock' => $this->faker->numberBetween(1, 100),
            'image_path' => json_encode($imagePaths), // Сохраняем массив изображений в формате JSON
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
        ];
    }
}
