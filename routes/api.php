<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/customer/logout', [CustomerAuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/customer/profile', [ProfileController::class, 'show']);


Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Маршруты для товаров
Route::get('/products', [ProductController::class, 'index']); // Получение списка всех товаров
Route::get('/products/{id}', [ProductController::class, 'show']); // Получение информации о конкретном товаре по его ID

// Маршрут для получения списка категорий
Route::get('/categories', [CategoryController::class, 'index']); // Получение списка всех категорий
