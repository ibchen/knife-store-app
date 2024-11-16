<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Контроллер для управления категориями продуктов.
 */
class CategoryController extends Controller
{
    /**
     * Возвращает список всех категорий.
     *
     * @return AnonymousResourceCollection Коллекция ресурсов категорий.
     */
    public function index(): AnonymousResourceCollection
    {
        // Получение всех категорий из базы данных
        $categories = ProductCategory::all();

        // Преобразование категорий в коллекцию ресурсов
        return CategoryResource::collection($categories);
    }
}
