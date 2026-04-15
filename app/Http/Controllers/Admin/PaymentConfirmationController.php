<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;

class PaymentConfirmationController extends Controller
{
    public function index()
    {
        $confirmations = PaymentConfirmation::with(['order', 'user'])->latest()->get();
        return view('admin.payment_confirmations.index', compact('confirmations'));
    }

    public function show(PaymentConfirmation $paymentConfirmation)
    {
        $paymentConfirmation->load(['order.items', 'user']);
        return view('admin.payment_confirmations.show', compact('paymentConfirmation'));
    }

    public function confirm(Request $request, PaymentConfirmation $paymentConfirmation)
    {
        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);

        $paymentConfirmation->update([
            'status' => 'confirmed',
            'admin_notes' => $request->input('admin_notes'),
            'confirmed_at' => now(),
        ]);

        $paymentConfirmation->order->update([
            'status' => 'processing',
        ]);

        return redirect()->route('admin.payment-confirmations.index')->with('success', 'Pembayaran berhasil dikonfirmasi. Status pesanan diubah menjadi processing.');
    }

    public function reject(Request $request, PaymentConfirmation $paymentConfirmation)
    {
        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $paymentConfirmation->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
            'confirmed_at' => now(),
        ]);

        return redirect()->route('admin.payment-confirmations.index')->with('error', 'Pembayaran ditolak. Silakan beri tahu customer untuk mengirim ulang bukti.');
    }
}
