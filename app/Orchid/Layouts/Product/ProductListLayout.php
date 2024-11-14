<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    public $target = 'products';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort() // Включаем сортировку по алфавиту
                ->cantHide()
                ->render(fn (Product $product) => $product->name),

            TD::make('price', __('Price'))
                ->sort() // Включаем сортировку по цене
                ->cantHide()
                ->render(fn (Product $product) => '$' . number_format((float) $product->price, 2)),

            TD::make('stock', __('Stock'))
                ->sort() // Включаем сортировку по количеству на складе
                ->cantHide()
                ->render(fn (Product $product) => $product->stock),

            TD::make('category', __('Category'))
                ->render(fn (Product $product) => $product->category ? $product->category->name : '—'),

            TD::make('created_at', __('Created'))
                ->sort() // Включаем сортировку по дате создания
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
