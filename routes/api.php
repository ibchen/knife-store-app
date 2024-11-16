<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Здесь определяются маршруты для API вашего приложения. Эти маршруты
| загружаются через `RouteServiceProvider` и помещаются в группу "api".
| Все маршруты префиксированы `/api`.
|
*/

// Маршруты для аутентификации клиентов
Route::post('/customer/login', [CustomerAuthController::class, 'login']); // Логин клиента
Route::post('/customer/register', [CustomerAuthController::class, 'register']); // Регистрация клиента
Route::middleware('auth:sanctum')->post('/customer/logout', [CustomerAuthController::class, 'logout']); // Логаут клиента

// Маршруты для профиля клиента
Route::middleware('auth:sanctum')->get('/customer/profile', [ProfileController::class, 'show']); // Просмотр профиля клиента
Route::middleware('auth:sanctum')->put('/customer/profile', [ProfileController::class, 'update']); // Обновление профиля клиента
Route::middleware('auth:sanctum')->delete('/customer/address/{id}', [ProfileController::class, 'deleteAddress']); // Удаление адреса клиента

// Маршрут для получения CSRF Cookie (используется для SPA)
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Маршруты для товаров
Route::get('/products', [ProductController::class, 'index']); // Получение списка всех товаров
Route::get('/products/{id}', [ProductController::class, 'show']); // Получение информации о конкретном товаре по ID

// Маршруты для категорий
Route::get('/categories', [CategoryController::class, 'index']); // Получение списка всех категорий

// Группа маршрутов для авторизованных пользователей
Route::middleware('auth:sanctum')->group(function () {
    // Маршруты для корзины
    Route::get('/cart', [CartController::class, 'index']); // Просмотр содержимого корзины
    Route::post('/cart/add', [CartController::class, 'add']); // Добавление товара в корзину
    Route::patch('/cart/update/{id}', [CartController::class, 'update']); // Обновление количества товара в корзине
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']); // Удаление товара из корзины

    // Маршруты для заказов
    Route::post('/order/place', [OrderController::class, 'placeOrder']); // Создание заказа
    Route::get('/orders', [OrderController::class, 'index']); // Просмотр всех заказов текущего пользователя
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Просмотр деталей конкретного заказа

    // Маршрут для обработки платежей
    Route::post('/payment/process', [PaymentController::class, 'processPayment']); // Обработка платежа за заказ
});
