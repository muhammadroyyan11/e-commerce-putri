@extends('admin.layouts.app')

@section('title', 'Detail Konfirmasi Pembayaran')
@section('page-title', 'Detail Konfirmasi Pembayaran')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pembayaran</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 180px">No. Pesanan</th>
                        <td>{{ $paymentConfirmation->order->order_number }}</td>
                    </tr>
                    <tr>
                        <th>Pelanggan</th>
                        <td>{{ $paymentConfirmation->user->name }} ({{ $paymentConfirmation->user->email }})</td>
                    </tr>
                    <tr>
                        <th>Nama Pengirim</th>
                        <td>{{ $paymentConfirmation->sender_name }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Transfer</th>
                        <td>Rp {{ number_format($paymentConfirmation->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Pesanan</th>
                        <td>Rp {{ number_format($paymentConfirmation->order->total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Transfer</th>
                        <td>{{ $paymentConfirmation->payment_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Customer</th>
                        <td>{{ $paymentConfirmation->notes ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Konfirmasi</th>
                        <td>
                            @php
                                $badges = [
                                    'pending' => 'badge-warning',
                                    'confirmed' => 'badge-success',
                                    'rejected' => 'badge-danger',
                                ];
                            @endphp
                            <span class="badge {{ $badges[$paymentConfirmation->status] ?? 'badge-secondary' }}" style="font-size: 14px;">
                                {{ ucfirst($paymentConfirmation->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status Pesanan</th>
                        <td>
                            <span class="badge badge-info" style="font-size: 14px;">{{ ucfirst($paymentConfirmation->order->status) }}</span>
                        </td>
                    </tr>
                </table>

                @if($paymentConfirmation->status === 'pending')
                <div class="mt-3">
                    <form action="{{ route('admin.payment-confirmations.confirm', $paymentConfirmation) }}" method="POST" class="d-inline">
                        @csrf
                        <div class="form-group">
                            <label>Catatan Admin (opsional)</label>
                            <textarea name="admin_notes" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pembayaran ini dan ubah status pesanan menjadi processing?')"><i class="fas fa-check"></i> Konfirmasi Pembayaran</button>
                    </form>

                    <form action="{{ route('admin.payment-confirmations.reject', $paymentConfirmation) }}" method="POST" class="d-inline ml-2">
                        @csrf
                        <div class="form-group">
                            <label>Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="admin_notes" class="form-control" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak pembayaran ini?')"><i class="fas fa-times"></i> Tolak</button>
                    </form>
                </div>
                @else
                    <div class="alert alert-info mt-3">
                        <strong>Catatan Admin:</strong> {{ $paymentConfirmation->admin_notes ?: '-' }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bukti Transfer</h3>
            </div>
            <div class="card-body text-center">
                @if($paymentConfirmation->proof_image)
                    <img src="{{ asset('storage/' . $paymentConfirmation->proof_image) }}" alt="Bukti Transfer" style="max-width: 100%; border-radius: 8px; border: 1px solid #dee2e6;">
                @else
                    <p class="text-muted">Customer tidak mengunggah bukti transfer.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
