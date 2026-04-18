<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    // ── Profile ───────────────────────────────────────────────────────────────

    public function profile()
    {
        $user = auth()->user()->load('addresses');
        return view('pages.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return back()->with('success', __('messages.account.profile_updated'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('messages.account.wrong_password')]);
        }

        $user->update(['password' => $request->password]);

        return back()->with('success', __('messages.account.password_updated'));
    }

    // ── Addresses ─────────────────────────────────────────────────────────────

    public function addresses()
    {
        $user      = auth()->user();
        $addresses = UserAddress::where('user_id', $user->id)
            ->orderByDesc('is_primary')
            ->orderByDesc('created_at')
            ->get();

        return view('pages.account.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
            'country'        => 'nullable|string|max:100',
        ]);

        $userId = auth()->id();
        $isPrimary = $request->boolean('is_primary') || UserAddress::where('user_id', $userId)->count() === 0;

        if ($isPrimary) {
            UserAddress::where('user_id', $userId)->update(['is_primary' => false]);
        }

        UserAddress::create([
            'user_id'        => $userId,
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'country'        => $request->country ?? 'Indonesia',
            'is_primary'     => $isPrimary,
        ]);

        return back()->with('success', __('messages.account.address_added'));
    }

    public function updateAddress(Request $request, UserAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
            'country'        => 'nullable|string|max:100',
        ]);

        $address->update([
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'country'        => $request->country ?? 'Indonesia',
        ]);

        return back()->with('success', __('messages.account.address_updated'));
    }

    public function destroyAddress(UserAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $wasPrimary = $address->is_primary;
        $address->delete();

        // Promote next address to primary if deleted was primary
        if ($wasPrimary) {
            UserAddress::where('user_id', auth()->id())->latest()->first()?->update(['is_primary' => true]);
        }

        return back()->with('success', __('messages.account.address_deleted'));
    }

    public function setPrimaryAddress(UserAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        UserAddress::where('user_id', auth()->id())->update(['is_primary' => false]);
        $address->update(['is_primary' => true]);

        return back()->with('success', __('messages.account.address_set_primary'));
    }
}
