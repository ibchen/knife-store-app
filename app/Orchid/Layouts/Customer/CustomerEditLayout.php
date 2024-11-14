<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Customer;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CustomerEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('customer.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('customer.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Input::make('customer.password')
                ->type('password')
                ->required()
                ->title(__('Password'))
                ->placeholder(__('Enter password')),
        ];
    }
}
