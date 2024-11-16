<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления категории.
 */
class CategoryResource extends JsonResource
{
    /**
     * Преобразует ресурс категории в массив.
     *
     * @param  Request  $request Запрос пользователя.
     * @return array<string, mixed> Ассоциативный массив с данными категории.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
