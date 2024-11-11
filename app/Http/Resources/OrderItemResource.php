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
     * @return array<string, mixed> Массив данных элемента заказа.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_price' => $this->quantity * $this->price,
        ];
    }
}
