<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemResource;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для управления корзиной пользователя.
 */
class CartController extends Controller
{
    /**
     * Отображает содержимое корзины пользователя.
     *
     * @param Request $request Запрос, содержащий информацию о пользователе.
     * @return JsonResponse Список товаров в корзине.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $cartItems = CartItem::with(['product'])->where('user_id', $user->id)->where('is_purchased', false)->get();

        return response()->json(CartItemResource::collection($cartItems));
    }

    /**
     * Добавляет товар в корзину.
     *
     * @param Request $request Запрос с данными о продукте и количестве.
     * @return JsonResponse Подтверждение добавления товара в корзину.
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('is_purchased', false)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'is_purchased' => false,
            ]);
        }

        return response()->json(['message' => 'Товар добавлен в корзину']);
    }

    /**
     * Обновляет количество товара в корзине.
     *
     * @param Request $request Запрос с новым количеством товара.
     * @param int $id Идентификатор элемента корзины.
     * @return JsonResponse Подтверждение обновления количества.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('id', $id)
            ->where('is_purchased', false)
            ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['message' => 'Количество товара обновлено']);
    }

    /**
     * Удаляет товар из корзины.
     *
     * @param Request $request Запрос, содержащий информацию о пользователе.
     * @param int $id Идентификатор элемента корзины.
     * @return JsonResponse Подтверждение удаления товара из корзины.
     */
    public function remove(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('id', $id)
            ->where('is_purchased', false)
            ->firstOrFail();

        $cartItem->delete();

        return response()->json(['message' => 'Товар удален из корзины']);
    }
}
