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

class ProductListLayout extends Table
{
    public $target = 'products';

    public function columns(): array
    {
        return [
            TD::make('image_path', __('Images'))
                ->render(function (Product $product) {
                    if (!is_array($product->image_path)) {
                        $product->image_path = json_decode($product->image_path, true);
                    }

                    if (!is_array($product->image_path) || empty($product->image_path)) {
                        return '<span>No images available</span>';
                    }

                    $thumbnails = '<div style="display: flex; gap: 5px;">';

                    foreach ($product->image_path as $path) {
                        $thumbnails .= "<img src='" . asset('storage/' . $path) . "' style='width: 50px; height: 50px; object-fit: cover; border-radius: 3px;' />";
                    }

                    $thumbnails .= '</div>';
                    return $thumbnails;
                })
                ->width('150px')
                ->align(TD::ALIGN_CENTER),

            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make()->placeholder('Search by name'))
                ->cantHide()
                ->width('150px')
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
                ->render(fn (Product $product) => $product->created_at->format('Y-m-d H:i:s')),

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
