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
            'delivery_address' => $this->delivery_address, // Поле JSON-адреса доставки
            'addresses' => AddressResource::collection($this->user->addresses), // Адреса пользователя
            'created_at' => $this->created_at,
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
        ];
    }
}
