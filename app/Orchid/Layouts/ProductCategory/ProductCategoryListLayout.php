<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ProductCategory;

use App\Models\ProductCategory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductCategoryListLayout extends Table
{
    public $target = 'categories';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->render(fn (ProductCategory $category) => $category->name),

            TD::make('description', __('Description'))
                ->render(fn (ProductCategory $category) => $category->description),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (ProductCategory $category) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.systems.categories.edit', $category->id)
                            ->icon('bs.pencil'),

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
