<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Исключение для обработки пустой корзины.
 */
class EmptyCartException extends Exception
{
    /**
     * Создает новый экземпляр исключения.
     *
     * @param string $message Сообщение об ошибке.
     */
    public function __construct(string $message = "Ваша корзина пуста")
    {
        parent::__construct($message, 400); // HTTP-код 400 (Bad Request)
    }

    /**
     * Возвращает ответ в формате JSON для исключения.
     *
     * @return JsonResponse JSON-ответ с кодом 400.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }
}
