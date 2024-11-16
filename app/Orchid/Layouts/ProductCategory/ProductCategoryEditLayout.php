<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ProductCategory;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

/**
 * Класс ProductCategoryEditLayout
 *
 * Отображает форму редактирования или создания категории продукта.
 */
class ProductCategoryEditLayout extends Rows
{
    /**
     * Возвращает массив полей для редактирования категории продукта.
     *
     * @return array Массив полей.
     */
    public function fields(): array
    {
        return [
            // Поле ввода имени категории
            Input::make('category.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Enter category name')),

            // Поле ввода описания категории
            Input::make('category.description')
                ->type('textarea')
                ->title(__('Description'))
                ->placeholder(__('Enter category description')),
        ];
    }
}
