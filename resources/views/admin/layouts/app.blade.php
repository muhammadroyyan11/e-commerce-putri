<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | {{ App\Models\Setting::get('site_name', 'LongLeaf') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">Lihat Website</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                @php $siteName = App\Models\Setting::get('site_name', 'LongLeaf'); @endphp
                <span class="brand-text font-weight-light ml-3"><b>{{ Str::before($siteName, ' ') ?: $siteName }}</b>{{ Str::after($siteName, ' ') ? ' ' . Str::after($siteName, ' ') : '' }} Admin</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-header">USER MANAGEMENT</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-header">KATALOG</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-leaf"></i>
                                <p>Produk</p>
                            </a>
                        </li>
                        <li class="nav-header">KONTEN & PENJUALAN</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.blog-posts.index') }}" class="nav-link {{ request()->routeIs('admin.blog-posts.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>Blog / Artikel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Pesanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.payment-confirmations.index') }}" class="nav-link {{ request()->routeIs('admin.payment-confirmations.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-check-alt"></i>
                                <p>Konfirmasi Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.newsletters.index') }}" class="nav-link {{ request()->routeIs('admin.newsletters.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Newsletter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>FAQ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.about.index') }}" class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Halaman About</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Our Team</p>
                            </a>
                        </li>
                        <li class="nav-header">PEMBAYARAN</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.payment-methods.index') }}" class="nav-link {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-university"></i>
                                <p>Metode Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ticket-alt"></i>
                                <p>Coupon / Voucher</p>
                            </a>
                        </li>
                        <li class="nav-header">LAPORAN</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Laporan Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-header">KONFIGURASI</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.api-settings.index') }}" class="nav-link {{ request()->routeIs('admin.api-settings.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plug"></i>
                                <p>API Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.shipping-zones.index') }}" class="nav-link {{ request()->routeIs('admin.shipping-zones.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-globe-asia"></i>
                                <p>Zona Pengiriman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Pengaturan</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>&copy; {{ date('Y') }} {{ App\Models\Setting::get('site_name', 'LongLeaf') }}.</strong> All rights reserved.
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $('.datatable').each(function () {
                // Skip jika tabel kosong (hanya ada baris colspan)
                if ($(this).find('tbody tr td[colspan]').length > 0 && $(this).find('tbody tr').length === 1) {
                    return;
                }
                if ($.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable().destroy();
                }
                $(this).DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    ordering: true,
                    responsive: true,
                    autoWidth: false,
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ data',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data',
                        zeroRecords: 'Data tidak ditemukan',
                        emptyTable: 'Belum ada data',
                        paginate: {
                            first: 'Awal',
                            last: 'Akhir',
                            next: 'Berikutnya',
                            previous: 'Sebelumnya'
                        }
                    },
                    columnDefs: [
                        {
                            targets: 'no-sort',
                            orderable: false
                        }
                    ]
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
