<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления информации об оплате.
 */
class PaymentResource extends JsonResource
{
    /**
     * Преобразует ресурс оплаты в массив.
     *
     * @param Request $request Запрос.
     * @return array<string, mixed> Ассоциативный массив данных об оплате.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id, // Идентификатор записи оплаты.
            'order_id' => $this->order_id, // Идентификатор связанного заказа.
            'amount' => $this->amount, // Сумма оплаты.
            'status' => $this->status->value, // Статус оплаты как строковое значение (например, completed, pending).
            'payment_date' => $this->payment_date->toDateTimeString(), // Дата и время оплаты в формате ISO.
        ];
    }
}
