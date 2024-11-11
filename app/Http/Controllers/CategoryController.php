<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Возвращает список всех категорий.
     *
     * @return AnonymousResourceCollection Коллекция ресурсов категорий.
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = ProductCategory::all();
        return CategoryResource::collection($categories);
    }
}
