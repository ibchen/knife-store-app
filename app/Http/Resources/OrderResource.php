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
     * @return array<string, mixed> Ассоциативный массив данных заказа.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id, // Идентификатор заказа.
            'user_id' => $this->user_id, // Идентификатор пользователя, оформившего заказ.
            'status' => $this->status->value, // Статус заказа.
            'total_price' => $this->total_price, // Общая стоимость заказа.
            'delivery_address' => $this->delivery_address, // JSON-объект адреса доставки.
            'addresses' => AddressResource::collection($this->user->addresses), // Коллекция адресов пользователя.
            'created_at' => $this->created_at->toDateTimeString(), // Дата и время создания заказа.
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')), // Элементы заказа.
            'payment' => new PaymentResource($this->whenLoaded('payment')), // Информация о платеже, если подгружена.
        ];
    }
}
