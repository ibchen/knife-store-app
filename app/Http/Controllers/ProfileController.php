<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show(Request $request): CustomerResource
    {
        $user = Auth::guard('sanctum')->user();
        return new CustomerResource($user);
    }

    public function update(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $profileData = $request->only('name', 'email');
        $validator = Validator::make($profileData, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update($profileData);

        $addresses = $request->input('addresses', []);
        foreach ($addresses as $addressData) {
            if (isset($addressData['id'])) {
                $address = $user->addresses()->find($addressData['id']);
                if ($address) {
                    $address->update($addressData);
                }
            } else {
                $validator = Validator::make($addressData, [
                    'country' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'street' => 'required|string|max:255',
                    'house' => 'nullable|string|max:255',
                    'apartment' => 'nullable|string|max:255',
                    'postal_code' => 'nullable|string|max:20',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $user->addresses()->create($addressData);
            }
        }

        return new CustomerResource($user->fresh());
    }

    public function deleteAddress(Request $request, $id)
    {
        $user = Auth::guard('sanctum')->user();
        $address = $user->addresses()->find($id);

        if ($address) {
            $address->delete();

            if ($address->is_primary) {
                $nextAddress = $user->addresses()->first();
                if ($nextAddress) {
                    $nextAddress->update(['is_primary' => true]);
                }
            }
        }

        return new CustomerResource($user->fresh());
    }
}
