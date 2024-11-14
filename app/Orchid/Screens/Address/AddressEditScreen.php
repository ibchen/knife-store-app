<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Address;

use App\Models\Address;
use App\Orchid\Layouts\Address\AddressEditLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AddressEditScreen extends Screen
{
    public ?Address $address = null;

    public function query(Address $address): iterable
    {
        $this->address = $address->exists ? $address : new Address();

        return [
            'address' => $this->address,
        ];
    }

    public function name(): ?string
    {
        return $this->address && $this->address->exists ? 'Edit Address' : 'Create Address';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.save')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(AddressEditLayout::class),
        ];
    }

    public function save(Request $request, Address $address): void
    {
        $data = $request->validate([
            'address.customer_id' => 'required|exists:customers,id',
            'address.country' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.street' => 'required|string|max:255',
            'address.house' => 'required|string|max:255',
            'address.apartment' => 'nullable|string|max:255',
            'address.postal_code' => 'nullable|string|max:255',
            'address.is_primary' => 'boolean',
        ]);

        $address->fill($data['address'])->save();

        Toast::info(__('Address was saved.'));
    }
}
