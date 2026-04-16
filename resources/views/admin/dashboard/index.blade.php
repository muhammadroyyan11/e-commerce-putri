@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    $orderBadges = [
        'pending' => ['class' => 'badge-warning', 'label' => 'Pending'],
        'awaiting_confirmation' => ['class' => 'badge-secondary', 'label' => 'Menunggu Verifikasi'],
        'processing' => ['class' => 'badge-info', 'label' => 'Diproses'],
        'shipped' => ['class' => 'badge-primary', 'label' => 'Dikirim'],
        'completed' => ['class' => 'badge-success', 'label' => 'Selesai'],
        'cancelled' => ['class' => 'badge-danger', 'label' => 'Cancelled'],
    ];
    $statusChartLabels = $statusBreakdown->map(fn ($item) => $orderBadges[$item['status']]['label'] ?? ucfirst($item['status']))->values();
    $statusChartValues = $statusBreakdown->pluck('count')->values();
    $trendLabels = $dailyOrders->pluck('label')->values();
    $trendOrders = $dailyOrders->pluck('orders')->values();
    $trendRevenue = $dailyOrders->pluck('revenue')->map(fn ($value) => (float) $value)->values();
@endphp

<div class="dashboard-hero mb-4">
    <div>
        <span class="dashboard-kicker">LongLeaf Admin Overview</span>
        <h2 class="dashboard-title">Pantau toko, pesanan, dan konten dari satu panel yang lebih hidup.</h2>
        <p class="dashboard-subtitle">Ringkasan ini menonjolkan kesehatan operasional harian: penjualan, progres pesanan, performa katalog, dan aktivitas pelanggan.</p>
        <div class="dashboard-actions">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-sm"><i class="fas fa-receipt mr-1"></i> Kelola Pesanan</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-leaf mr-1"></i> Kelola Produk</a>
        </div>
    </div>
    <div class="dashboard-hero-metrics">
        <div class="metric-chip">
            <span class="metric-label">Total Pendapatan</span>
            <strong>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</strong>
        </div>
        <div class="metric-chip">
            <span class="metric-label">Pesanan Aktif</span>
            <strong>{{ $stats['pending_orders'] + $stats['processing_orders'] }}</strong>
        </div>
        <div class="metric-chip">
            <span class="metric-label">Subscriber</span>
            <strong>{{ $stats['newsletters'] }}</strong>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.products.index') }}" class="stat-card stat-card-blue">
            <span class="stat-icon"><i class="fas fa-leaf"></i></span>
            <div class="stat-meta">
                <span class="stat-label">Produk</span>
                <strong class="stat-value">{{ $stats['products'] }}</strong>
                <small>{{ $stats['active_products'] }} aktif di katalog</small>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.categories.index') }}" class="stat-card stat-card-green">
            <span class="stat-icon"><i class="fas fa-tags"></i></span>
            <div class="stat-meta">
                <span class="stat-label">Kategori</span>
                <strong class="stat-value">{{ $stats['categories'] }}</strong>
                <small>Terstruktur untuk katalog</small>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.orders.index') }}" class="stat-card stat-card-amber">
            <span class="stat-icon"><i class="fas fa-shopping-bag"></i></span>
            <div class="stat-meta">
                <span class="stat-label">Pesanan</span>
                <strong class="stat-value">{{ $stats['orders'] }}</strong>
                <small>{{ $stats['completed_orders'] }} selesai</small>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.blog-posts.index') }}" class="stat-card stat-card-rose">
            <span class="stat-icon"><i class="fas fa-newspaper"></i></span>
            <div class="stat-meta">
                <span class="stat-label">Artikel</span>
                <strong class="stat-value">{{ $stats['blog_posts'] }}</strong>
                <small>{{ $stats['published_posts'] }} sudah publish</small>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="insight-card mb-4">
            <div class="insight-header">
                <div>
                    <span class="section-kicker">Performance Trends</span>
                    <h3>Tren 7 Hari Terakhir</h3>
                </div>
            </div>
            <div class="chart-panel">
                <canvas id="orders-trend-chart" height="120"></canvas>
            </div>
        </div>

        <div class="insight-card mb-4">
            <div class="insight-header">
                <div>
                    <span class="section-kicker">Operational Snapshot</span>
                    <h3>Progres Pesanan</h3>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success btn-sm">Semua Pesanan</a>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mini-progress-card">
                        <span class="mini-progress-label">Pending</span>
                        <strong>{{ $stats['pending_orders'] }}</strong>
                        <div class="progress slim-progress">
                            <div class="progress-bar bg-warning" style="width: {{ $stats['orders'] ? round(($stats['pending_orders'] / $stats['orders']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mini-progress-card">
                        <span class="mini-progress-label">Diproses</span>
                        <strong>{{ $stats['processing_orders'] }}</strong>
                        <div class="progress slim-progress">
                            <div class="progress-bar bg-info" style="width: {{ $stats['orders'] ? round(($stats['processing_orders'] / $stats['orders']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mini-progress-card">
                        <span class="mini-progress-label">Selesai</span>
                        <strong>{{ $stats['completed_orders'] }}</strong>
                        <div class="progress slim-progress">
                            <div class="progress-bar bg-success" style="width: {{ $stats['orders'] ? round(($stats['completed_orders'] / $stats['orders']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="insight-card">
            <div class="insight-header">
                <div>
                    <span class="section-kicker">Latest Activity</span>
                    <h3>Pesanan Terbaru</h3>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover admin-dashboard-table mb-0">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                @php $badge = $orderBadges[$order->status] ?? ['class' => 'badge-secondary', 'label' => ucfirst($order->status)]; @endphp
                                <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="insight-card mb-4">
            <div class="insight-header">
                <div>
                    <span class="section-kicker">Status Distribution</span>
                    <h3>Komposisi Status Pesanan</h3>
                </div>
            </div>
            <div class="chart-panel chart-panel-donut">
                <canvas id="orders-status-chart" height="220"></canvas>
            </div>
        </div>

        <div class="insight-card mb-4">
            <div class="insight-header">
                <div>
                    <span class="section-kicker">Quick Summary</span>
                    <h3>Ringkasan</h3>
                </div>
            </div>
            <div class="summary-stack">
                <div class="summary-row">
                    <span>Pesanan Pending</span>
                    <strong>{{ $stats['pending_orders'] }}</strong>
                </div>
                <div class="summary-row">
                    <span>Subscriber Newsletter</span>
                    <strong>{{ $stats['newsletters'] }}</strong>
                </div>
                <div class="summary-row">
                    <span>Total Pendapatan</span>
                    <strong>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</strong>
                </div>
                <div class="summary-row">
                    <span>Artikel Publish</span>
                    <strong>{{ $stats['published_posts'] }}</strong>
                </div>
            </div>
            <a href="{{ route('admin.newsletters.index') }}" class="btn btn-dark btn-sm btn-block mt-3">Lihat Newsletter</a>
        </div>

        <div class="insight-card">
            <div class="insight-header">
                <div>
                    <span class="section-kicker">Catalog Pulse</span>
                    <h3>Produk Terbaru</h3>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark btn-sm">Lihat Produk</a>
            </div>
            <div class="product-list">
                @forelse($recentProducts as $product)
                    <div class="product-list-item">
                        <div class="product-avatar">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="product-copy">
                            <strong>{{ $product->name }}</strong>
                            <span>{{ $product->category?->name ?? 'Tanpa kategori' }} • Stok {{ $product->stock }}</span>
                        </div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                @empty
                    <div class="text-muted">Belum ada produk terbaru.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-hero {
        display: flex;
        justify-content: space-between;
        gap: 24px;
        padding: 28px 32px;
        border-radius: 28px;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,0.26), transparent 28%),
            linear-gradient(135deg, #0f3d2e 0%, #166534 48%, #3b82f6 100%);
        color: #fff;
        box-shadow: 0 22px 44px rgba(15, 61, 46, 0.22);
    }
    .dashboard-kicker,
    .section-kicker {
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: 11px;
        font-weight: 700;
        opacity: .72;
        margin-bottom: 10px;
    }
    .dashboard-title {
        font-size: 32px;
        line-height: 1.18;
        margin: 0 0 12px;
        max-width: 720px;
    }
    .dashboard-subtitle {
        max-width: 680px;
        color: rgba(255,255,255,0.86);
        margin-bottom: 18px;
    }
    .dashboard-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .dashboard-hero-metrics {
        width: 320px;
        display: grid;
        gap: 12px;
        align-self: stretch;
    }
    .metric-chip {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 18px;
        padding: 16px 18px;
        backdrop-filter: blur(6px);
    }
    .metric-chip strong {
        display: block;
        font-size: 24px;
        margin-top: 4px;
    }
    .metric-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        opacity: .78;
    }
    .stat-card {
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 22px;
        border-radius: 24px;
        color: #fff;
        text-decoration: none !important;
        min-height: 138px;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.12);
        margin-bottom: 22px;
        position: relative;
        overflow: hidden;
    }
    .stat-card::after {
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        right: -24px;
        bottom: -28px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
    }
    .stat-card-blue { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
    .stat-card-green { background: linear-gradient(135deg, #059669, #047857); }
    .stat-card-amber { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-card-rose { background: linear-gradient(135deg, #e11d48, #be123c); }
    .stat-icon {
        width: 56px;
        height: 56px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        background: rgba(255,255,255,0.18);
        font-size: 24px;
        flex-shrink: 0;
    }
    .stat-meta { position: relative; z-index: 1; }
    .stat-label {
        display: block;
        font-size: 13px;
        opacity: .84;
        margin-bottom: 6px;
    }
    .stat-value {
        display: block;
        font-size: 30px;
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-meta small {
        color: rgba(255,255,255,0.82);
    }
    .insight-card {
        background: #fff;
        border-radius: 24px;
        padding: 22px 24px;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
    }
    .insight-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
    }
    .insight-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }
    .mini-progress-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px;
        margin-bottom: 12px;
    }
    .mini-progress-card strong {
        display: block;
        font-size: 28px;
        color: #0f172a;
        margin: 6px 0 10px;
    }
    .mini-progress-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
    }
    .slim-progress {
        height: 8px;
        border-radius: 999px;
        background: #e2e8f0;
    }
    .admin-dashboard-table thead th {
        border-top: none;
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
    }
    .summary-stack {
        display: grid;
        gap: 12px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 16px;
    }
    .summary-row span {
        color: #475569;
    }
    .summary-row strong {
        color: #0f172a;
    }
    .product-list {
        display: grid;
        gap: 12px;
    }
    .product-list-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #edf2f7;
    }
    .product-list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .product-avatar {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
        flex-shrink: 0;
    }
    .product-copy {
        flex: 1;
        display: grid;
        gap: 3px;
    }
    .product-copy span {
        color: #64748b;
        font-size: 13px;
    }
    .product-price {
        font-weight: 700;
        color: #0f172a;
    }
    .chart-panel {
        position: relative;
        min-height: 280px;
    }
    .chart-panel-donut {
        min-height: 240px;
    }
    @media (max-width: 991px) {
        .dashboard-hero {
            flex-direction: column;
        }
        .dashboard-hero-metrics {
            width: 100%;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    @media (max-width: 767px) {
        .dashboard-title {
            font-size: 26px;
        }
        .dashboard-hero-metrics {
            grid-template-columns: 1fr;
        }
        .insight-header {
            flex-direction: column;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    (() => {
        const trendCtx = document.getElementById('orders-trend-chart');
        const statusCtx = document.getElementById('orders-status-chart');

        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Pesanan',
                            data: @json($trendOrders),
                            backgroundColor: 'rgba(37, 99, 235, 0.75)',
                            borderRadius: 10,
                            maxBarThickness: 34,
                            yAxisID: 'y'
                        },
                        {
                            type: 'line',
                            label: 'Pendapatan',
                            data: @json($trendRevenue),
                            borderColor: '#16a34a',
                            backgroundColor: 'rgba(22, 163, 74, 0.18)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 5,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label(context) {
                                    if (context.dataset.label === 'Pendapatan') {
                                        return 'Pendapatan: Rp ' + Number(context.raw).toLocaleString('id-ID');
                                    }

                                    return 'Pesanan: ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            ticks: {
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Pesanan'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                callback(value) {
                                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                                }
                            },
                            title: {
                                display: true,
                                text: 'Pendapatan'
                            }
                        }
                    }
                }
            });
        }

        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($statusChartLabels),
                    datasets: [{
                        data: @json($statusChartValues),
                        backgroundColor: ['#f59e0b', '#64748b', '#0ea5e9', '#2563eb', '#16a34a', '#e11d48'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 16
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        }
    })();
</script>
@endpush
