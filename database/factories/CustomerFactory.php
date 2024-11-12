<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Customer $customer) {
            // Генерация 1-2 адресов для каждого клиента
            Address::factory()->count(rand(1, 2))->create([
                'customer_id' => $customer->id,
            ]);
        });
    }
}
