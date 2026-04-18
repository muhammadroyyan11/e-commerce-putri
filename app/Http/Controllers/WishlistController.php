<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // F8: Generate share token stored in session
        $shareToken = session('wishlist_share_token');
        if (! $shareToken) {
            $shareToken = base64_encode(auth()->id() . ':' . substr(md5(auth()->id() . config('app.key')), 0, 12));
            session(['wishlist_share_token' => $shareToken]);
        }
        $shareUrl = route('wishlist.shared', ['token' => $shareToken]);

        return view('pages.wishlist', compact('wishlists', 'shareUrl'));
    }

    // F8: Public shared wishlist view
    public function shared(string $token)
    {
        // Decode token to get user_id
        $decoded = base64_decode($token);
        [$userId] = explode(':', $decoded);
        $userId = (int) $userId;

        // Verify token matches
        $expectedToken = base64_encode($userId . ':' . substr(md5($userId . config('app.key')), 0, 12));
        if ($token !== $expectedToken) {
            abort(404);
        }

        $owner     = User::findOrFail($userId);
        $wishlists = Wishlist::with('product.category')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('pages.wishlist-shared', compact('wishlists', 'owner'));
    }
}
