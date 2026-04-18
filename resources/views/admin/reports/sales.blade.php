@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan Settlement')
@section('page-title', 'Laporan Penjualan Settlement')

@section('content')

{{-- ── Filter Bar ──────────────────────────────────────────────────────── --}}
<div class="card card-outline card-primary mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="d-flex flex-wrap align-items-end gap-2" style="gap:12px;">

            {{-- Period shortcuts --}}
            <div class="form-group mb-0">
                <label class="d-block" style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;margin-bottom:4px;">Periode</label>
                <select name="period" class="form-control form-control-sm" onchange="toggleCustom(this.value)" style="min-width:160px;">
                    @foreach([
                        'today'      => 'Hari Ini',
                        'yesterday'  => 'Kemarin',
                        'this_week'  => 'Minggu Ini',
                        'last_week'  => 'Minggu Lalu',
                        'this_month' => 'Bulan Ini',
                        'last_month' => 'Bulan Lalu',
                        'this_year'  => 'Tahun Ini',
                        'custom'     => 'Custom Range',
                    ] as $val => $label)
                    <option value="{{ $val }}" {{ $period === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Custom date range --}}
            <div id="custom-range" class="d-flex align-items-end" style="gap:8px; display:{{ $period === 'custom' ? 'flex' : 'none' }} !important;">
                <div class="form-group mb-0">
                    <label style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;margin-bottom:4px;display:block;">Dari</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom ?? $from->format('Y-m-d') }}">
                </div>
                <div class="form-group mb-0">
                    <label style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;margin-bottom:4px;display:block;">Sampai</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo ?? $to->format('Y-m-d') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter mr-1"></i> Tampilkan
            </button>
            <a href="{{ route('admin.reports.sales', array_merge(request()->all(), ['export' => 'csv'])) }}"
               class="btn btn-success btn-sm">
                <i class="fas fa-file-csv mr-1"></i> Export CSV
            </a>
        </form>

        <div class="mt-2" style="font-size:13px;color:#6b7280;">
            <i class="fas fa-calendar-alt mr-1"></i>
            Menampilkan data: <strong>{{ $from->format('d M Y') }}</strong> — <strong>{{ $to->format('d M Y') }}</strong>
            &nbsp;·&nbsp; Hanya pesanan berstatus <span class="badge badge-success">Completed</span>
        </div>
    </div>
</div>

{{-- ── Summary Cards ───────────────────────────────────────────────────── --}}
<div class="row mb-3">
    @php
    $cards = [
        ['icon'=>'fas fa-money-bill-wave','color'=>'success','label'=>'Total Pendapatan',   'value'=>'Rp '.number_format($summary['total_revenue'],0,',','.')],
        ['icon'=>'fas fa-shopping-bag',   'color'=>'primary','label'=>'Total Pesanan',      'value'=>number_format($summary['total_orders']).' pesanan'],
        ['icon'=>'fas fa-boxes',          'color'=>'info',   'label'=>'Total Item Terjual', 'value'=>number_format($summary['total_items']).' item'],
        ['icon'=>'fas fa-receipt',        'color'=>'warning','label'=>'Rata-rata Pesanan',  'value'=>'Rp '.number_format($summary['avg_order'],0,',','.')],
        ['icon'=>'fas fa-truck',          'color'=>'secondary','label'=>'Total Ongkir',     'value'=>'Rp '.number_format($summary['total_shipping'],0,',','.')],
        ['icon'=>'fas fa-tag',            'color'=>'danger', 'label'=>'Total Diskon',       'value'=>'Rp '.number_format($summary['total_discount'],0,',','.')],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="small-box bg-{{ $card['color'] }}" style="border-radius:12px;margin-bottom:0;">
            <div class="inner">
                <h4 style="font-size:16px;font-weight:800;">{{ $card['value'] }}</h4>
                <p style="font-size:12px;">{{ $card['label'] }}</p>
            </div>
            <div class="icon"><i class="{{ $card['icon'] }}"></i></div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mb-3">
    {{-- ── Revenue Chart ──────────────────────────────────────────────── --}}
    <div class="col-lg-8 mb-3">
        <div class="card card-outline card-success h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-area mr-2"></i>Tren Pendapatan Harian</h3>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- ── Top Products ────────────────────────────────────────────────── --}}
    <div class="col-lg-4 mb-3">
        <div class="card card-outline card-info h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-trophy mr-2"></i>Top 5 Produk</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $i => $p)
                        <tr>
                            <td><span class="badge badge-{{ ['success','primary','info','warning','secondary'][$i] ?? 'secondary' }}">{{ $i+1 }}</span></td>
                            <td style="font-size:13px;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $p->product_name }}</td>
                            <td class="text-right">{{ number_format($p->total_qty) }}</td>
                            <td class="text-right" style="font-size:12px;">Rp{{ number_format($p->total_rev,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ── Orders Table ─────────────────────────────────────────────────────── --}}
<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-list mr-2"></i>Detail Transaksi Settlement</h3>
        <span class="badge badge-success">{{ $orders->total() }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>No. Order</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Kota</th>
                        <th>Item</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-right">Diskon</th>
                        <th class="text-right">Ongkir</th>
                        <th class="text-right">Total</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" style="font-weight:700;font-size:13px;">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td style="font-size:12px;white-space:nowrap;">{{ $order->created_at->format('d M Y') }}<br><span style="color:#9ca3af;">{{ $order->created_at->format('H:i') }}</span></td>
                        <td style="font-size:13px;">
                            <div style="font-weight:600;">{{ $order->customer_name }}</div>
                            <div style="font-size:11px;color:#9ca3af;">{{ $order->customer_email }}</div>
                        </td>
                        <td style="font-size:13px;">{{ $order->city }}</td>
                        <td>
                            <span class="badge badge-light">{{ $order->items->sum('quantity') }} item</span>
                        </td>
                        <td class="text-right" style="font-size:13px;">Rp{{ number_format($order->subtotal,0,',','.') }}</td>
                        <td class="text-right" style="font-size:13px;color:#ef4444;">
                            @if($order->discount > 0)-Rp{{ number_format($order->discount,0,',','.') }}@else —@endif
                        </td>
                        <td class="text-right" style="font-size:13px;">Rp{{ number_format($order->shipping,0,',','.') }}</td>
                        <td class="text-right" style="font-weight:800;color:#166534;">Rp{{ number_format($order->total,0,',','.') }}</td>
                        <td style="font-size:12px;">{{ $order->paymentMethod?->name ?? $order->payment_method }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Tidak ada transaksi settlement pada periode ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($orders->count() > 0)
                <tfoot class="thead-light">
                    <tr>
                        <th colspan="5" class="text-right">Total Halaman Ini:</th>
                        <th class="text-right">Rp{{ number_format($orders->sum('subtotal'),0,',','.') }}</th>
                        <th class="text-right" style="color:#ef4444;">-Rp{{ number_format($orders->sum('discount'),0,',','.') }}</th>
                        <th class="text-right">Rp{{ number_format($orders->sum('shipping'),0,',','.') }}</th>
                        <th class="text-right" style="color:#166534;">Rp{{ number_format($orders->sum('total'),0,',','.') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Revenue chart ─────────────────────────────────────
const chartData = @json($chartData);

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: chartData.map(d => d.label),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: chartData.map(d => d.revenue),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#10b981',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k'
                },
                grid: { color: '#f1f5f9' }
            },
            x: { grid: { display: false } }
        }
    }
});

// ── Toggle custom date range ──────────────────────────
function toggleCustom(val) {
    document.getElementById('custom-range').style.display = val === 'custom' ? 'flex' : 'none';
}
</script>
@endpush
