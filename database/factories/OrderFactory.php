<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для создания моделей заказа (Order).
 */
class OrderFactory extends Factory
{
    /**
     * Связанная модель фабрики.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Определяет значения по умолчанию для модели заказа.
     *
     * @return array<string, mixed> Массив данных для модели Order.
     */
    public function definition(): array
    {
        // Генерация случайного адреса доставки в формате JSON
        $deliveryAddress = [
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house' => $this->faker->buildingNumber,
            'apartment' => $this->faker->optional()->numerify('##'),
            'postal_code' => $this->faker->postcode,
        ];

        return [
            // Связанный пользователь (создаётся через CustomerFactory)
            'user_id' => Customer::factory(),

            // Адрес доставки
            'delivery_address' => $deliveryAddress,

            // Статус заказа (по умолчанию - "ожидание")
            'status' => OrderStatus::Pending->value,

            // Общая стоимость заказа (случайное значение от 20 до 500)
            'total_price' => $this->faker->randomFloat(2, 20, 500),
        ];
    }
}
