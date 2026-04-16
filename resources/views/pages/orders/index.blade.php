@extends('layouts.app')

@section('title', __('messages.orders.page_title') . ' - GreenHaven')

@php
    $statusStyles = [
        'pending' => ['label' => 'Belum Dibayar', 'color' => '#b45309', 'bg' => '#fef3c7'],
        'awaiting_confirmation' => ['label' => 'Menunggu Verifikasi', 'color' => '#1d4ed8', 'bg' => '#dbeafe'],
        'processing' => ['label' => 'Dikemas', 'color' => '#7c3aed', 'bg' => '#ede9fe'],
        'shipped' => ['label' => 'Dikirim', 'color' => '#0f766e', 'bg' => '#ccfbf1'],
        'completed' => ['label' => 'Selesai', 'color' => '#166534', 'bg' => '#dcfce7'],
        'cancelled' => ['label' => 'Dibatalkan', 'color' => '#991b1b', 'bg' => '#fee2e2'],
    ];
@endphp

@section('content')
<section class="page-banner" style="padding: 60px 0;">
    <div class="container" style="text-align: center;">
        <h1>{{ __('messages.orders.page_title') }}</h1>
        <p style="max-width: 680px; margin: 12px auto 0; color: var(--text-medium);">{{ __('messages.orders.page_desc') }}</p>
    </div>
</section>

<section style="padding: 32px 0 80px; background: linear-gradient(180deg, #f8fafc 0%, #eefbf3 100%);">
    <div class="container">
        <div class="orders-summary-grid" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin-bottom: 28px;">
            <div style="background: white; border-radius: 24px; padding: 22px; box-shadow: 0 16px 32px rgba(15, 23, 42, 0.06);">
                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">{{ __('messages.orders.all_orders') }}</div>
                <div style="font-size: 28px; font-weight: 800; color: #0f172a;">{{ $summary['all'] }}</div>
            </div>
            <div style="background: white; border-radius: 24px; padding: 22px; box-shadow: 0 16px 32px rgba(15, 23, 42, 0.06);">
                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">{{ __('messages.orders.need_payment') }}</div>
                <div style="font-size: 28px; font-weight: 800; color: #b45309;">{{ $summary['pending'] }}</div>
            </div>
            <div style="background: white; border-radius: 24px; padding: 22px; box-shadow: 0 16px 32px rgba(15, 23, 42, 0.06);">
                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">{{ __('messages.orders.in_progress') }}</div>
                <div style="font-size: 28px; font-weight: 800; color: #7c3aed;">{{ $summary['processing'] }}</div>
            </div>
            <div style="background: white; border-radius: 24px; padding: 22px; box-shadow: 0 16px 32px rgba(15, 23, 42, 0.06);">
                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">{{ __('messages.orders.done') }}</div>
                <div style="font-size: 28px; font-weight: 800; color: #166534;">{{ $summary['completed'] }}</div>
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 28px;">
            <a href="{{ route('customer.orders.index') }}" style="padding: 10px 18px; border-radius: 999px; text-decoration: none; font-weight: 600; {{ empty($activeStatus) ? 'background: #14532d; color: white;' : 'background: white; color: #14532d; border: 1px solid #bbf7d0;' }}">{{ __('messages.orders.all') }}</a>
            @foreach($statusOptions as $value => $label)
                <a href="{{ route('customer.orders.index', ['status' => $value]) }}" style="padding: 10px 18px; border-radius: 999px; text-decoration: none; font-weight: 600; {{ $activeStatus === $value ? 'background: #14532d; color: white;' : 'background: white; color: #14532d; border: 1px solid #bbf7d0;' }}">{{ $label }}</a>
            @endforeach
        </div>

        @forelse($orders as $order)
            @php
                $status = $statusStyles[$order->status] ?? ['label' => ucfirst($order->status), 'color' => '#374151', 'bg' => '#f3f4f6'];
                $canConfirm = in_array($order->status, ['pending', 'awaiting_confirmation'], true);
            @endphp
            <article style="background: white; border-radius: 28px; padding: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06); margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; gap: 18px; align-items: flex-start; margin-bottom: 22px; flex-wrap: wrap;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 8px;">
                            <strong style="font-size: 20px; color: #0f172a;">{{ $order->order_number }}</strong>
                            <span style="padding: 8px 12px; border-radius: 999px; background: {{ $status['bg'] }}; color: {{ $status['color'] }}; font-size: 13px; font-weight: 700;">{{ $status['label'] }}</span>
                        </div>
                        <div style="font-size: 14px; color: #64748b;">{{ __('messages.orders.created_at') }} {{ $order->created_at->format('d M Y, H:i') }} • {{ __('messages.orders.item_count', ['count' => $order->items->sum('quantity')]) }} • {{ $order->paymentMethod?->name ?? $order->payment_method }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 13px; color: #64748b;">{{ __('messages.orders.total_spent') }}</div>
                        <div style="font-size: 24px; font-weight: 800; color: #14532d;">Rp{{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div style="display: grid; gap: 14px; margin-bottom: 22px;">
                    @foreach($order->items->take(3) as $item)
                        <div style="display: flex; justify-content: space-between; gap: 16px; align-items: center; padding: 16px 18px; border: 1px solid #e2e8f0; border-radius: 18px; background: #fcfffd;">
                            <div>
                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $item->product_name }}</div>
                                <div style="font-size: 14px; color: #64748b;">{{ $item->quantity }} x Rp{{ number_format($item->product_price, 0, ',', '.') }}</div>
                            </div>
                            <div style="font-weight: 700; color: #0f172a;">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                    @if($order->items->count() > 3)
                        <div style="font-size: 14px; color: #64748b;">+{{ $order->items->count() - 3 }} item lain</div>
                    @endif
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
                    <div style="font-size: 14px; color: #475569;">
                        @if($order->paymentConfirmation)
                            {{ __('messages.orders.payment_confirmation') }}: <strong>{{ ucfirst($order->paymentConfirmation->status) }}</strong>
                        @else
                            {{ __('messages.orders.no_payment_confirmation') }}
                        @endif
                    </div>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ route('customer.orders.show', $order) }}" style="padding: 12px 18px; border-radius: 12px; text-decoration: none; font-weight: 700; color: #14532d; border: 1px solid #86efac; background: #f0fdf4;">{{ __('messages.orders.order_detail') }}</a>
                        @if($order->status === 'pending' && $order->payment_type)
                            <a href="{{ route('payment.detail', $order) }}" style="padding: 12px 18px; border-radius: 12px; text-decoration: none; font-weight: 700; color: white; background: #16a34a;">
                                <i class="fas fa-wallet mr-1"></i> {{ __('messages.orders.pay_now') }}
                            </a>
                            <form action="{{ route('customer.orders.change-payment', $order) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" style="padding: 12px 18px; border-radius: 12px; font-weight: 700; color: #1d4ed8; border: 1px solid #93c5fd; background: #eff6ff; cursor:pointer;">
                                    <i class="fas fa-exchange-alt mr-1"></i> {{ __('messages.orders.change_payment') }}
                                </button>
                            </form>
                        @elseif($order->status === 'pending' && $order->paymentMethod?->isMidtrans() && !$order->payment_type)
                            <a href="{{ route('payment.select', $order) }}" style="padding: 12px 18px; border-radius: 12px; text-decoration: none; font-weight: 700; color: white; background: #16a34a;">
                                <i class="fas fa-wallet mr-1"></i> {{ __('messages.orders.change_payment') }}
                            </a>
                        @elseif($canConfirm)
                            <a href="{{ route('payment-confirmation.create', $order) }}" style="padding: 12px 18px; border-radius: 12px; text-decoration: none; font-weight: 700; color: #9a3412; border: 1px solid #fdba74; background: #fff7ed;">{{ __('messages.orders.upload_payment_proof') }}</a>
                        @endif
                        @if($order->status === 'pending')
                            <button onclick="showCancelModal({{ $order->id }})" style="padding: 12px 18px; border-radius: 12px; font-weight: 700; color: #991b1b; border: 1px solid #fca5a5; background: #fff1f2; cursor:pointer;">
                                <i class="fas fa-times mr-1"></i> {{ __('messages.orders.cancel_order') }}
                            </button>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div style="background: white; border-radius: 28px; padding: 48px 32px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06); text-align: center;">
                <div style="width: 72px; height: 72px; border-radius: 50%; background: #f0fdf4; color: #166534; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 16px;">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 style="font-size: 24px; margin-bottom: 10px;">{{ __('messages.orders.empty_title') }}</h3>
                <p style="color: #64748b; max-width: 480px; margin: 0 auto 24px;">{{ __('messages.orders.empty_desc') }}</p>
                <a href="{{ route('shop') }}" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 24px; border-radius: 14px; background: var(--gradient-primary); color: white; text-decoration: none; font-weight: 700;">
                    <i class="fas fa-leaf"></i> {{ __('messages.orders.start_shopping') }}
                </a>
            </div>
        @endforelse

        @if($orders->hasPages())
            <div style="margin-top: 28px;">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</section>

<style>
@media (max-width: 991px) {
    .orders-summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
}

@media (max-width: 640px) {
    .orders-summary-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

{{-- Cancel Modal --}}
@push('scripts')
<div id="cancel-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:480px; width:90%; margin:auto;">
        <h3 style="font-size:18px; font-weight:700; margin-bottom:8px;">{{ __('messages.orders.cancel_order') }}</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">{{ __('messages.orders.cancel_confirm') }}</p>
        <form id="cancel-form" method="POST">
            @csrf
            <textarea name="cancel_reason" required placeholder="{{ __('messages.orders.cancel_reason_placeholder') }}"
                style="width:100%; padding:12px 16px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; resize:vertical; min-height:100px; margin-bottom:16px;"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="hideCancelModal()"
                    style="flex:1; padding:14px; border:1px solid #e2e8f0; border-radius:12px; font-weight:600; cursor:pointer; background:white;">
                    {{ __('button.cancel') }}
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
function showCancelModal(orderId) {
    document.getElementById('cancel-form').action = '/account/orders/' + orderId + '/cancel';
    const modal = document.getElementById('cancel-modal');
    modal.style.display = 'flex';
}
function hideCancelModal() {
    document.getElementById('cancel-modal').style.display = 'none';
}
</script>
@endpush
