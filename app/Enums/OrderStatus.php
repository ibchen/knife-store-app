<?php

namespace App\Enums;

/**
 * Перечисление статусов заказа
 */
enum OrderStatus: string
{
    case Pending = 'pending';       // В ожидании
    case Paid = 'paid';             // Оплачен
    case Processing = 'processing'; // В обработке
    case Shipped = 'shipped';       // Отправлен
    case Delivered = 'delivered';   // Доставлен
    case Canceled = 'canceled';     // Отменен

    /**
     * Возвращает статусы заказа в виде массива для выпадающего списка
     *
     * @return array Массив статусов, где ключ - значение статуса, а значение - имя статуса с первой заглавной буквой
     */
    public static function asSelectArray(): array
    {
        return array_column(
            array_map(
                fn(self $status) => [$status->value => ucfirst($status->name)],
                self::cases()
            ),
            0
        );
    }
}
