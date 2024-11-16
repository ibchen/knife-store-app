<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * Фабрика для модели Customer.
 *
 * Используется для генерации фейковых данных клиентов.
 */
class CustomerFactory extends Factory
{
    /**
     * Связанная модель фабрики.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Определяет значения по умолчанию для фейковых данных.
     *
     * @return array<string, mixed> Массив данных для модели Customer.
     */
    public function definition(): array
    {
        return [
            // Генерация случайного имени
            'name' => $this->faker->name,

            // Генерация уникального email
            'email' => $this->faker->unique()->safeEmail,

            // Установка хэшированного пароля
            'password' => Hash::make('password'),
        ];
    }

    /**
     * Конфигурирует фабрику для выполнения дополнительных действий после создания.
     *
     * @return $this
     */
    public function configure(): self
    {
        return $this->afterCreating(function (Customer $customer) {
            // Генерация от 1 до 2 адресов для каждого клиента
            Address::factory()->count(rand(1, 2))->create([
                'customer_id' => $customer->id,
            ]);
        });
    }
}
