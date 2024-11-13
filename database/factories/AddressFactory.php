<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(), // Создает связанного клиента, если не указан
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house' => $this->faker->buildingNumber,
            'apartment' => $this->faker->optional()->numerify('##'),
            'postal_code' => $this->faker->postcode,
            'is_primary' => false, // Значение по умолчанию - не основной
        ];
    }

    /**
     * Состояние для основного адреса
     */
    public function primary()
    {
        return $this->state(function () {
            return ['is_primary' => true];
        });
    }
}
