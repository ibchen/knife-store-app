<?php namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Имя модели, с которой связана фабрика.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Определить стандартное состояние модели.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ["name" => "Охотничьи ножи", "description" => "Ножи для охоты и рыбалки"],
            ["name" => "Кухонные ножи", "description" => "Ножи для приготовления пищи"],
            ["name" => "Туристические ножи", "description" => "Ножи для туризма и активного отдыха"],
            ["name" => "Складные ножи", "description" => "Ножи для повседневного использования"],
            ["name" => "Тактические ножи", "description" => "Ножи для спецназа и армии"],
            ["name" => "Мультитулы", "description" => "Мультитулы и ножи-инструменты"],
            ["name" => "Спортивные ножи", "description" => "Ножи для спорта и активного отдыха"],
            ["name" => "Метательные ножи", "description" => "Ножи для метания"],
            ["name" => "Мачете", "description" => "Мачете и кукри"],
            ["name" => "Топоры и секиры", "description" => "Топоры и секиры для туризма и активного отдыха"],
            ["name" => "Ножи для рыбалки", "description" => "Ножи для рыбалки и охоты"],
            ["name" => "Ножи для выживания", "description" => "Ножи для выживания и автономной жизни"],
            ["name" => "Ножи для резьбы по дереву", "description" => "Ножи для резьбы по дереву и рукоделия"],
            ["name" => "Точилки и аксессуары для заточки", "description" => "Точилки и аксессуары для заточки ножей"],
            ["name" => "Коллекционные ножи", "description" => "Коллекционные ножи и ножи-памятники"]
        ];

        $category = $this->faker->unique()->randomElement($categories);

        return [
            'name' => $category['name'],
            'description' => $category['description'],
        ];
    }
}
