<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Verify order belongs to authenticated user
        if ($order->customer_email !== auth()->user()->email) {
            abort(403);
        }

        // Only allow reviews on completed orders
        if ($order->status !== 'completed') {
            return back()->with('error', __('messages.review.error_not_completed'));
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ]);

        // Verify the product was actually in this order
        $productName = Product::find($request->product_id)?->name;
        $inOrder = $order->items()->where('product_name', $productName)->exists();

        if (! $inOrder) {
            return back()->with('error', __('messages.review.error_not_in_order'));
        }

        // Prevent duplicate review
        $exists = ProductReview::where([
            'product_id' => $request->product_id,
            'order_id'   => $order->id,
            'user_id'    => auth()->id(),
        ])->exists();

        if ($exists) {
            return back()->with('error', __('messages.review.error_duplicate'));
        }

        ProductReview::create([
            'product_id' => $request->product_id,
            'order_id'   => $order->id,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', __('messages.review.success'));
    }
}
