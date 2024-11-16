<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class CartItemSeeder
 *
 * Сидер для заполнения корзины начальными товарами.
 */
class CartItemSeeder extends Seeder
{
    /**
     * Запустить заполнение корзины товарами.
     *
     * Метод создает записи в таблице `cart_items` для первых трёх товаров
     * в базе данных и первого пользователя. Каждому товару присваивается
     * случайное количество (от 1 до 3) и статус `is_purchased` установлен
     * в значение `false`.
     *
     * @return void
     */
    public function run(): void
    {
        // Получаем первого пользователя из базы данных
        $user = User::first();

        // Получаем первые три продукта из базы данных
        $products = Product::take(3)->get();

        // Проходим по каждому продукту и создаем запись в корзине
        foreach ($products as $product) {
            CartItem::create([
                'user_id' => $user->id, // ID пользователя
                'product_id' => $product->id, // ID продукта
                'quantity' => rand(1, 3), // Случайное количество от 1 до 3
                'is_purchased' => false, // Статус покупки
            ]);
        }
    }
}
