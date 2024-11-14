<?php

declare(strict_types=1);

namespace App\Orchid\Screens\ProductCategory;

use App\Models\ProductCategory;
use App\Orchid\Layouts\ProductCategory\ProductCategoryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductCategoryListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Category Management';
    }

    public function query(): iterable
    {
        return [
            'categories' => ProductCategory::paginate(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add Category'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.categories.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProductCategoryListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        $category = ProductCategory::findOrFail($request->get('id'));

        // Проверка на наличие связанных продуктов с использованием правильного названия колонки
        if ($category->products()->exists()) {
            Toast::error(__('Cannot delete category with associated products.'));
            return;
        }

        $category->delete();

        Toast::info(__('Category was removed.'));
    }
}
