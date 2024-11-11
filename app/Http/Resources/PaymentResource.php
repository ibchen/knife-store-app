<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления оплаты.
 */
class PaymentResource extends JsonResource
{
    /**
     * Преобразует ресурс оплаты в массив.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @return array<string, mixed> Массив данных оплаты.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'status' => $this->status->value, // Статус оплаты как строковое значение
            'payment_date' => $this->payment_date,
        ];
    }
}
