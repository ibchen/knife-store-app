<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления адреса.
 */
class AddressResource extends JsonResource
{
    /**
     * Преобразует ресурс в массив.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country' => $this->country,
            'city' => $this->city,
            'street' => $this->street,
            'house' => $this->house,
            'apartment' => $this->apartment,
            'postal_code' => $this->postal_code,
            'is_primary' => $this->is_primary, // Поле для основного адреса
        ];
    }
}
