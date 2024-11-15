<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $products = [
            ["name" => "Охотничий нож \"Тайга\"", "description" => "Прочный и надежный нож для охоты в любых погодных условиях."],
            ["name" => "Кухонный нож \"Шеф\"", "description" => "Идеальный инструмент для профессиональной нарезки."],
            ["name" => "Складной нож \"Универсал\"", "description" => "Компактный нож для повседневного использования."],
            ["name" => "Нож для резьбы \"Мастер\"", "description" => "Художественный нож для резьбы по дереву."],
            ["name" => "Коллекционный нож \"Легенда\"", "description" => "Эксклюзивный нож с уникальной гравировкой."],
            ["name" => "Охотничий нож \"Сокол\"", "description" => "Легкий и острый нож для точных разрезов."],
            ["name" => "Кухонный нож \"Универсал\"", "description" => "Многофункциональный кухонный нож для всех типов нарезки."],
            ["name" => "Складной нож \"Путник\"", "description" => "Надежный спутник для туристических походов."],
            ["name" => "Метательный нож \"Стрела\"", "description" => "Балансированный нож для метания."],
            ["name" => "Тактический нож \"Командор\"", "description" => "Мощный нож для тактических операций."],
            ["name" => "Мультитул \"Инженер\"", "description" => "Полезный инструмент с множеством функций."],
            ["name" => "Мачете \"Тропик\"", "description" => "Идеально подходит для расчистки густой растительности."],
            ["name" => "Топор \"Лесник\"", "description" => "Прочный топор для работы в лесу."],
            ["name" => "Нож для рыбалки \"Клев\"", "description" => "Острый нож для чистки рыбы."],
            ["name" => "Нож для выживания \"Экстрим\"", "description" => "Компактный инструмент для выживания в дикой природе."],
            ["name" => "Кухонный нож \"Филейный\"", "description" => "Тонкий нож для разделки рыбы и мяса."],
            ["name" => "Складной нож \"Вояж\"", "description" => "Стильный и функциональный складной нож."],
            ["name" => "Нож для резьбы \"Художник\"", "description" => "Подходит для создания сложных узоров по дереву."],
            ["name" => "Коллекционный нож \"Аристократ\"", "description" => "Нож с ручкой из редких пород дерева."],
            ["name" => "Тактический нож \"Страйкер\"", "description" => "Рассчитан на использование в экстремальных условиях."],
            ["name" => "Мачете \"Джунгли\"", "description" => "Массивное лезвие для преодоления плотных зарослей."],
            ["name" => "Метательный нож \"Феникс\"", "description" => "Идеален для соревнований по метанию ножей."],
            ["name" => "Топор \"Секач\"", "description" => "Отличный выбор для разделки дров."],
            ["name" => "Мультитул \"Мастер-Про\"", "description" => "Инструмент с 18 функциями для работы и отдыха."],
            ["name" => "Охотничий нож \"Барс\"", "description" => "Прочный нож для тяжелых задач на охоте."],
            ["name" => "Кухонный нож \"Мастер-Шеф\"", "description" => "Профессиональный нож для нарезки овощей и мяса."],
            ["name" => "Нож для выживания \"Джунгли\"", "description" => "С встроенным огнивом и мини-пилой на обухе."],
            ["name" => "Нож для резьбы \"Тонкий\"", "description" => "Узкое лезвие для мелкой детализации."],
            ["name" => "Коллекционный нож \"Император\"", "description" => "Роскошный нож с золотым покрытием."],
            ["name" => "Нож для рыбалки \"Шторм\"", "description" => "Прочный и водостойкий нож для рыбалки."]
        ];

        // Выбираем случайный продукт без уникальности
        $product = $this->faker->randomElement($products);

        // Список локальных изображений
        $localImages = [
            'images/products/default_knife_1.jpg',
            'images/products/default_knife_2.jpg',
            'images/products/default_knife_3.jpg',
            'images/products/default_knife_4.jpg',
            'images/products/default_knife_5.jpg',
        ];

        // Генерация массива изображений
        $imagePaths = $this->faker->randomElements($localImages, rand(3, 5));

        return [
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'stock' => $this->faker->numberBetween(10, 200),
            'image_path' => json_encode($imagePaths),
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
        ];
    }
}
