<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Layouts\Order\OrderListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class OrderListScreen extends Screen
{
    public function name(): ?string
    {
        return __('Orders');
    }

    public function query(): iterable
    {
        return [
            'orders' => Order::with('user')->paginate(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add Order'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.orders.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            OrderListLayout::class,
        ];
    }
}
