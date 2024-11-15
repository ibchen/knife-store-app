<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';       // В ожидании
    case Paid = 'paid';             // Оплачен
    case Processing = 'processing'; // В обработке
    case Shipped = 'shipped';       // Отправлен
    case Delivered = 'delivered';   // Доставлен
    case Canceled = 'canceled';     // Отменен

    public static function asSelectArray(): array
    {
        return array_column(
            array_map(fn(self $status) => [$status->value => ucfirst($status->name)], self::cases()),
            0
        );
    }
}
