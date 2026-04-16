@extends('layouts.app')
@section('title', 'Pilih Metode Pembayaran')

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>Pilih Metode Pembayaran</h1>
    </div>
</section>

<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container" style="max-width: 640px;">

        <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 20px;">
            <div style="display:flex; justify-content:space-between; font-size:14px; color:var(--text-medium);">
                <span>Order <strong>{{ $order->order_number }}</strong></span>
                <span style="font-size:18px; font-weight:700; color:var(--primary-dark);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if(session('error'))
            <div style="background:#fee2e2; color:#dc2626; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:14px;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('payment.process', $order) }}" method="POST" id="payment-form">
            @csrf

            {{-- Transfer Bank --}}
            <div style="background:white; border-radius:16px; padding:24px; margin-bottom:16px;">
                <h3 style="font-size:15px; font-weight:700; margin-bottom:16px; color:var(--text-dark);">
                    <i class="fas fa-university" style="color:var(--primary-color); margin-right:8px;"></i> Transfer Bank (Virtual Account)
                </h3>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach([
                        ['bca', 'BCA Virtual Account', '#005BAC'],
                        ['bni', 'BNI Virtual Account', '#F68B1F'],
                        ['bri', 'BRI Virtual Account', '#00529B'],
                        ['mandiri', 'Mandiri Bill Payment', '#003D7C'],
                        ['permata', 'Permata Virtual Account', '#E31E24'],
                    ] as [$val, $label, $color])
                    <label class="pay-option" style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid var(--border-color); border-radius:12px; cursor:pointer;">
                        <input type="radio" name="payment_method" value="{{ $val }}" style="accent-color:var(--primary-color);">
                        <div style="width:8px; height:32px; background:{{ $color }}; border-radius:4px;"></div>
                        <span style="font-weight:600; font-size:14px;">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- E-Wallet --}}
            <div style="background:white; border-radius:16px; padding:24px; margin-bottom:16px;">
                <h3 style="font-size:15px; font-weight:700; margin-bottom:16px; color:var(--text-dark);">
                    <i class="fas fa-wallet" style="color:var(--primary-color); margin-right:8px;"></i> E-Wallet & QRIS
                </h3>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach([
                        ['gopay', 'GoPay', '#00AED6'],
                        ['qris', 'QRIS (Semua E-Wallet)', '#E31E24'],
                        ['shopeepay', 'ShopeePay', '#EE4D2D'],
                    ] as [$val, $label, $color])
                    <label class="pay-option" style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid var(--border-color); border-radius:12px; cursor:pointer;">
                        <input type="radio" name="payment_method" value="{{ $val }}" style="accent-color:var(--primary-color);">
                        <div style="width:8px; height:32px; background:{{ $color }}; border-radius:4px;"></div>
                        <span style="font-weight:600; font-size:14px;">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Minimarket --}}
            <div style="background:white; border-radius:16px; padding:24px; margin-bottom:24px;">
                <h3 style="font-size:15px; font-weight:700; margin-bottom:16px; color:var(--text-dark);">
                    <i class="fas fa-store" style="color:var(--primary-color); margin-right:8px;"></i> Minimarket
                </h3>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach([
                        ['alfamart', 'Alfamart', '#E31E24'],
                        ['indomaret', 'Indomaret', '#0066CC'],
                    ] as [$val, $label, $color])
                    <label class="pay-option" style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid var(--border-color); border-radius:12px; cursor:pointer;">
                        <input type="radio" name="payment_method" value="{{ $val }}" style="accent-color:var(--primary-color);">
                        <div style="width:8px; height:32px; background:{{ $color }}; border-radius:4px;"></div>
                        <span style="font-weight:600; font-size:14px;">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" id="pay-btn" disabled
                style="width:100%; padding:16px; background:var(--gradient-primary); color:white; border:none; border-radius:12px; font-size:16px; font-weight:700; cursor:not-allowed; opacity:0.5; transition:all .2s;">
                Bayar Sekarang
            </button>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.pay-option input').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.pay-option').forEach(l => l.style.borderColor = 'var(--border-color)');
        this.closest('.pay-option').style.borderColor = 'var(--primary-color)';
        const btn = document.getElementById('pay-btn');
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
    });
});
</script>
@endpush
