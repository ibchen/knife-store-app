<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;

/**
 * Class OrderSeeder
 *
 * Сидер для заполнения базы данных тестовыми заказами и элементами заказов.
 */
class OrderSeeder extends Seeder
{
    /**
     * Выполняет заполнение базы данных тестовыми заказами и их элементами.
     *
     * Метод создаёт 10 тестовых клиентов. Для каждого клиента создаются
     * от 1 до 3 заказов, а для каждого заказа — 3 элемента заказа.
     *
     * @return void
     */
    public function run(): void
    {
        // Создаем 1 клиента
        Customer::factory(1)->create()->each(function ($customer) {
            // Для каждого клиента создаем от 1 до 3 заказов
            Order::factory(rand(1, 3))->create([
                'user_id' => $customer->id, // Связываем заказ с клиентом
            ])->each(function ($order) {
                // Для каждого заказа создаем 3 элемента заказа
                OrderItem::factory(3)->create([
                    'order_id' => $order->id, // Связываем элемент заказа с заказом
                ]);
            });
        });
    }
}
