<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ProductCategory;

use App\Models\ProductCategory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

/**
 * Класс ProductCategoryListLayout
 *
 * Отображает список категорий продуктов в виде таблицы с возможностью сортировки и действий.
 */
class ProductCategoryListLayout extends Table
{
    /**
     * Целевая модель для отображения.
     *
     * @var string
     */
    public $target = 'categories';

    /**
     * Возвращает массив колонок для таблицы.
     *
     * @return array Массив колонок.
     */
    public function columns(): array
    {
        return [
            // Колонка с названием категории
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->render(fn(ProductCategory $category) => e($category->name)),

            // Колонка с описанием категории
            TD::make('description', __('Description'))
                ->render(fn(ProductCategory $category) => e($category->description)),

            // Колонка с действиями
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(ProductCategory $category) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        // Ссылка на редактирование категории
                        Link::make(__('Edit'))
                            ->route('platform.systems.categories.edit', $category->id)
                            ->icon('bs.pencil'),

                        // Кнопка удаления категории
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Are you sure you want to delete this category?'))
                            ->method('remove', [
                                'id' => $category->id,
                            ]),
                    ])),
        ];
    }
}
