<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Имя модели, с которой связана фабрика.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Определить стандартное состояние модели.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 5, 500),
            'stock' => $this->faker->numberBetween(1, 100),
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
        ];
    }
}
