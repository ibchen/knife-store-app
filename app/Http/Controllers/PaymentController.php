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
        $orderId = $request->input('order_id');
        $amount = $request->input('amount');

        // Получаем заказ, который принадлежит текущему пользователю
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->with('payment')
            ->first();

        // Проверка существования заказа
        if (!$order) {
            return response()->json(['error' => 'Заказ не найден или принадлежит другому пользователю'], 404);
        }


        // Проверка, была ли уже выполнена оплата
        if ($order->payment && $order->payment->status === PaymentStatus::Completed) {
            return response()->json(['error' => 'Заказ уже был оплачен'], 400);
        }

        // Проверка статуса заказа
        if ($order->status === OrderStatus::Paid->value) {
            return response()->json(['error' => 'Заказ уже был оплачен'], 400);
        }

        // Проверка суммы оплаты
        if ($amount != $order->total_price) {
            return response()->json(['error' => 'Некорректная сумма оплаты'], 400);
        }

        // Создание записи о платеже
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'status' => PaymentStatus::Completed->value, // Устанавливаем статус оплаты как завершенную
            'payment_date' => now(),
        ]);

        // Обновление статуса заказа на "оплачен"
        $order->update(['status' => OrderStatus::Paid->value]);

        return response()->json(['message' => 'Оплата успешно обработана', 'payment' => $payment]);
    }
}
