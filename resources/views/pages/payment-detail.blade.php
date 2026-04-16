@extends('layouts.app')
@section('title', 'Detail Pembayaran')

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>Detail Pembayaran</h1>
    </div>
</section>

<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container" style="max-width: 640px;">

        {{-- Status --}}
        @php
            $isPaid = in_array($order->status, ['paid','processing','shipped','delivered']);
            $isExpired = $order->payment_expired_at && $order->payment_expired_at->isPast() && !$isPaid;
        @endphp

        <div style="background:white; border-radius:16px; padding:24px; margin-bottom:20px; text-align:center;">
            @if($isPaid)
                <div style="font-size:48px; margin-bottom:8px;">✅</div>
                <h2 style="color:#16a34a; font-size:20px;">Pembayaran Berhasil!</h2>
            @elseif($isExpired)
                <div style="font-size:48px; margin-bottom:8px;">⏰</div>
                <h2 style="color:#dc2626; font-size:20px;">Pembayaran Kadaluarsa</h2>
                <p style="font-size:14px; color:var(--text-medium); margin-top:8px;">
                    <a href="{{ route('payment.select', $order) }}" style="color:var(--primary-color);">Pilih metode pembayaran lain</a>
                </p>
            @else
                <div style="font-size:48px; margin-bottom:8px;">⏳</div>
                <h2 style="font-size:18px; color:var(--text-dark);">Menunggu Pembayaran</h2>
                @if($order->payment_expired_at)
                <p style="font-size:13px; color:var(--text-medium); margin-top:6px;">
                    Bayar sebelum: <strong>{{ $order->payment_expired_at->format('d M Y, H:i') }}</strong>
                </p>
                @endif
            @endif
        </div>

        {{-- Order Info --}}
        <div style="background:white; border-radius:16px; padding:24px; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px;">
                <span style="color:var(--text-medium);">No. Order</span>
                <strong>{{ $order->order_number }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:14px;">
                <span style="color:var(--text-medium);">Total Bayar</span>
                <strong style="font-size:18px; color:var(--primary-dark);">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
            </div>
        </div>

        {{-- Payment Info --}}
        @if(!$isPaid && !$isExpired && $order->payment_type)
        <div style="background:white; border-radius:16px; padding:24px; margin-bottom:20px;">

            @php
                $type = $order->payment_type;
                $labels = [
                    'bank_transfer' => 'Virtual Account',
                    'echannel'      => 'Mandiri Bill',
                    'gopay'         => 'GoPay',
                    'qris'          => 'QRIS',
                    'shopeepay'     => 'ShopeePay',
                    'cstore'        => 'Minimarket',
                ];
            @endphp

            <h3 style="font-size:16px; font-weight:700; margin-bottom:20px;">
                {{ $labels[$type] ?? ucfirst($type) }}
            </h3>

            {{-- VA Number --}}
            @if($order->payment_va_number)
            <div style="text-align:center; padding:20px; background:var(--bg-light); border-radius:12px;">
                <p style="font-size:13px; color:var(--text-medium); margin-bottom:8px;">
                    @if($type === 'cstore') Kode Pembayaran @elseif($type === 'echannel') Kode Bayar @else Nomor Virtual Account @endif
                </p>
                <div style="font-size:28px; font-weight:800; letter-spacing:4px; color:var(--text-dark);" id="va-number">
                    {{ $order->payment_va_number }}
                </div>
                <button onclick="copyVA()" style="margin-top:12px; padding:8px 20px; background:var(--primary-color); color:white; border:none; border-radius:8px; font-size:13px; cursor:pointer;">
                    <i class="fas fa-copy mr-1"></i> Salin
                </button>
            </div>
            @endif

            {{-- QR Code --}}
            @if($order->payment_qr_url)
            <div style="display:flex; flex-direction:column; align-items:center; padding:20px;">
                <p style="font-size:13px; color:var(--text-medium); margin-bottom:12px;">Scan QR Code untuk membayar</p>
                <img src="{{ $order->payment_qr_url }}" alt="QR Code" id="qr-image" style="width:220px; height:220px; border:1px solid var(--border-color); border-radius:12px; padding:8px; display:block;">
                <p style="font-size:12px; color:var(--text-medium); margin-top:8px;">Buka aplikasi GoPay / ShopeePay / QRIS</p>
                <a href="{{ route('payment.qr-download', $order) }}"
                    style="margin-top:12px; padding:10px 20px; background:var(--primary-color); color:white; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-download"></i> Download QR
                </a>
            </div>
            @endif

            {{-- Cara Bayar --}}
            <div style="margin-top:16px; padding:16px; background:#f0fdf4; border-radius:10px; font-size:13px; color:#166534;">
                <strong><i class="fas fa-info-circle mr-1"></i> Cara Bayar:</strong>
                @if($type === 'bank_transfer' || $type === 'echannel')
                    Buka aplikasi/ATM bank Anda → Transfer → Masukkan nomor VA di atas → Konfirmasi jumlah Rp {{ number_format($order->total, 0, ',', '.') }}
                @elseif(in_array($type, ['gopay','shopeepay','qris']))
                    Buka aplikasi e-wallet Anda → Scan QR Code di atas → Konfirmasi pembayaran
                @elseif($type === 'cstore')
                    Pergi ke minimarket terdekat → Tunjukkan kode di atas ke kasir → Bayar sejumlah Rp {{ number_format($order->total, 0, ',', '.') }}
                @endif
            </div>
        </div>
        @endif

        <div style="display:flex; gap:12px;">
            <a href="{{ route('customer.orders.show', $order) }}"
                style="flex:1; text-align:center; padding:14px; border:2px solid var(--primary-color); color:var(--primary-color); border-radius:12px; font-weight:600; font-size:14px;">
                Lihat Detail Order
            </a>
            <a href="{{ route('home') }}"
                style="flex:1; text-align:center; padding:14px; background:var(--gradient-primary); color:white; border-radius:12px; font-weight:600; font-size:14px;">
                Lanjut Belanja
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function copyVA() {
    const va = document.getElementById('va-number').innerText.replace(/\s/g, '');
    navigator.clipboard.writeText(va).then(() => {
        alert('Nomor VA disalin: ' + va);
    });
}

// Auto-refresh status setiap 15 detik
@if(!$isPaid && !$isExpired)
setInterval(() => {
    fetch('{{ route('payment.detail', $order) }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newStatus = doc.querySelector('[data-status]')?.dataset.status;
            if (newStatus === 'paid') location.reload();
        });
}, 15000);
@endif
</script>
@endpush
