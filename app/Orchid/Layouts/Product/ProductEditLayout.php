<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\ProductCategory;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

/**
 * Класс ProductEditLayout
 *
 * Отображает форму редактирования или создания продукта.
 */
class ProductEditLayout extends Rows
{
    /**
     * Возвращает массив полей для редактирования продукта.
     *
     * @return array Массив полей.
     */
    public function fields(): array
    {
        return [
            // Поле ввода имени продукта
            Input::make('product.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Enter product name')),

            // Поле ввода описания продукта
            Input::make('product.description')
                ->type('textarea')
                ->title(__('Description'))
                ->placeholder(__('Enter product description')),

            // Поле ввода цены продукта
            Input::make('product.price')
                ->type('number')
                ->required()
                ->title(__('Price'))
                ->placeholder(__('Enter product price')),

            // Поле ввода количества на складе
            Input::make('product.stock')
                ->type('number')
                ->required()
                ->title(__('Stock'))
                ->placeholder(__('Enter product stock')),

            // Поле выбора категории продукта
            Select::make('product.category_id')
                ->fromModel(ProductCategory::class, 'name') // Подгружает названия категорий из модели ProductCategory
                ->required()
                ->title(__('Category')),

            // Поле загрузки изображений продукта
            Upload::make('product.image_paths')
                ->title(__('Images'))
                ->multiple()
                ->storage('public')
                ->placeholder(__('Upload product images')),
        ];
    }
}
