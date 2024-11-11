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
}
