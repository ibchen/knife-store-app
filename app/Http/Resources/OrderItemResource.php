<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления элемента заказа.
 */
class OrderItemResource extends JsonResource
{
    /**
     * Преобразует ресурс элемента заказа в массив.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @return array<string, mixed> Ассоциативный массив данных элемента заказа.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id, // Идентификатор элемента заказа.
            'product_id' => $this->product_id, // Идентификатор продукта.
            'product_name' => $this->product->name, // Название продукта.
            'quantity' => $this->quantity, // Количество данного продукта в заказе.
            'price' => $this->price, // Цена за единицу продукта.
            'total_price' => $this->quantity * $this->price, // Общая стоимость данного элемента.
        ];
    }
}
