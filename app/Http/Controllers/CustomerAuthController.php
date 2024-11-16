<?php

namespace App\Http\Controllers;

use App\Exceptions\WrongCredentialsException;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Контроллер для управления аутентификацией клиентов.
 */
class CustomerAuthController extends Controller
{
    /**
     * Регистрация нового клиента.
     *
     * @param Request $request Запрос с данными клиента.
     * @return JsonResponse Токен аутентификации клиента.
     */
    public function register(Request $request): JsonResponse
    {
        // Валидация данных клиента
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ]);

        // Создание нового клиента
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Генерация токена для клиента
        $token = $customer->createToken('customer_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * Вход клиента в систему.
     *
     * @param Request $request Запрос с учетными данными клиента.
     * @return JsonResponse Токен аутентификации клиента.
     * @throws WrongCredentialsException Если учетные данные неверны.
     */
    public function login(Request $request): JsonResponse
    {
        // Валидация учетных данных
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Проверка существования клиента
        $customer = Customer::where('email', $request->email)->first();

        // Проверка корректности пароля
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            throw new WrongCredentialsException(); // Генерация исключения
        }

        // Генерация токена для клиента
        $token = $customer->createToken('customer_token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Выход клиента из системы.
     *
     * @param Request $request Запрос с данными клиента.
     * @return JsonResponse Подтверждение выхода из системы.
     */
    public function logout(Request $request): JsonResponse
    {
        // Удаление текущего токена доступа
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
