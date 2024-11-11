<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для создания моделей заказа.
 */
class OrderFactory extends Factory
{
    /**
     * Определяет модель, для которой создается фабрика.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Определяет состояние по умолчанию для модели заказа.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Создает пользователя и связывает его с заказом
            'status' => OrderStatus::Pending->value, // Статус по умолчанию (ожидание)
            'total_price' => $this->faker->randomFloat(2, 20, 500), // Случайная общая стоимость
        ];
    }
}
