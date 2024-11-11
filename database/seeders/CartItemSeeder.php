<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class CartItemSeeder
 *
 * Заполняет корзину начальными товарами.
 */
class CartItemSeeder extends Seeder
{
    /**
     * Запустить заполнение корзины товарами.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::first();
        $products = Product::take(3)->get();

        foreach ($products as $product) {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
                'is_purchased' => false,
            ]);
        }
    }
}
