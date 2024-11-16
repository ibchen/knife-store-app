<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Контроллер для управления профилем клиента.
 */
class ProfileController extends Controller
{
    /**
     * Отображает профиль текущего пользователя.
     *
     * @param Request $request Запрос текущего пользователя.
     * @return CustomerResource Ресурс профиля клиента.
     */
    public function show(Request $request): CustomerResource
    {
        $user = Auth::guard('sanctum')->user();
        return new CustomerResource($user);
    }

    /**
     * Обновляет профиль текущего пользователя, включая адреса.
     *
     * @param Request $request Запрос с данными для обновления профиля и адресов.
     * @return CustomerResource|JsonResponse Обновленный ресурс профиля клиента.
     */
    public function update(Request $request): CustomerResource | JsonResponse
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

        // Обновление данных пользователя
        $user->update($profileData);

        // Обновление или создание адресов
        $addresses = $request->input('addresses', []);
        foreach ($addresses as $addressData) {
            if (isset($addressData['id'])) {
                // Обновляем существующий адрес
                $address = $user->addresses()->find($addressData['id']);
                if ($address) {
                    $address->update($addressData);
                }
            } else {
                // Валидация нового адреса
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

                // Создаем новый адрес
                $user->addresses()->create($addressData);
            }
        }

        // Возвращаем обновленные данные профиля
        return new CustomerResource($user->fresh());
    }

    /**
     * Удаляет адрес текущего пользователя.
     *
     * @param Request $request Запрос текущего пользователя.
     * @param int $id Идентификатор адреса.
     * @return CustomerResource Обновленный ресурс профиля клиента.
     */
    public function deleteAddress(Request $request, int $id): CustomerResource
    {
        $user = Auth::guard('sanctum')->user();
        $address = $user->addresses()->find($id);

        if ($address) {
            $address->delete();

            // Если удаленный адрес был основным, назначаем новый основной адрес
            if ($address->is_primary) {
                $nextAddress = $user->addresses()->first();
                if ($nextAddress) {
                    $nextAddress->update(['is_primary' => true]);
                }
            }
        }

        // Возвращаем обновленные данные профиля
        return new CustomerResource($user->fresh());
    }
}
