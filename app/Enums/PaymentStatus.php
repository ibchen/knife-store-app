<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';       // Ожидает обработки
    case Completed = 'completed';   // Завершена
    case Failed = 'failed';         // Неудачная
    case Refunded = 'refunded';     // Возвращена
}
