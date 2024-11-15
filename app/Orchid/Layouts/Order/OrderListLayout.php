<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Order;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrderListLayout extends Table
{
    public $target = 'orders';

    public function columns(): array
    {
        return [
            TD::make('id', __('Order ID'))
                ->sort()
                ->cantHide()
                ->render(fn(Order $order) => $order->id),

            TD::make('user_id', __('Customer'))
                ->render(fn(Order $order) => $order->user->name ?? '—'),

            TD::make('status', __('Status'))
                ->render(fn(Order $order) => ucfirst($order->status->value)),

            TD::make('total_price', __('Total Price'))
                ->render(fn(Order $order) => '$' . number_format((float)$order->total_price, 2)),

            TD::make('delivery_address', __('Delivery Address'))
                ->width('400px')
                ->render(fn(Order $order) => $order->delivery_address ? json_encode($order->delivery_address, JSON_PRETTY_PRINT) : '—'),

            TD::make('created_at', __('Created At'))
                ->sort()
                ->render(fn(Order $order) => $order->created_at->format('Y-m-d H:i:s')), // Формат даты и времени

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Order $order) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.systems.orders.edit', $order->id)
                            ->icon('bs.pencil'),

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
