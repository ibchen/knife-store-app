<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Customer;

use App\Models\Customer;
use App\Orchid\Layouts\Customer\CustomerEditLayout;
use App\Orchid\Layouts\Customer\CustomerListLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CustomerListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'customers' => Customer::orderBy('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Customer Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A list of all registered customers.';
    }

    /**
     * The screen's action buttons.
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add Customer'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.customers.create'),
        ];
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): iterable
    {
        return [
            CustomerListLayout::class,

            // Модальное окно для редактирования данных клиента
            Layout::modal('editCustomerModal', CustomerEditLayout::class)
                ->title(__('Edit Customer'))
                ->applyButton(__('Save'))
                ->closeButton(__('Cancel'))
                ->async('asyncGetCustomer'),
        ];
    }

    /**
     * Загружает данные клиента при открытии модального окна.
     */
    public function asyncGetCustomer(Customer $customer): iterable
    {
        return [
            'customer' => $customer,
        ];
    }

    /**
     * Сохраняет изменения в данных клиента.
     */
    public function saveCustomer(Request $request, Customer $customer): void
    {
        $request->validate([
            'customer.email' => [
                'required',
                Rule::unique(Customer::class, 'email')->ignore($customer),
            ],
            'customer.name' => 'required|max:255',
        ]);

        $customer->fill($request->input('customer'))->save();

        Toast::info(__('Customer was saved.'));
    }

    /**
     * Удаляет клиента.
     */
    public function remove(Request $request): void
    {
        Customer::findOrFail($request->get('id'))->delete();

        Toast::info(__('Customer was removed'));
    }
}
