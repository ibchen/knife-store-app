<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Возвращает список продуктов с опциональными фильтрацией по категории, поиском по названию и сортировкой по цене.
     *
     * @param Request $request Запрос с возможными параметрами фильтрации, поиска и сортировки.
     * @return AnonymousResourceCollection Коллекция ресурсов продуктов.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            $query->orderBy('price', $request->sort === 'asc' ? 'asc' : 'desc');
        }

        $products = $query->with('category')->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Возвращает конкретный продукт по его ID.
     *
     * @param int $id Идентификатор продукта.
     * @return ProductResource Ресурс конкретного продукта.
     * @throws ModelNotFoundException Если продукт не найден.
     */
    public function show(int $id): ProductResource
    {
        $product = Product::with('category')->findOrFail($id);
        return new ProductResource($product);
    }
}
