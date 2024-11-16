<?php

namespace App\Enums;

/**
 * Перечисление статусов платежей
 */
enum PaymentStatus: string
{
    case Pending = 'pending';       // Ожидает обработки
    case Completed = 'completed';   // Завершена
    case Failed = 'failed';         // Неудачная
    case Refunded = 'refunded';     // Возвращена
}
