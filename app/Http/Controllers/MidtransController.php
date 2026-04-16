<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function notification(Request $request, MidtransService $midtrans)
    {
        $payload = $request->all();

        // Verify signature
        $signatureKey = $payload['signature_key'] ?? '';
        $orderId      = $payload['order_id'] ?? '';
        $statusCode   = $payload['status_code'] ?? '';
        $grossAmount  = $payload['gross_amount'] ?? '';

        if (!$midtrans->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            return response()->json(['status' => 'invalid signature'], 403);
        }

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) {
            return response()->json(['status' => 'order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status'] ?? '';

        $status = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'processing',
            $transactionStatus === 'settlement'                           => 'processing',
            $transactionStatus === 'pending'                              => 'pending',
            in_array($transactionStatus, ['deny', 'cancel', 'expire'])   => 'cancelled',
            default => $order->status,
        };

        $order->update(['status' => $status]);

        return response()->json(['status' => 'ok']);
    }

    public function finish(Request $request)
    {
        $order = Order::where('order_number', $request->query('order_id'))->first();
        if ($order) {
            return redirect()->route('payment.detail', $order);
        }
        return redirect()->route('home');
    }

    public function unfinish(Request $request)
    {
        $order = Order::where('order_number', $request->query('order_id'))->first();
        if ($order) {
            return redirect()->route('payment.detail', $order);
        }
        return redirect()->route('home');
    }

    public function error(Request $request)
    {
        $order = Order::where('order_number', $request->query('order_id'))->first();
        if ($order) {
            return redirect()->route('payment.detail', $order)->with('error', 'Pembayaran gagal.');
        }
        return redirect()->route('home');
    }
}
