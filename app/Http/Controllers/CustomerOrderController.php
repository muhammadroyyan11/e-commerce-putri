<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerOrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $email = auth()->user()->email;

        $ordersQuery = Order::with(['items', 'paymentConfirmation', 'paymentMethod'])
            ->where('customer_email', $email)
            ->latest();

        if ($status && in_array($status, $this->statuses(), true)) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->paginate(8)->withQueryString();

        $summary = [
            'all' => Order::where('customer_email', $email)->count(),
            'pending' => Order::where('customer_email', $email)->whereIn('status', ['pending', 'awaiting_confirmation'])->count(),
            'processing' => Order::where('customer_email', $email)->whereIn('status', ['processing', 'shipped'])->count(),
            'completed' => Order::where('customer_email', $email)->where('status', 'completed')->count(),
        ];

        return view('pages.orders.index', [
            'orders' => $orders,
            'summary' => $summary,
            'activeStatus' => $status,
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['items', 'paymentConfirmation', 'paymentMethod']);

        if ($order->customer_email !== auth()->user()->email) {
            throw new NotFoundHttpException();
        }

        return view('pages.orders.show', [
            'order' => $order,
            'statusMeta' => $this->statusMeta($order->status),
        ]);
    }

    public function cancel(Order $order, \Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($order->customer_email !== auth()->user()->email) abort(403);
        if (!in_array($order->status, ['pending'])) {
            return back()->with('error', __('messages.orders.cannot_cancel'));
        }

        $request->validate(['cancel_reason' => 'required|string|max:500']);

        $order->update(['status' => 'cancelled', 'cancel_reason' => $request->cancel_reason]);

        return back()->with('success', __('messages.orders.cancel_success'));
    }

    public function changePayment(Order $order): \Illuminate\Http\RedirectResponse
    {
        if ($order->customer_email !== auth()->user()->email) abort(403);
        if ($order->status !== 'pending') {
            return back()->with('error', __('messages.orders.cannot_change_payment'));
        }

        // Reset payment info so customer can re-select
        $order->update([
            'payment_type'      => null,
            'payment_token'     => null,
            'payment_va_number' => null,
            'payment_qr_url'    => null,
            'payment_expired_at'=> null,
        ]);

        return redirect()->route('payment.select', $order);
    }

    private function statuses(): array
    {
        return array_keys($this->statusOptions());
    }

    private function statusOptions(): array
    {
        return [
            'pending' => __('messages.orders.pending'),
            'awaiting_confirmation' => __('messages.orders.awaiting_confirmation'),
            'processing' => __('messages.orders.processing'),
            'shipped' => __('messages.orders.shipped'),
            'completed' => __('messages.orders.completed'),
            'cancelled' => __('messages.orders.cancelled'),
        ];
    }

    private function statusMeta(string $status): array
    {
        return match ($status) {
            'pending' => ['label' => __('messages.orders.pending'), 'color' => '#b45309', 'bg' => '#fef3c7', 'icon' => 'fa-wallet'],
            'awaiting_confirmation' => ['label' => __('messages.orders.awaiting_confirmation'), 'color' => '#1d4ed8', 'bg' => '#dbeafe', 'icon' => 'fa-receipt'],
            'processing' => ['label' => __('messages.orders.processing'), 'color' => '#7c3aed', 'bg' => '#ede9fe', 'icon' => 'fa-box-open'],
            'shipped' => ['label' => __('messages.orders.shipped'), 'color' => '#0f766e', 'bg' => '#ccfbf1', 'icon' => 'fa-truck'],
            'completed' => ['label' => __('messages.orders.completed'), 'color' => '#166534', 'bg' => '#dcfce7', 'icon' => 'fa-check-circle'],
            'cancelled' => ['label' => __('messages.orders.cancelled'), 'color' => '#991b1b', 'bg' => '#fee2e2', 'icon' => 'fa-times-circle'],
            default => ['label' => ucfirst($status), 'color' => '#374151', 'bg' => '#f3f4f6', 'icon' => 'fa-circle'],
        };
    }
}
