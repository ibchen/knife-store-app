<?php

declare(strict_types=1);

namespace App\Orchid\Screens\ProductCategory;

use App\Models\ProductCategory;
use App\Orchid\Layouts\ProductCategory\ProductCategoryEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductCategoryEditScreen extends Screen
{
    public ?ProductCategory $category = null;

    public function query(ProductCategory $category): iterable
    {
        $this->category = $category->exists ? $category : new ProductCategory();

        return [
            'category' => $this->category,
        ];
    }

    public function name(): ?string
    {
        return $this->category && $this->category->exists ? 'Edit Category' : 'Create Category';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.save')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(ProductCategoryEditLayout::class),
        ];
    }

    public function save(Request $request, ProductCategory $category): void
    {
        $data = $request->validate([
            'category.name' => 'required|max:255',
            'category.description' => 'nullable|string',
        ]);

        $category->fill($data['category'])->save();

        Toast::info(__('Category was saved.'));
    }
}
