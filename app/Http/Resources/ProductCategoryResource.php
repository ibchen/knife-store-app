<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления категории продукта.
 */
class ProductCategoryResource extends JsonResource
{
    /**
     * Преобразует ресурс категории продукта в массив.
     *
     * @param Request $request Запрос.
     * @return array<string, mixed> Ассоциативный массив данных категории продукта.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id, // Идентификатор категории.
            'name' => $this->name, // Название категории.
            'description' => $this->description, // Описание категории.
        ];
    }
}
