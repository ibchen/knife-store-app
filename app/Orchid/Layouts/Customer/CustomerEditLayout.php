<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Customer;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

/**
 * Класс CustomerEditLayout
 *
 * Отображает форму редактирования или создания клиента.
 */
class CustomerEditLayout extends Rows
{
    /**
     * Возвращает элементы формы для экрана редактирования клиента.
     *
     * @return Field[] Массив полей формы.
     */
    public function fields(): array
    {
        return [
            // Поле ввода имени клиента
            Input::make('customer.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Enter name')),

            // Поле ввода электронной почты
            Input::make('customer.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Enter email')),

            // Поле ввода пароля
            Input::make('customer.password')
                ->type('password')
                ->title(__('Password'))
                ->placeholder(__('Enter password'))
                ->help(__('Leave blank if you do not want to change the password.')),
        ];
    }
}
