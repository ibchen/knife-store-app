<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Customer;

use App\Models\Customer;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

/**
 * Класс CustomerListLayout
 *
 * Отображает список клиентов в виде таблицы с возможностью фильтрации, сортировки и действий.
 */
class CustomerListLayout extends Table
{
    /**
     * Целевая модель для отображения.
     *
     * @var string
     */
    public $target = 'customers';

    /**
     * Возвращает массив колонок для таблицы.
     *
     * @return TD[] Массив колонок.
     */
    public function columns(): array
    {
        return [
            // Колонка для отображения имени клиента
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Customer $customer) => $customer->name),

            // Колонка для отображения электронной почты клиента
            TD::make('email', __('Email'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Customer $customer) => ModalToggle::make($customer->email)
                    ->modal('editCustomerModal')
                    ->modalTitle($customer->name)
                    ->method('saveCustomer')
                    ->asyncParameters([
                        'customer' => $customer->id,
                    ])),

            // Колонка для отображения даты создания
            TD::make('created_at', __('Created'))
                ->render(fn(Customer $customer) => $customer->created_at?->format('Y-m-d H:i:s') ?? '—')
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            // Колонка для отображения даты последнего обновления
            TD::make('updated_at', __('Last edit'))
                ->render(fn(Customer $customer) => $customer->updated_at?->format('Y-m-d H:i:s') ?? '—')
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            // Колонка для отображения действий
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Customer $customer) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        // Ссылка на редактирование
                        Link::make(__('Edit'))
                            ->route('platform.systems.customers.edit', $customer->id)
                            ->icon('bs.pencil'),

                        // Кнопка удаления
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the customer is deleted, all of its data will be permanently deleted.'))
                            ->method('remove', [
                                'id' => $customer->id,
                            ]),
                    ])),
        ];
    }
}
