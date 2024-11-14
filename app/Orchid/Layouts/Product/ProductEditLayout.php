<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\ProductCategory;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ProductEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('product.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Enter product name')),

            Input::make('product.description')
                ->type('textarea')
                ->title(__('Description'))
                ->placeholder(__('Enter product description')),

            Input::make('product.price')
                ->type('number')
                ->required()
                ->title(__('Price'))
                ->placeholder(__('Enter product price')),

            Input::make('product.stock')
                ->type('number')
                ->required()
                ->title(__('Stock'))
                ->placeholder(__('Enter product stock')),

            Select::make('product.category_id')
                ->fromModel(ProductCategory::class, 'name') // Подгружает названия категорий
                ->required()
                ->title(__('Category')),

            Upload::make('product.image_paths')
                ->title(__('Images'))
                ->multiple()
                ->storage('public')
                ->placeholder(__('Upload product images')),
        ];
    }
}
