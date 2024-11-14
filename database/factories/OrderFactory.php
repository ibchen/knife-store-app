<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Address;
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
        // Создаем пользователя и один из его адресов для использования в заказе
        $customer = Customer::factory()->create(); // Создаем пользователя
        $address = $customer->addresses()->inRandomOrder()->first() ?? Address::factory()->for($customer)->create();

        return [
            'user_id' => $customer->id,                   // Присваиваем ID пользователя
            'delivery_address_id' => $address->id,        // Присваиваем ID адреса доставки
            'status' => OrderStatus::Pending->value,      // Статус по умолчанию (ожидание)
            'total_price' => $this->faker->randomFloat(2, 20, 500), // Случайная общая стоимость
        ];
    }
}
