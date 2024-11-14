<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Product\ProductListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Product Management';
    }

    public function query(): iterable
    {
        return [
            'products' => Product::with('category')
                ->defaultSort('name')
                ->paginate(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add Product'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.products.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProductListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        Product::findOrFail($request->get('id'))->delete();

        Toast::info(__('Product was removed.'));
    }
}
