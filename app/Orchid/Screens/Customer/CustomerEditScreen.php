<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Customer;

use App\Models\Customer;
use App\Orchid\Layouts\Customer\CustomerEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CustomerEditScreen extends Screen
{
    public ?Customer $customer = null;

    /**
     * Query data.
     */
    public function query(Customer $customer): iterable
    {
        $this->customer = $customer->exists ? $customer : new Customer();

        return [
            'customer' => $this->customer,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->customer && $this->customer->exists ? 'Edit Customer' : 'Create Customer';
    }

    /**
     * Button commands.
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.save')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): iterable
    {
        return [
            Layout::block(CustomerEditLayout::class),
        ];
    }

    /**
     * Save customer data.
     */
    public function save(Request $request, Customer $customer): void
    {
        $data = $request->validate([
            'customer.email' => 'required|email|unique:customers,email,' . ($customer->id ?? 'NULL'),
            'customer.name' => 'required|max:255',
            'customer.password' => $customer->exists ? 'nullable' : 'required|min:8', // Пароль обязателен только при создании
        ]);

        // Хешируем пароль, если он введён
        if (!empty($data['customer']['password'])) {
            $data['customer']['password'] = bcrypt($data['customer']['password']);
        } else {
            unset($data['customer']['password']); // Убираем поле, если оно пустое при редактировании
        }

        $customer->fill($data['customer'])->save();

        Toast::info(__('Customer was saved.'));
    }
}
