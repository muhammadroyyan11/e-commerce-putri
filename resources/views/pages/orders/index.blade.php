@extends('layouts.app')
@section('title', __('messages.orders.page_title') . ' - LongLeaf')

@php
$statusStyles = [
    'pending'              => ['label' => 'Pending Payment',      'color' => '#b45309', 'bg' => '#fef3c7'],
    'awaiting_confirmation'=> ['label' => 'Awaiting Confirmation','color' => '#1d4ed8', 'bg' => '#dbeafe'],
    'processing'           => ['label' => 'Processing',           'color' => '#7c3aed', 'bg' => '#ede9fe'],
    'shipped'              => ['label' => 'Shipped',              'color' => '#0f766e', 'bg' => '#ccfbf1'],
    'completed'            => ['label' => 'Completed',            'color' => '#166534', 'bg' => '#dcfce7'],
    'cancelled'            => ['label' => 'Cancelled',            'color' => '#991b1b', 'bg' => '#fee2e2'],
];
@endphp

@section('content')
<section style="padding: 32px 0 60px; background: var(--bg-light);">
    <div class="container">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
            <h2 style="font-size:22px; font-weight:800; color:#0f172a; margin:0;">{{ __('messages.orders.page_title') }}</h2>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a href="{{ route('customer.orders.index') }}"
                    style="padding:7px 16px; border-radius:999px; font-size:13px; font-weight:600; text-decoration:none; {{ empty($activeStatus) ? 'background:#14532d; color:white;' : 'background:white; color:#14532d; border:1px solid #bbf7d0;' }}">
                    {{ __('messages.orders_extra.all') }} ({{ $summary['all'] }})
                </a>
                @foreach($statusOptions as $value => $label)
                <a href="{{ route('customer.orders.index', ['status' => $value]) }}"
                    style="padding:7px 16px; border-radius:999px; font-size:13px; font-weight:600; text-decoration:none; {{ $activeStatus === $value ? 'background:#14532d; color:white;' : 'background:white; color:#14532d; border:1px solid #bbf7d0;' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Orders --}}
        @forelse($orders as $order)
        @php
            $status = $statusStyles[$order->status] ?? ['label' => ucfirst($order->status), 'color' => '#374151', 'bg' => '#f3f4f6'];
            $canConfirm = in_array($order->status, ['pending', 'awaiting_confirmation'], true);
        @endphp
        <div style="background:white; border-radius:14px; padding:16px 20px; margin-bottom:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
            {{-- Top row --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <span style="font-size:13px; font-weight:700; color:#0f172a;">{{ $order->order_number }}</span>
                    <span style="font-size:11px; color:#64748b;">{{ $order->created_at->format('d M Y') }}</span>
                    <span style="padding:3px 10px; border-radius:999px; font-size:11px; font-weight:700; background:{{ $status['bg'] }}; color:{{ $status['color'] }};">
                        {{ $status['label'] }}
                    </span>
                </div>
                <span style="font-size:15px; font-weight:800; color:#14532d;">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>

            {{-- Items compact --}}
            <div style="font-size:13px; color:#475569; margin-bottom:12px; padding:10px 14px; background:#f8fafc; border-radius:10px;">
                @foreach($order->items->take(2) as $item)
                    <span>{{ $item->product_name }} ×{{ $item->quantity }}</span>@if(!$loop->last)<span style="margin:0 6px; color:#cbd5e1;">·</span>@endif
                @endforeach
                @if($order->items->count() > 2)
                    <span style="color:#94a3b8;"> {{ __('messages.orders_extra.more_items', ['count' => $order->items->count() - 2]) }}</span>
                @endif
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <a href="{{ route('customer.orders.show', $order) }}"
                    style="padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; color:#14532d; border:1px solid #86efac; background:#f0fdf4;">
                    {{ __('messages.orders_extra.detail') }}
                </a>
                @if($order->status === 'pending' && $order->payment_type)
                    <a href="{{ route('payment.detail', $order) }}"
                        style="padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; color:white; background:#16a34a;">
                        <i class="fas fa-wallet"></i> {{ __('messages.orders.pay_now') }}
                    </a>
                    <form action="{{ route('customer.orders.change-payment', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600; color:#1d4ed8; border:1px solid #93c5fd; background:#eff6ff; cursor:pointer;">
                            <i class="fas fa-exchange-alt"></i> {{ __('messages.orders_extra.change') }}
                        </button>
                    </form>
                @elseif($order->status === 'pending' && $order->paymentMethod?->isMidtrans() && !$order->payment_type)
                    <a href="{{ route('payment.select', $order) }}"
                        style="padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; color:white; background:#16a34a;">
                        <i class="fas fa-wallet"></i> {{ __('messages.orders.pay_now') }}
                    </a>
                @elseif($canConfirm && !$order->paymentMethod?->isMidtrans())
                    <a href="{{ route('payment-confirmation.create', $order) }}"
                        style="padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; color:#9a3412; border:1px solid #fdba74; background:#fff7ed;">
                        {{ __('messages.orders_extra.upload_proof') }}
                    </a>
                @endif
                @if($order->status === 'pending')
                    <button onclick="showCancelModal({{ $order->id }})"
                        style="padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600; color:#991b1b; border:1px solid #fca5a5; background:#fff1f2; cursor:pointer;">
                        <i class="fas fa-times"></i> {{ __('messages.orders_extra.cancel') }}
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div style="background:white; border-radius:14px; padding:48px; text-align:center;">
            <div style="font-size:48px; margin-bottom:12px;">📦</div>
            <h3 style="font-size:18px; margin-bottom:8px;">{{ __('messages.orders.empty_title') }}</h3>
            <p style="color:#64748b; margin-bottom:20px;">{{ __('messages.orders.empty_desc') }}</p>
            <a href="{{ route('shop') }}" style="padding:12px 24px; background:var(--gradient-primary); color:white; border-radius:10px; font-weight:600; text-decoration:none;">
                {{ __('messages.orders.start_shopping') }}
            </a>
        </div>
        @endforelse

        @if($orders->hasPages())
        <div style="margin-top:20px;">{{ $orders->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<div id="cancel-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:28px; max-width:440px; width:90%;">
        <h3 style="font-size:16px; font-weight:700; margin-bottom:6px;">{{ __('messages.orders.cancel_order') }}</h3>
        <p style="font-size:13px; color:#64748b; margin-bottom:16px;">{{ __('messages.orders.cancel_confirm') }}</p>
        <form id="cancel-form" method="POST">
            @csrf
            <textarea name="cancel_reason" required placeholder="{{ __('messages.orders.cancel_reason_placeholder') }}"
                style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:13px; resize:vertical; min-height:80px; margin-bottom:14px;"></textarea>
            <div style="display:flex; gap:10px;">
                <button type="button" onclick="hideCancelModal()"
                    style="flex:1; padding:12px; border:1px solid #e2e8f0; border-radius:10px; font-weight:600; cursor:pointer; background:white; font-size:13px;">
                    {{ __('messages.button.cancel') }}
                </button>
                <button type="submit"
                    style="flex:1; padding:12px; background:#dc2626; color:white; border:none; border-radius:10px; font-weight:700; cursor:pointer; font-size:13px;">
                    {{ __('messages.orders.cancel_order') }}
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function showCancelModal(id) {
    document.getElementById('cancel-form').action = '/account/orders/' + id + '/cancel';
    document.getElementById('cancel-modal').style.display = 'flex';
}
function hideCancelModal() {
    document.getElementById('cancel-modal').style.display = 'none';
}
</script>
@endpush
