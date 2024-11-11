<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Получаем аутентифицированного пользователя
        $user = Auth::guard('sanctum')->user();

        // Возвращаем ресурс пользователя
        return new CustomerResource($user);
    }
}
