@extends('layouts.app')

@section('title', __('messages.orders.order_detail') . ' - GreenHaven')

@section('content')
<section class="page-banner" style="padding: 60px 0;">
    <div class="container" style="text-align: center;">
        <h1>{{ __('messages.orders.order_detail') }}</h1>
        <p style="margin-top: 12px; color: var(--text-medium);">{{ $order->order_number }} • {{ __('messages.orders.created_at') }} {{ $order->created_at->format('d F Y, H:i') }}</p>
    </div>
</section>

<section style="padding: 32px 0 80px; background: linear-gradient(180deg, #f8fafc 0%, #eefbf3 100%);">
    <div class="container" style="max-width: 1120px;">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
            <a href="{{ route('customer.orders.index') }}" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: #14532d; font-weight: 700;">
                <i class="fas fa-arrow-left"></i> {{ __('messages.orders.back_to_history') }}
            </a>
            <span style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 999px; background: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }}; font-weight: 800;">
                <i class="fas {{ $statusMeta['icon'] }}"></i> {{ $statusMeta['label'] }}
            </span>
        </div>

        <div class="order-detail-grid" style="display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.85fr); gap: 24px;">
            <div style="display: grid; gap: 20px;">
                <div style="background: white; border-radius: 28px; padding: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);">
                    <h3 style="margin-bottom: 18px;">{{ __('messages.orders.products_bought') }}</h3>
                    <div style="display: grid; gap: 14px;">
                        @foreach($order->items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 16px 18px; border: 1px solid #e2e8f0; border-radius: 18px;">
                                <div>
                                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $item->product_name }}</div>
                                    <div style="font-size: 14px; color: #64748b;">{{ $item->quantity }} x Rp{{ number_format($item->product_price, 0, ',', '.') }}</div>
                                </div>
                                <div style="font-weight: 800; color: #0f172a;">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="background: white; border-radius: 28px; padding: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);">
                    <h3 style="margin-bottom: 18px;">{{ __('messages.orders.shipping_address') }}</h3>
                    <div style="color: #334155; line-height: 1.8;">
                        <div style="font-weight: 700; color: #0f172a;">{{ $order->customer_name }}</div>
                        <div>{{ $order->customer_phone }}</div>
                        <div>{{ $order->customer_email }}</div>
                        <div>{{ $order->address }}, {{ $order->city }}, {{ $order->province }}, {{ $order->postal_code }}</div>
                    </div>
                </div>
            </div>

            <aside style="display: grid; gap: 20px; align-self: start;">
                <div style="background: white; border-radius: 28px; padding: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);">
                    <h3 style="margin-bottom: 18px;">{{ __('messages.orders.payment_summary') }}</h3>
                    <div style="display: grid; gap: 12px; color: #475569;">
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.payment_method') }}</span><strong style="text-align: right; color: #0f172a;">{{ $order->paymentMethod?->display_name ?? $order->payment_method }}</strong></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.subtotal') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</strong></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.discount') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->discount, 0, ',', '.') }}</strong></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.shipping') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->shipping, 0, ',', '.') }}</strong></div>
                        <div style="height: 1px; background: #e2e8f0; margin: 6px 0;"></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px; font-size: 18px;"><span style="font-weight: 700; color: #0f172a;">{{ __('messages.orders.total') }}</span><strong style="color: #14532d;">Rp{{ number_format($order->total, 0, ',', '.') }}</strong></div>
                    </div>
                </div>

                <div style="background: white; border-radius: 28px; padding: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);">
                    <h3 style="margin-bottom: 18px;">{{ __('messages.orders.payment_status') }}</h3>
                    @if($order->paymentConfirmation)
                        <div style="display: grid; gap: 10px; color: #475569;">
                            <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.amount') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->paymentConfirmation->amount, 0, ',', '.') }}</strong></div>
                            <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.sender') }}</span><strong style="color: #0f172a;">{{ $order->paymentConfirmation->sender_name }}</strong></div>
                            <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.payment_date') }}</span><strong style="color: #0f172a;">{{ $order->paymentConfirmation->payment_date->format('d M Y') }}</strong></div>
                            <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.status') }}</span><strong style="color: #0f172a;">{{ ucfirst($order->paymentConfirmation->status) }}</strong></div>
                            @if($order->paymentConfirmation->notes)
                                <div style="padding: 14px 16px; border-radius: 16px; background: #f8fafc; color: #334155;">{{ $order->paymentConfirmation->notes }}</div>
                            @endif
                        </div>
                    @else
                        <p style="color: #64748b; line-height: 1.7; margin-bottom: 18px;">{{ __('messages.orders.no_confirmation_desc') }}</p>
                        @if(in_array($order->status, ['pending', 'awaiting_confirmation'], true))
                            <a href="{{ route('payment-confirmation.create', $order) }}" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 18px; border-radius: 14px; background: #fff7ed; color: #9a3412; text-decoration: none; font-weight: 700; border: 1px solid #fdba74;">
                                <i class="fas fa-receipt"></i> {{ __('messages.order.confirm_payment') }}
                            </a>
                        @endif
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
@media (max-width: 991px) {
    .order-detail-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
