<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Layouts\Order\OrderEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderEditScreen extends Screen
{
    public ?Order $order = null;

    public function query(Order $order): iterable
    {
        $this->order = $order->exists ? $order : new Order();

        return [
            'order' => $this->order,
        ];
    }

    public function name(): ?string
    {
        return $this->order->exists ? 'Edit Order' : 'Create Order';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.save')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(OrderEditLayout::class),
        ];
    }

    public function save(Request $request, Order $order): void
    {
        $data = $request->validate([
            'order.user_id' => 'required|exists:customers,id',
            'order.status' => 'required|string',
            'order.total_price' => 'required|numeric',
            'order.delivery_address' => 'nullable|string',
        ]);

        $order->fill([
            'user_id' => $data['order']['user_id'],
            'status' => $data['order']['status'],
            'total_price' => $data['order']['total_price'],
            'delivery_address' => $data['order']['delivery_address'] ? json_decode($data['order']['delivery_address'], true) : null,
        ])->save();

        Toast::info(__('Order was saved successfully.'));
    }
}
