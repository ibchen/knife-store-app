<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
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
        $customer = Customer::factory()->create(); // Создаем пользователя

        // Генерация случайного адреса доставки в формате JSON
        $deliveryAddress = [
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house' => $this->faker->buildingNumber,
            'apartment' => $this->faker->optional()->randomNumber(2),
            'postal_code' => $this->faker->postcode,
        ];

        return [
            'user_id' => $customer->id,                   // Присваиваем ID пользователя
            'delivery_address' => $deliveryAddress,       // JSON-адрес доставки
            'status' => OrderStatus::Pending->value,      // Статус по умолчанию (ожидание)
            'total_price' => $this->faker->randomFloat(2, 20, 500), // Случайная общая стоимость
        ];
    }
}
