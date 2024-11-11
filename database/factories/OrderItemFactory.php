<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для создания моделей элемента заказа.
 */
class OrderItemFactory extends Factory
{
    /**
     * Определяет модель, для которой создается фабрика.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Определяет состояние по умолчанию для модели элемента заказа.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // Создает связанный заказ
            'product_id' => Product::factory(), // Создает связанный продукт
            'quantity' => $this->faker->numberBetween(1, 5), // Случайное количество товара
            'price' => $this->faker->randomFloat(2, 5, 100), // Случайная цена товара
        ];
    }
}
