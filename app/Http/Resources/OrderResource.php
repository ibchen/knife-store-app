<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления заказа.
 */
class OrderResource extends JsonResource
{
    /**
     * Преобразует ресурс заказа в массив.
     *
     * @param Request $request Запрос.
     * @return array<string, mixed> Массив данных заказа.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status->value,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'addresses' => $this->user->addresses ? AddressResource::collection($this->user->addresses) : [],
            'payment' => new PaymentResource($this->whenLoaded('payment')),
        ];
    }
}
