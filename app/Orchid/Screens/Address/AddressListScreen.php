<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Address;

use App\Models\Address;
use App\Orchid\Layouts\Address\AddressListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AddressListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Address Management';
    }

    public function query(): iterable
    {
        return [
            'addresses' => Address::with('customer')->paginate(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add Address'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.addresses.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            AddressListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        Address::findOrFail($request->get('id'))->delete();

        Toast::info(__('Address was removed.'));
    }
}
