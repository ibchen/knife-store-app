<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Order;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

/**
 * Класс OrderListLayout
 *
 * Отображает список заказов в виде таблицы с возможностью сортировки, фильтрации и действий.
 */
class OrderListLayout extends Table
{
    /**
     * Целевая модель для отображения.
     *
     * @var string
     */
    public $target = 'orders';

    /**
     * Возвращает массив колонок для таблицы.
     *
     * @return array Массив колонок.
     */
    public function columns(): array
    {
        return [
            // Колонка с идентификатором заказа
            TD::make('id', __('Order ID'))
                ->sort()
                ->cantHide()
                ->render(fn(Order $order) => $order->id),

            // Колонка с именем клиента
            TD::make('user_id', __('Customer'))
                ->render(fn(Order $order) => $order->user->name ?? '—'),

            // Колонка со статусом заказа
            TD::make('status', __('Status'))
                ->render(fn(Order $order) => ucfirst($order->status->value)),

            // Колонка с общей стоимостью заказа
            TD::make('total_price', __('Total Price'))
                ->render(fn(Order $order) => '$' . number_format((float)$order->total_price, 2)),

            // Колонка с адресом доставки
            TD::make('delivery_address', __('Delivery Address'))
                ->width('400px')
                ->render(fn(Order $order) => $order->delivery_address
                    ? '<pre>' . json_encode($order->delivery_address, JSON_PRETTY_PRINT) . '</pre>'
                    : '—'),

            // Колонка с датой создания заказа
            TD::make('created_at', __('Created At'))
                ->sort()
                ->render(fn(Order $order) => $order->created_at->format('Y-m-d H:i:s')),

            // Колонка с действиями
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Order $order) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        // Ссылка на редактирование заказа
                        Link::make(__('Edit'))
                            ->route('platform.systems.orders.edit', $order->id)
                            ->icon('bs.pencil'),

                        // Кнопка удаления заказа
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Are you sure you want to delete this order?'))
                            ->method('remove', [
                                'id' => $order->id,
                            ]),
                    ])),
        ];
    }
}
