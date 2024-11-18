<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductEditScreen extends Screen
{
    public ?Product $product = null;

    public function query(Product $product): iterable
    {
        $this->product = $product->exists ? $product : new Product();

        return [
            'product' => $this->product,
        ];
    }

    public function name(): ?string
    {
        return $this->product && $this->product->exists ? 'Edit Product' : 'Create Product';
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
            Layout::block(ProductEditLayout::class),
        ];
    }

    public function save(Request $request, Product $product): void
    {
        // Валидация данных
        $data = $request->validate([
            'product.name' => 'required|max:255',
            'product.description' => 'nullable|string',
            'product.price' => 'required|numeric',
            'product.stock' => 'required|integer',
            'product.category_id' => 'required|exists:product_categories,id',
            'product.image_paths' => 'nullable|array',
        ]);

        // Сохраняем идентификаторы файлов вместо путей
        $data['product']['image_paths'] = collect($data['product']['image_paths'])
            ->filter(function ($fileId) {
                // Проверяем существование файла в таблице attachments
                return Attachment::find($fileId) !== null;
            })
            ->unique() // Убираем дубли
            ->toArray();

        // Сохраняем продукт
        $product->fill($data['product'])->save();

        // Выводим сообщение об успешном сохранении
        Toast::info(__('Product was saved.'));
    }
}
