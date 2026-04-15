@extends('admin.layouts.app')

@section('title', 'Konfirmasi Pembayaran')
@section('page-title', 'Konfirmasi Pembayaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Konfirmasi Pembayaran</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Jumlah Transfer</th>
                    <th>Tanggal Transfer</th>
                    <th>Status</th>
                    <th>Tanggal Kirim</th>
                    <th class="no-sort" style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($confirmations as $confirmation)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $confirmation->order->order_number }}</td>
                    <td>{{ $confirmation->user->name }}</td>
                    <td>Rp {{ number_format($confirmation->amount, 0, ',', '.') }}</td>
                    <td>{{ $confirmation->payment_date->format('d M Y') }}</td>
                    <td>
                        @php
                            $badges = [
                                'pending' => 'badge-warning',
                                'confirmed' => 'badge-success',
                                'rejected' => 'badge-danger',
                            ];
                        @endphp
                        <span class="badge {{ $badges[$confirmation->status] ?? 'badge-secondary' }}">
                            {{ ucfirst($confirmation->status) }}
                        </span>
                    </td>
                    <td>{{ $confirmation->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.payment-confirmations.show', $confirmation) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada konfirmasi pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
