<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;

class PaymentConfirmationController extends Controller
{
    public function create(Order $order)
    {
        if ($order->customer_email !== auth()->user()->email) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'awaiting_confirmation'])) {
            return redirect()->route('home')->with('error', 'Pesanan ini tidak dapat dikonfirmasi pembayarannya.');
        }

        $order->load('paymentMethod', 'items');
        return view('pages.payment-confirmation', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->customer_email !== auth()->user()->email) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'awaiting_confirmation'])) {
            return redirect()->route('home')->with('error', 'Pesanan ini tidak dapat dikonfirmasi pembayarannya.');
        }

        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('proof_image')) {
            $validated['proof_image'] = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        PaymentConfirmation::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => auth()->id(),
                'sender_name' => $validated['sender_name'],
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'notes' => $validated['notes'] ?? null,
                'proof_image' => $validated['proof_image'] ?? null,
                'status' => 'pending',
                'admin_notes' => null,
                'confirmed_at' => null,
            ]
        );

        $order->update(['status' => 'awaiting_confirmation']);

        return redirect()->route('order.success')->with('order', [
            'number' => $order->order_number,
            'date' => $order->created_at->format('d F Y'),
            'total' => $order->total,
            'payment_method' => $order->paymentMethod?->display_name ?? $order->payment_method,
        ])->with('success', 'Konfirmasi pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
