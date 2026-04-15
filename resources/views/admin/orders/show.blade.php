@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pesanan</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Edit Status</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 200px">No. Pesanan</th>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $order->customer_phone }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @php
                                $badges = [
                                    'pending' => 'badge-warning',
                                    'awaiting_confirmation' => 'badge-secondary',
                                    'processing' => 'badge-info',
                                    'shipped' => 'badge-primary',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                ];
                            @endphp
                            <span class="badge {{ $badges[$order->status] ?? 'badge-secondary' }}">{{ ucfirst($order->status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $order->notes ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($order->paymentConfirmation)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Konfirmasi Pembayaran</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.payment-confirmations.show', $order->paymentConfirmation) }}" class="btn btn-sm btn-info">Lihat Detail</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 200px">Nama Pengirim</th>
                        <td>{{ $order->paymentConfirmation->sender_name }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Transfer</th>
                        <td>Rp {{ number_format($order->paymentConfirmation->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Transfer</th>
                        <td>{{ $order->paymentConfirmation->payment_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status Konfirmasi</th>
                        <td>
                            @php
                                $confBadges = [
                                    'pending' => 'badge-warning',
                                    'confirmed' => 'badge-success',
                                    'rejected' => 'badge-danger',
                                ];
                            @endphp
                            <span class="badge {{ $confBadges[$order->paymentConfirmation->status] ?? 'badge-secondary' }}">{{ ucfirst($order->paymentConfirmation->status) }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ringkasan Harga</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Diskon</th>
                        <td class="text-right">Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Ongkir</th>
                        <td class="text-right">Rp {{ number_format($order->shipping, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="text-bold">
                        <th>Total</th>
                        <td class="text-right">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Item Pesanan</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
