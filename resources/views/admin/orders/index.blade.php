@extends('admin.layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pesanan</h3>
        <div class="card-tools" style="width: 100%; max-width: 420px;">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input
                            type="date"
                            name="date_from"
                            class="form-control"
                            value="{{ request('date_from') }}"
                        >
                    </div>
                    <div class="col-md-3 mb-2">
                        <input
                            type="date"
                            name="date_to"
                            class="form-control"
                            value="{{ request('date_to') }}"
                        >
                    </div>
                    <div class="col-md-3 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
                @if(request()->filled('date_from') || request()->filled('date_to'))
                    <div class="mt-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal</th>
                    <th class="no-sort" style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
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
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
