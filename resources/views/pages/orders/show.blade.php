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
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                @if($order->status === 'pending' && $order->payment_type)
                    <form action="{{ route('customer.orders.change-payment', $order) }}" method="POST">
                        @csrf
                        <button type="submit" style="padding:10px 16px; border-radius:10px; font-weight:600; color:#1d4ed8; border:1px solid #93c5fd; background:#eff6ff; cursor:pointer; font-size:13px;">
                            <i class="fas fa-exchange-alt mr-1"></i> {{ __('messages.orders.change_payment') }}
                        </button>
                    </form>
                @endif
                @if($order->status === 'pending')
                    <button onclick="showCancelModal()" style="padding:10px 16px; border-radius:10px; font-weight:600; color:#991b1b; border:1px solid #fca5a5; background:#fff1f2; cursor:pointer; font-size:13px;">
                        <i class="fas fa-times mr-1"></i> {{ __('messages.orders.cancel_order') }}
                    </button>
                @endif
                <span style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 999px; background: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }}; font-weight: 800;">
                    <i class="fas {{ $statusMeta['icon'] }}"></i> {{ $statusMeta['label'] }}
                </span>
            </div>
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
                        @php
                            $paymentLabel = match($order->payment_type) {
                                'bank_transfer' => collect($order->payment_va_number ? [
                                    '008' => 'Mandiri', '009' => 'BNI', '014' => 'BCA',
                                ] : [])->first() ?? 'Virtual Account',
                                'echannel'  => 'Mandiri Bill',
                                'gopay'     => 'GoPay',
                                'qris'      => 'QRIS',
                                'shopeepay' => 'ShopeePay',
                                'cstore'    => 'Minimarket',
                                default     => $order->paymentMethod?->name ?? $order->payment_method,
                            };
                            // Detect bank from VA prefix
                            if ($order->payment_type === 'bank_transfer' && $order->payment_va_number) {
                                $va = $order->payment_va_number;
                                if (str_starts_with($va, '70012')) $paymentLabel = 'BCA Virtual Account';
                                elseif (str_starts_with($va, '8808')) $paymentLabel = 'BNI Virtual Account';
                                elseif (str_starts_with($va, '2621') || str_starts_with($va, '0328')) $paymentLabel = 'BRI Virtual Account';
                                elseif (str_starts_with($va, '7088') || str_starts_with($va, '7089')) $paymentLabel = 'Permata Virtual Account';
                                else $paymentLabel = 'Virtual Account';
                            }
                        @endphp
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.payment_method') }}</span><strong style="text-align: right; color: #0f172a;">{{ $paymentLabel }}</strong></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.subtotal') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</strong></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.discount') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->discount, 0, ',', '.') }}</strong></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px;"><span>{{ __('messages.orders.shipping') }}</span><strong style="color: #0f172a;">Rp{{ number_format($order->shipping, 0, ',', '.') }}</strong></div>
                        <div style="height: 1px; background: #e2e8f0; margin: 6px 0;"></div>
                        <div style="display: flex; justify-content: space-between; gap: 12px; font-size: 18px;"><span style="font-weight: 700; color: #0f172a;">{{ __('messages.orders.total') }}</span><strong style="color: #14532d;">Rp{{ number_format($order->total, 0, ',', '.') }}</strong></div>
                    </div>
                </div>

                <div style="background: white; border-radius: 28px; padding: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);">
                    <h3 style="margin-bottom: 18px;">{{ __('messages.orders.payment_status') }}</h3>

                    {{-- Midtrans payment info --}}
                    @if($order->payment_type && $order->status === 'pending')
                        @if($order->payment_va_number)
                        <div style="text-align:center; padding:16px; background:#f0fdf4; border-radius:12px; margin-bottom:16px;">
                            <p style="font-size:12px; color:#64748b; margin-bottom:6px;">
                                {{ in_array($order->payment_type, ['cstore']) ? 'Kode Bayar' : 'Nomor Virtual Account' }}
                            </p>
                            <div style="font-size:22px; font-weight:800; letter-spacing:3px;">{{ $order->payment_va_number }}</div>
                        </div>
                        @endif
                        @if($order->payment_qr_url)
                        <div style="text-align:center; margin-bottom:16px;">
                            <img src="{{ $order->payment_qr_url }}" style="width:180px; height:180px; border-radius:10px; border:1px solid #e2e8f0;">
                        </div>
                        @endif
                        @if($order->payment_expired_at)
                        <p style="font-size:13px; color:#b45309; text-align:center; margin-bottom:16px;">
                            <i class="fas fa-clock mr-1"></i> Bayar sebelum {{ $order->payment_expired_at->format('d M Y, H:i') }}
                        </p>
                        @endif
                        <a href="{{ route('payment.detail', $order) }}" style="display:block; text-align:center; padding:14px; background:#16a34a; color:white; border-radius:12px; font-weight:700; text-decoration:none;">
                            <i class="fas fa-wallet mr-1"></i> Lihat Detail Pembayaran
                        </a>
                    @elseif($order->status === 'pending' && $order->paymentMethod?->isMidtrans() && !$order->payment_type)
                        <a href="{{ route('payment.select', $order) }}" style="display:block; text-align:center; padding:14px; background:#16a34a; color:white; border-radius:12px; font-weight:700; text-decoration:none;">
                            <i class="fas fa-wallet mr-1"></i> Pilih Metode Pembayaran
                        </a>
                    @elseif($order->paymentConfirmation)
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

@if($order->cancel_reason)
<section style="padding: 0 0 40px; background: linear-gradient(180deg, #f8fafc 0%, #eefbf3 100%);">
    <div class="container" style="max-width: 1120px;">
        <div style="background:#fff1f2; border:1px solid #fca5a5; border-radius:16px; padding:20px 24px;">
            <strong style="color:#991b1b;"><i class="fas fa-times-circle mr-2"></i>{{ __('messages.orders.cancel_reason_label') }}:</strong>
            <p style="margin-top:6px; color:#7f1d1d;">{{ $order->cancel_reason }}</p>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<div id="cancel-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:480px; width:90%; margin:auto;">
        <h3 style="font-size:18px; font-weight:700; margin-bottom:8px;">{{ __('messages.orders.cancel_order') }}</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">{{ __('messages.orders.cancel_confirm') }}</p>
        <form action="{{ route('customer.orders.cancel', $order) }}" method="POST">
            @csrf
            <textarea name="cancel_reason" required placeholder="{{ __('messages.orders.cancel_reason_placeholder') }}"
                style="width:100%; padding:12px 16px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; resize:vertical; min-height:100px; margin-bottom:16px;"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="hideCancelModal()"
                    style="flex:1; padding:14px; border:1px solid #e2e8f0; border-radius:12px; font-weight:600; cursor:pointer; background:white;">
                    {{ __('messages.button.cancel') }}
                </button>
                <button type="submit"
                    style="flex:1; padding:14px; background:#dc2626; color:white; border:none; border-radius:12px; font-weight:700; cursor:pointer;">
                    {{ __('messages.orders.cancel_order') }}
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function showCancelModal() {
    document.getElementById('cancel-modal').style.display = 'flex';
}
function hideCancelModal() {
    document.getElementById('cancel-modal').style.display = 'none';
}
</script>
@endpush
