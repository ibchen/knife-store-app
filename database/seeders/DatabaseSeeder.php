<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * Основной сидер, который вызывает другие сидеры и заполняет базу данных начальными данными.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Выполняет заполнение базы данных начальными данными.
     *
     * Создаются тестовые клиенты, их адреса, а также вызываются другие сидеры
     * для заполнения данных о продуктах, категориях, корзинах и заказах.
     *
     * @return void
     */
    public function run(): void
    {
        // Создание первого тестового клиента
        $customer1 = Customer::factory()->create([
            'name' => 'Alan Gordon', // Имя клиента
            'email' => 'gordon@example.com', // Электронная почта клиента
        ]);

        // Создание второго тестового клиента
        $customer2 = Customer::factory()->create([
            'name' => 'John Dow', // Имя клиента
            'email' => 'dow@example.com', // Электронная почта клиента
        ]);

        // Создаем адрес для первого клиента
        Address::create([
            'customer_id' => $customer1->id, // ID клиента
            'country' => 'Россия', // Страна
            'city' => 'Москва', // Город
            'street' => 'Тверская', // Улица
            'house' => '10', // Дом
            'apartment' => '15', // Квартира
            'postal_code' => '123456', // Почтовый индекс
        ]);

        // Создаем адрес для второго клиента
        Address::create([
            'customer_id' => $customer2->id, // ID клиента
            'country' => 'USA', // Страна
            'city' => 'New-York', // Город
            'street' => '15th Avenue', // Улица
            'house' => '4', // Дом
            'apartment' => '321', // Квартира
            'postal_code' => '786554', // Почтовый индекс
        ]);

        // Вызов дополнительных сидеров для заполнения связанных данных
        $this->call([
            ProductCategorySeeder::class, // Сидер для категорий продуктов
            ProductSeeder::class, // Сидер для продуктов
            CartItemSeeder::class, // Сидер для товаров в корзине
            OrderSeeder::class, // Сидер для заказов
        ]);
    }
}
