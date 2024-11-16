<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для модели Address.
 *
 * Используется для генерации фейковых данных адресов в тестах и сидерах.
 */
class AddressFactory extends Factory
{
    /**
     * Связанная модель фабрики.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Определяет значения по умолчанию для фейковых данных.
     *
     * @return array<string, mixed> Массив данных для модели Address.
     */
    public function definition(): array
    {
        return [
            // Создает связанного клиента, если не указан
            'customer_id' => Customer::factory(),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house' => $this->faker->buildingNumber,
            'apartment' => $this->faker->optional()->numerify('##'), // Опциональное поле
            'postal_code' => $this->faker->postcode,
            'is_primary' => false, // Значение по умолчанию - не основной
        ];
    }

    /**
     * Состояние для основного адреса.
     *
     * @return Factory
     */
    public function primary(): Factory
    {
        return $this->state(fn() => ['is_primary' => true]);
    }
}
