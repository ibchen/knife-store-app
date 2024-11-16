<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Address;

use App\Models\Address;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

/**
 * Класс AddressListLayout
 *
 * Отображает список адресов в виде таблицы с возможностью сортировки и действий.
 */
class AddressListLayout extends Table
{
    /**
     * Целевая модель для отображения.
     *
     * @var string
     */
    public $target = 'addresses';

    /**
     * Возвращает колонки таблицы.
     *
     * @return array Колонки таблицы.
     */
    public function columns(): array
    {
        return [
            // Колонка для отображения клиента
            TD::make('customer', __('Customer'))
                ->render(function (Address $address) {
                    $customer = $address->customer;
                    return $customer
                        ? e("{$customer->name} ({$customer->email})")
                        : '<span>' . __('No Customer') . '</span>';
                })
                ->align(TD::ALIGN_CENTER),

            // Колонка для страны
            TD::make('country', __('Country'))->sort(),

            // Колонка для города
            TD::make('city', __('City'))->sort(),

            // Колонка для улицы
            TD::make('street', __('Street')),

            // Колонка для номера дома
            TD::make('house', __('House')),

            // Колонка для квартиры
            TD::make('apartment', __('Apartment')),

            // Колонка для почтового индекса
            TD::make('postal_code', __('Postal Code')),

            // Колонка для отображения статуса "Основной адрес"
            TD::make('is_primary', __('Primary'))
                ->render(fn (Address $address) => $address->is_primary ? __('Yes') : __('No'))
                ->sort(),

            // Колонка для действий
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Address $address) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        // Ссылка на редактирование
                        Link::make(__('Edit'))
                            ->route('platform.systems.addresses.edit', $address->id)
                            ->icon('bs.pencil'),

                        // Кнопка удаления
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
