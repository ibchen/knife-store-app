<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;

/**
 * Сидер для заполнения базы данных тестовыми заказами и элементами заказов.
 */
class OrderSeeder extends Seeder
{
    /**
     * Запускает создание тестовых данных для заказов и связанных элементов заказов.
     *
     * @return void
     */
    public function run(): void
    {
        // Создаем 10 клиентов, для каждого создаем заказы и привязываем их к адресу доставки
        Customer::factory(10)->create()->each(function ($customer) {
            $addresses = $customer->addresses()->createMany(Address::factory(2)->make()->toArray());

            // Для каждого клиента создаем 1-3 заказа с привязанными адресами доставки
            Order::factory(rand(1, 3))->create([
                'user_id' => $customer->id,
                'delivery_address_id' => $addresses->random()->id,
            ])->each(function ($order) {
                OrderItem::factory(3)->create(['order_id' => $order->id]);
            });
        });
    }
}
