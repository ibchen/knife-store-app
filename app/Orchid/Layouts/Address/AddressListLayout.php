<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Address;

use App\Models\Address;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AddressListLayout extends Table
{
    public $target = 'addresses';

    public function columns(): array
    {
        return [
            TD::make('customer', __('Customer'))
                ->render(function (Address $address) {
                    $customer = $address->customer;
                    return $customer
                        ? "{$customer->name} ({$customer->email})"
                        : '<span>No Customer</span>';
                })
                ->align(TD::ALIGN_CENTER),

            TD::make('country', __('Country'))->sort(),
            TD::make('city', __('City'))->sort(),
            TD::make('street', __('Street')),
            TD::make('house', __('House')),
            TD::make('apartment', __('Apartment')),
            TD::make('postal_code', __('Postal Code')),
            TD::make('is_primary', __('Primary'))
                ->render(fn (Address $address) => $address->is_primary ? 'Yes' : 'No')
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Address $address) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.systems.addresses.edit', $address->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Are you sure you want to delete this address?'))
                            ->method('remove', [
                                'id' => $address->id,
                            ]),
                    ])),
        ];
    }
}
