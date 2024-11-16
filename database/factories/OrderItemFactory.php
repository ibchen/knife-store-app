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
     * Связанная модель фабрики.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Определяет состояние по умолчанию для модели элемента заказа.
     *
     * @return array<string, mixed> Ассоциативный массив с данными для создания модели.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // Связанный заказ (создается фабрикой Order)
            'product_id' => Product::factory(), // Связанный продукт (создается фабрикой Product)
            'quantity' => $this->faker->numberBetween(1, 5), // Случайное количество товара (от 1 до 5)
            'price' => $this->faker->randomFloat(2, 5, 100), // Случайная цена товара с двумя знаками после запятой (от 5 до 100)
        ];
    }
}
