<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ProductCategory;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class ProductCategoryEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('category.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Enter category name')),

            Input::make('category.description')
                ->type('textarea')
                ->title(__('Description'))
                ->placeholder(__('Enter category description')),
        ];
    }
}
