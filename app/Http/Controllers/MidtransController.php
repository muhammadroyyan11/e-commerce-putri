<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config as MidtransConfig;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey = config('services.midtrans.server_key');
        MidtransConfig::$isProduction = config('services.midtrans.is_production');
    }

    public function notification(Request $request)
    {
        $notification = new Notification();

        $order = Order::where('order_number', $notification->order_id)->firstOrFail();

        $status = match ($notification->transaction_status) {
            'capture', 'settlement' => 'processing',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'cancelled',
            default => $order->status,
        };

        $order->update(['status' => $status]);

        return response()->json(['status' => 'ok']);
    }

    public function finish(Request $request)
    {
        $orderNumber = $request->query('order_id');
        $order = Order::where('order_number', $orderNumber)->first();

        return redirect()->route('order.success')->with('order', $order);
    }

    public function unfinish(Request $request)
    {
        return redirect()->route('checkout')->with('error', 'Pembayaran belum selesai. Silakan coba lagi.');
    }

    public function error(Request $request)
    {
        return redirect()->route('checkout')->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }
}
