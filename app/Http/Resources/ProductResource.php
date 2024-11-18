<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления продукта.
 */
class ProductResource extends JsonResource
{
    /**
     * Преобразует ресурс продукта в массив.
     *
     * @param Request $request Запрос.
     * @return array<string, mixed> Ассоциативный массив данных продукта.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id, // Уникальный идентификатор продукта.
            'name' => $this->name, // Название продукта.
            'description' => $this->description, // Описание продукта.
            'price' => $this->price, // Цена продукта.
            'stock' => $this->stock, // Количество продукта на складе.
            'image_urls' => $this->image_urls, // Массив URL изображений.
            'category' => new ProductCategoryResource($this->whenLoaded('category')), // Категория продукта.
        ];
    }
}
