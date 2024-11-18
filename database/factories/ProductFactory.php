<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;

/**
 * Фабрика для создания моделей продуктов.
 */
class ProductFactory extends Factory
{
    /**
     * Связанная модель фабрики.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Определяет стандартное состояние модели.
     *
     * @return array<string, mixed> Ассоциативный массив с данными для создания модели.
     */
    public function definition(): array
    {
        // Список предопределенных продуктов с описаниями
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

        // Выбор случайного продукта
        $product = $this->faker->randomElement($products);

        // Список путей к изображениям
        $localImages = [
            'images/products/default_knife_1.jpg',
            'images/products/default_knife_2.jpg',
            'images/products/default_knife_3.jpg',
            'images/products/default_knife_4.jpg',
            'images/products/default_knife_5.jpg',
        ];

        // Генерация 3–5 случайных изображений
        $randomImages = $this->faker->randomElements($localImages, rand(3, 5));

        // Создание записей в таблице attachments и получение их идентификаторов
        $attachmentIds = collect($randomImages)->map(function ($imagePath) {
            // Проверяем, существует ли файл
            if (!Storage::exists($imagePath)) {
                throw new \Exception("File {$imagePath} does not exist.");
            }

            // Генерация уникального имени файла
            $newFileName = uniqid() . '_' . basename($imagePath);
            $storageFolder = 'attachments/';

            // Копируем файл в публичную директорию
            Storage::disk('public')->put($storageFolder . $newFileName, Storage::get($imagePath));

            // Создание записи в таблице attachments
            $attachment = Attachment::create([
                'name' => pathinfo($newFileName, PATHINFO_FILENAME), // Имя файла без расширения
                'original_name' => basename($imagePath), // Исходное имя файла
                'mime' => Storage::mimeType($imagePath), // MIME-тип файла
                'extension' => pathinfo($newFileName, PATHINFO_EXTENSION), // Расширение файла
                'size' => Storage::size($imagePath), // Размер файла
                'path' => $storageFolder, // Только папка, где файл находится
                'hash' => hash_file('sha256', storage_path('app/public/' . $storageFolder . $newFileName)), // Хеш содержимого файла
                'user_id' => auth()->id() ?? 1, // ID пользователя или значение по умолчанию
            ]);

            return $attachment->id;
        });

        return [
            'name' => $product['name'], // Название продукта
            'description' => $product['description'], // Описание продукта
            'price' => $this->faker->randomFloat(2, 50, 1000), // Цена (от 50 до 1000)
            'stock' => $this->faker->numberBetween(10, 200), // Количество на складе (от 10 до 200)
            'image_paths' => $attachmentIds->toArray(), // Идентификаторы изображений
            'category_id' => ProductCategory::inRandomOrder()->first()->id, // Случайная категория
        ];
    }
}
