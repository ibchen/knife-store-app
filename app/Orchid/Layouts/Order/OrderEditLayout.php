<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Customer;
use App\Enums\OrderStatus;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class OrderEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Relation::make('order.user_id')
                ->fromModel(Customer::class, 'name')
                ->required()
                ->title(__('Customer')),

            Select::make('order.status')
                ->options($this->getOrderStatusOptions())
                ->required()
                ->title(__('Status'))
                ->value(fn($value) => $value instanceof OrderStatus ? $value->value : $value), // Обработка объекта OrderStatus,

            Input::make('order.total_price')
                ->type('number')
                ->required()
                ->title(__('Total Price')),

            TextArea::make('order.delivery_address')
                ->title(__('Delivery Address'))
                ->rows(5)
                ->placeholder(__('Enter delivery address as JSON string'))
                ->value(fn($value) => is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : $value), // Преобразование JSON в строку для отображения,
        ];
    }

    /**
     * Получить массив статусов заказа для поля Select.
     *
     * @return array<string, string>
     */
    private function getOrderStatusOptions(): array
    {
        $statuses = [];
        foreach (OrderStatus::cases() as $status) {
            $statuses[$status->value] = ucfirst($status->name); // Используем значение и имя статуса
        }

        return $statuses;
    }
}
