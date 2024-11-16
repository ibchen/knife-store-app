<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;

/**
 * Контроллер для обработки платежей.
 */
class PaymentController extends Controller
{
    /**
     * Обрабатывает оплату заказа.
     *
     * @param Request $request Запрос с данными о платеже.
     * @return JsonResponse Информация о статусе оплаты.
     */
    public function processPayment(Request $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        // Валидация входных данных
        $validatedData = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'delivery_address' => 'required|array',
        ]);

        $orderId = $validatedData['order_id'];
        $amount = $validatedData['amount'];
        $deliveryAddress = $validatedData['delivery_address'];

        // Получаем заказ, который принадлежит текущему пользователю
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->with(['payment', 'orderItems.product'])
            ->firstOrFail();

        // Проверка: заказ уже оплачен
        if ($order->payment && $order->payment->status === PaymentStatus::Completed) {
            return response()->json(['error' => 'Заказ уже был оплачен'], 400);
        }

        // Проверка: статус заказа
        if ($order->status === OrderStatus::Paid->value) {
            return response()->json(['error' => 'Заказ уже был оплачен'], 400);
        }

        // Проверка суммы оплаты
        if ($amount != $order->total_price) {
            return response()->json(['error' => 'Некорректная сумма оплаты'], 400);
        }

        // Обновление остатков товаров на складе
        foreach ($order->orderItems as $orderItem) {
            $product = $orderItem->product;

            if ($product->stock < $orderItem->quantity) {
                return response()->json([
                    'error' => "Недостаточно товара \"{$product->name}\" на складе"
                ], 400);
            }

            $product->stock -= $orderItem->quantity;
            $product->save();
        }

        // Обновление заказа с адресом доставки
        $order->update([
            'delivery_address' => $deliveryAddress,
            'status' => OrderStatus::Paid->value, // Устанавливаем статус на "оплачен"
        ]);

        // Создание записи о платеже
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'status' => PaymentStatus::Completed->value, // Устанавливаем статус оплаты как завершенную
            'payment_date' => now(),
        ]);

        // Возврат успешного ответа
        return response()->json([
            'message' => 'Оплата успешно обработана',
            'payment' => $payment,
            'delivery_address' => $order->delivery_address,
        ]);
    }
}
