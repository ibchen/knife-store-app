<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Исключение для обработки неверных учетных данных.
 */
class WrongCredentialsException extends Exception
{
    /**
     * Создает новый экземпляр исключения.
     *
     * @param string $message Сообщение об ошибке.
     */
    public function __construct(string $message = "Неверные учетные данные")
    {
        parent::__construct($message, 401); // HTTP-код 401 (Unauthorized)
    }

    /**
     * Возвращает ответ в формате JSON для исключения.
     *
     * @return JsonResponse JSON-ответ с кодом 401.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }
}
