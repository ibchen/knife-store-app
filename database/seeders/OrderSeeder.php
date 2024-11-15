<?php

namespace Database\Seeders;

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
        // Создаем 10 клиентов, для каждого создаем заказы
        Customer::factory(10)->create()->each(function ($customer) {
            // Для каждого клиента создаем 1-3 заказа
            Order::factory(rand(1, 3))->create([
                'user_id' => $customer->id,
            ])->each(function ($order) {
                OrderItem::factory(3)->create(['order_id' => $order->id]);
            });
        });
    }
}
