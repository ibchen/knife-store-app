<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

/**
 * Класс ProductListLayout
 *
 * Отображает список продуктов в виде таблицы с возможностью фильтрации, сортировки и действий.
 */
class ProductListLayout extends Table
{
    /**
     * Целевая модель для отображения.
     *
     * @var string
     */
    public $target = 'products';

    /**
     * Возвращает массив колонок для таблицы.
     *
     * @return array Массив колонок.
     */
    public function columns(): array
    {
        return [
            // Колонка с изображениями продукта
            TD::make('image_path', __('Images'))
                ->render(function (Product $product) {
                    $images = is_array($product->image_path) ? $product->image_path : json_decode($product->image_path, true);

                    if (empty($images)) {
                        return '<span>' . __('No images available') . '</span>';
                    }

                    $thumbnails = '<div style="display: flex; gap: 5px;">';

                    foreach ($images as $path) {
                        $thumbnails .= "<img src='" . asset('storage/' . $path) . "' style='width: 50px; height: 50px; object-fit: cover; border-radius: 3px;' />";
                    }

                    $thumbnails .= '</div>';
                    return $thumbnails;
                })
                ->width('150px')
                ->align(TD::ALIGN_CENTER),

            // Колонка с именем продукта
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make()->placeholder(__('Search by name')))
                ->cantHide()
                ->width('150px')
                ->render(fn (Product $product) => $product->name),

            // Колонка с ценой продукта
            TD::make('price', __('Price'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => '$' . number_format((float)$product->price, 2)),

            // Колонка с количеством на складе
            TD::make('stock', __('Stock'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => $product->stock),

            // Колонка с категорией продукта
            TD::make('category', __('Category'))
                ->render(fn (Product $product) => $product->category ? e($product->category->name) : '—'),

            // Колонка с датой создания продукта
            TD::make('created_at', __('Created'))
                ->sort()
                ->render(fn (Product $product) => $product->created_at->format('Y-m-d H:i:s')),

            // Колонка с действиями
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Product $product) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        // Ссылка на редактирование продукта
                        Link::make(__('Edit'))
                            ->route('platform.systems.products.edit', $product->id)
                            ->icon('bs.pencil'),

                        // Кнопка удаления продукта
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Are you sure you want to delete this product?'))
                            ->method('remove', [
                                'id' => $product->id,
                            ]),
                    ])),
        ];
    }
}
