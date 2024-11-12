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

        // Обновление адресов пользователя
        $addresses = $request->input('addresses', []);
        foreach ($addresses as $addressData) {
            $address = $user->addresses()->find($addressData['id']);
            if ($address) {
                $address->update($addressData);
            }
        }

        return new CustomerResource($user->fresh());
    }
}
