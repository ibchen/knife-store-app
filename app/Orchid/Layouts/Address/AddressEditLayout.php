<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Address;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;
use App\Models\Customer;

class AddressEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Relation::make('address.customer_id')
                ->fromModel(Customer::class, 'name', 'id')
                ->title(__('Customer'))
                ->required(),

            Input::make('address.country')
                ->title(__('Country'))
                ->placeholder(__('Enter country'))
                ->required(),

            Input::make('address.city')
                ->title(__('City'))
                ->placeholder(__('Enter city'))
                ->required(),

            Input::make('address.street')
                ->title(__('Street'))
                ->placeholder(__('Enter street'))
                ->required(),

            Input::make('address.house')
                ->title(__('House'))
                ->placeholder(__('Enter house number'))
                ->required(),

            Input::make('address.apartment')
                ->title(__('Apartment'))
                ->placeholder(__('Enter apartment')),

            Input::make('address.postal_code')
                ->title(__('Postal Code'))
                ->placeholder(__('Enter postal code')),

            Switcher::make('address.is_primary')
                ->sendTrueOrFalse()
                ->title(__('Primary Address'))
                ->help(__('Set this address as the primary address for the customer.')),
        ];
    }
}
