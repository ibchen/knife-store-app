<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
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

        Customer::factory()->create([
            'name' => 'Customer 1',
            'email' => 'customer_1@example.com',
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
