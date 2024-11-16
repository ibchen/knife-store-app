<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для модели CartItem.
 *
 * Используется для генерации фейковых данных для элементов корзины.
 *
 * @extends Factory<CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Имя модели, связанной с этой фабрикой.
     *
     * @var string
     */
    protected $model = CartItem::class;

    /**
     * Определяет значения по умолчанию для фейковых данных.
     *
     * @return array<string, mixed> Массив данных для модели CartItem.
     */
    public function definition(): array
    {
        return [
            // Создаёт нового пользователя, если он не указан
            'user_id' => Customer::factory(),

            // Создаёт новый продукт, если он не указан
            'product_id' => Product::factory(),

            // Генерирует случайное количество от 1 до 5
            'quantity' => $this->faker->numberBetween(1, 5),

            // Устанавливает флаг "не куплен"
            'is_purchased' => false,
        ];
    }
}
