<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Возвращает профиль аутентифицированного пользователя.
     *
     * @param Request $request
     * @return CustomerResource
     */
    public function show(Request $request): CustomerResource
    {
        $user = Auth::guard('sanctum')->user();
        return new CustomerResource($user);
    }

    /**
     * Обновляет профиль и адреса аутентифицированного пользователя.
     *
     * @param Request $request
     * @return CustomerResource|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Валидация данных профиля
        $profileData = $request->only('name', 'email');
        $validator = Validator::make($profileData, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Обновление профиля пользователя
        $user->update($profileData);

        // Обработка адресов пользователя
        $addresses = $request->input('addresses', []);
        foreach ($addresses as $addressData) {
            if (isset($addressData['id'])) {
                // Обновляем существующий адрес
                $address = $user->addresses()->find($addressData['id']);
                if ($address) {
                    $address->update($addressData);
                }
            } else {
                // Создаём новый адрес, если ID нет
                $validator = Validator::make($addressData, [
                    'country' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'street' => 'required|string|max:255',
                    'house' => 'nullable|string|max:255',
                    'apartment' => 'nullable|string|max:255',
                    'postal_code' => 'nullable|string|max:20',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                // Создаём новый адрес, связанный с пользователем
                $user->addresses()->create($addressData);
            }
        }

        return new CustomerResource($user->fresh());
    }
}
