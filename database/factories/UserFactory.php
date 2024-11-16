<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Фабрика для создания моделей пользователей.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Текущий пароль, используемый фабрикой.
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Определяет стандартное состояние модели.
     *
     * @return array<string, mixed> Ассоциативный массив с данными для создания модели.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // Генерация случайного имени пользователя
            'email' => fake()->unique()->safeEmail(), // Генерация уникального email-адреса
            'email_verified_at' => now(), // Дата и время подтверждения email
            'password' => static::$password ??= Hash::make('password'), // Хешированный пароль (по умолчанию 'password')
            'remember_token' => Str::random(10), // Случайный токен для запоминания сессии
            'permissions' => '{"platform.index": true}', // Права доступа пользователя
        ];
    }

    /**
     * Указывает, что email-адрес модели должен быть неподтверждённым.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // Сбрасывает дату подтверждения email
        ]);
    }
}
