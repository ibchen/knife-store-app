<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Exceptions\EmptyCartException;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;

/**
 * Контроллер для управления заказами пользователей.
 */
class OrderController extends Controller
{
    /**
     * Оформляет заказ для текущего пользователя.
     *
     * @param Request $request Запрос с данными о заказе.
     * @return JsonResponse Информация о созданном заказе.
     * @throws EmptyCartException Если корзина пользователя пуста.
     */
    public function placeOrder(Request $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        // Получаем все товары в корзине, которые еще не были куплены
        $cartItems = CartItem::where('user_id', $user->id)
            ->where('is_purchased', false)
            ->with('product')
            ->get();

        // Если корзина пуста, выбрасываем исключение
        if ($cartItems->isEmpty()) {
            throw new EmptyCartException();
        }

        // Рассчитываем общую стоимость заказа
        $totalPrice = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Создаем заказ с начальным статусом "в ожидании"
        $order = Order::create([
            'user_id' => $user->id,
            'status' => OrderStatus::Pending->value,
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

        // Возвращаем данные о созданном заказе
        return response()->json([
            'order_id' => $order->id,
            'order' => new OrderResource($order->load(['orderItems.product', 'user.addresses']))
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

        // Получаем все заказы текущего пользователя
        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'user.addresses']) // Подгружаем связанные данные
            ->get();

        // Возвращаем список заказов в виде ресурсов
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

        // Находим заказ по ID, принадлежащий текущему пользователю
        $order = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'user.addresses']) // Подгружаем связанные данные
            ->findOrFail($id);

        // Возвращаем детали заказа
        return response()->json(new OrderResource($order));
    }
}
