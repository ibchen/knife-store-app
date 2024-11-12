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

Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/customer/logout', [CustomerAuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/customer/profile', [ProfileController::class, 'show']);
Route::middleware('auth:sanctum')->put('/customer/profile', [ProfileController::class, 'update']);


Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Маршруты для товаров
Route::get('/products', [ProductController::class, 'index']); // Получение списка всех товаров
Route::get('/products/{id}', [ProductController::class, 'show']); // Получение информации о конкретном товаре по его ID

// Маршрут для получения списка категорий
Route::get('/categories', [CategoryController::class, 'index']); // Получение списка всех категорий

// Группа маршрутов для корзины и заказов, доступных только авторизованным пользователям
Route::middleware('auth:sanctum')->group(function () {
    // Маршруты для корзины
    Route::get('/cart', [CartController::class, 'index']); // Отображение содержимого корзины текущего пользователя
    Route::post('/cart/add', [CartController::class, 'add']); // Добавление товара в корзину
    Route::patch('/cart/update/{id}', [CartController::class, 'update']); // Обновление количества товара в корзине по ID элемента
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']); // Удаление товара из корзины по ID элемента

    // Маршруты для заказов
    Route::post('/order/place', [OrderController::class, 'placeOrder']); // Создание нового заказа на основе содержимого корзины
    Route::get('/orders', [OrderController::class, 'index']); // Получение списка всех заказов текущего пользователя
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Просмотр деталей конкретного заказа по его ID

    // Маршрут для обработки платежа
    Route::post('/payment/process', [PaymentController::class, 'processPayment']); // Обработка платежа за заказ
});
