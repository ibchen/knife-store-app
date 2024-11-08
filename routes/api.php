<?php

use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/customer/logout', [CustomerAuthController::class, 'logout']);
