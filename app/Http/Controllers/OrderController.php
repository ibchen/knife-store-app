<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Оформляет заказ для текущего пользователя.
     *
     * @param Request $request Запрос с данными о заказе.
     * @return JsonResponse Информация о созданном заказе.
     */
    public function placeOrder(Request $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        // Получаем все товары в корзине, которые не были куплены
        $cartItems = CartItem::where('user_id', $user->id)
            ->where('is_purchased', false)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Ваша корзина пуста'], 400);
        }

        // Рассчитываем общую стоимость заказа
        $totalPrice = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Создаем запись заказа с начальным статусом
        $order = Order::create([
            'user_id' => $user->id,
            'status' => OrderStatus::Pending->value, // Статус по умолчанию
            'total_price' => $totalPrice,
        ]);

        // Переносим товары из корзины в OrderItem и помечаем их как купленные
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
            $cartItem->update(['is_purchased' => true]);
        }

        // Возвращаем данные о созданном заказе в виде ресурса, включая ID заказа
        return response()->json([
            'order_id' => $order->id,
            'order' => new OrderResource($order->load(['orderItems']))
        ]);
    }

    /**
     * Получает список всех заказов текущего пользователя.
     *
     * @return JsonResponse Список всех заказов пользователя.
     */
    public function index(): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $orders = Order::where('user_id', $user->id)
            ->with('orderItems')
            ->get();

        return response()->json(OrderResource::collection($orders));
    }

    /**
     * Просмотр деталей конкретного заказа.
     *
     * @param int $id Идентификатор заказа.
     * @return JsonResponse Информация о заказе.
     */
    public function show(int $id): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $order = Order::where('user_id', $user->id)
            ->with('orderItems')
            ->findOrFail($id);

        return response()->json(new OrderResource($order));
    }
}
