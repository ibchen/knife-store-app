<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

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
        // Создаем 10 заказов и для каждого создаем по 3 элемента заказа
        Order::factory(10)->create()->each(function ($order) {
            OrderItem::factory(3)->create(['order_id' => $order->id]);
        });
    }
}
