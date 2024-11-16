<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Address;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;
use App\Models\Customer;

/**
 * Макет редактирования адреса.
 *
 * Содержит поля для ввода и редактирования данных адреса.
 */
class AddressEditLayout extends Rows
{
    /**
     * Возвращает массив полей для редактирования адреса.
     *
     * @return array Поля для формы.
     */
    public function fields(): array
    {
        return [
            // Поле выбора клиента
            Relation::make('address.customer_id')
                ->fromModel(Customer::class, 'name', 'id')
                ->title(__('Customer'))
                ->required(),

            // Поле ввода для страны
            Input::make('address.country')
                ->title(__('Country'))
                ->placeholder(__('Enter country'))
                ->required(),

            // Поле ввода для города
            Input::make('address.city')
                ->title(__('City'))
                ->placeholder(__('Enter city'))
                ->required(),

            // Поле ввода для улицы
            Input::make('address.street')
                ->title(__('Street'))
                ->placeholder(__('Enter street'))
                ->required(),

            // Поле ввода для номера дома
            Input::make('address.house')
                ->title(__('House'))
                ->placeholder(__('Enter house number'))
                ->required(),

            // Поле ввода для квартиры
            Input::make('address.apartment')
                ->title(__('Apartment'))
                ->placeholder(__('Enter apartment')),

            // Поле ввода для почтового кода
            Input::make('address.postal_code')
                ->title(__('Postal Code'))
                ->placeholder(__('Enter postal code')),

            // Переключатель для установки адреса как основного
            Switcher::make('address.is_primary')
                ->sendTrueOrFalse()
                ->title(__('Primary Address'))
                ->help(__('Set this address as the primary address for the customer.')),
        ];
    }
}
