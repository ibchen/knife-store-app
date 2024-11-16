<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления клиента.
 */
class CustomerResource extends JsonResource
{
    /**
     * Преобразует ресурс клиента в массив.
     *
     * @param  Request  $request Запрос пользователя.
     * @return array<string, mixed> Ассоциативный массив с данными клиента.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->toDateTimeString(), // Дата и время создания.
            'updated_at' => $this->updated_at->toDateTimeString(), // Дата и время последнего обновления.
            'addresses' => AddressResource::collection($this->addresses), // Коллекция адресов клиента.
        ];
    }
}
