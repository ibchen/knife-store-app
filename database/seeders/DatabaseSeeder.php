<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'permissions' => '{"platform.index": true, "platform.systems.roles": true, "platform.systems.users": true, "platform.systems.attachment": true}',
        ]);

        $customer = Customer::factory()->create([
            'name' => 'Alan Gordon',
            'email' => 'gordon@example.com',
        ]);

        $customer = Customer::factory()->create([
            'name' => 'John Dow',
            'email' => 'dow@example.com',
        ]);

        // Создаем тестовый адрес для пользователя
        Address::create([
            'customer_id' => $customer->id,
            'country' => 'Россия',
            'city' => 'Москва',
            'street' => 'Тверская',
            'house' => '10',
            'apartment' => '15',
            'postal_code' => '123456',
        ]);

        // Вызов дополнительных сидеров
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            CartItemSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
