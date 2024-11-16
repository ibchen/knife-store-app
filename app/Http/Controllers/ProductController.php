<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Контроллер для управления продуктами.
 */
class ProductController extends Controller
{
    /**
     * Возвращает список продуктов с фильтрацией, поиском и сортировкой.
     *
     * Возможные параметры запроса:
     * - `category_id` (int): Фильтрация по категории.
     * - `search` (string): Поиск по названию продукта.
     * - `sort` (string): Сортировка по цене (`asc` или `desc`).
     *
     * @param Request $request Запрос с параметрами фильтрации, поиска и сортировки.
     * @return AnonymousResourceCollection Коллекция ресурсов продуктов.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        // Создаем базовый запрос к модели Product
        $query = Product::query();

        // Фильтрация по категории, если указан параметр category_id
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Поиск по названию продукта, если указан параметр search
        if ($request->filled('search')) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        // Сортировка по цене, если указан параметр sort
        if ($request->filled('sort')) {
            $query->orderBy('price', $request->sort === 'asc' ? 'asc' : 'desc');
        }

        // Пагинация результатов с подгрузкой категории
        $products = $query->with('category')->paginate(10);

        // Возвращаем коллекцию ресурсов продуктов
        return ProductResource::collection($products);
    }

    /**
     * Возвращает конкретный продукт по его ID.
     *
     * @param int $id Идентификатор продукта.
     * @return ProductResource Ресурс конкретного продукта.
     */
    public function show(int $id): ProductResource
    {
        // Ищем продукт с подгрузкой категории
        $product = Product::with('category')->findOrFail($id);

        // Возвращаем ресурс продукта
        return new ProductResource($product);
    }
}
