<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    public $target = 'products';

    public function columns(): array
    {
        return [
            TD::make('image', __('Image'))
                ->render(function (Product $product) {
                    // Проверяем, что image_path является массивом
                    if (is_array($product->image_path)) {
                        $thumbnails = '<div style="display: flex; gap: 5px;">';

                        foreach ($product->image_path as $path) {
                            // Создаем миниатюру с отступами
                            $thumbnails .= "<img src='" . asset('storage/' . $path) . "' style='width: 30px; height: 30px; object-fit: cover; border-radius: 3px;' />";
                        }

                        $thumbnails .= '</div>';
                        return $thumbnails ?: '<span>No images available</span>';
                    } else {
                        // Сообщение, если image_path не является массивом
                        return '<span>Image paths not loaded as array</span>';
                    }
                })
                ->align(TD::ALIGN_CENTER)
                ->width('100px'),

            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => $product->name),

            TD::make('price', __('Price'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => '$' . number_format((float) $product->price, 2)),

            TD::make('stock', __('Stock'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => $product->stock),

            TD::make('category', __('Category'))
                ->render(fn (Product $product) => $product->category ? $product->category->name : '—'),

            TD::make('created_at', __('Created'))
                ->sort()
                ->render(fn (Product $product) => $product->created_at->toDateString()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Product $product) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.systems.products.edit', $product->id)
                            ->icon('bs.pencil'),

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
