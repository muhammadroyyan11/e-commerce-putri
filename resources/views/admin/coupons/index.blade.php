@extends('admin.layouts.app')

@section('title', 'Coupon')
@section('page-title', 'Coupon')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Coupon</h3>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-hover {{ $coupons->isNotEmpty() ? 'datatable' : '' }}">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Min. Order</th>
                    <th>Berlaku</th>
                    <th>Pemakaian</th>
                    <th>Status</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $coupon->code }}</strong></td>
                    <td>{{ $coupon->type === 'percent' ? 'Persen' : 'Fixed' }}</td>
                    <td>{{ $coupon->type === 'percent' ? $coupon->value . '%' : 'Rp ' . number_format($coupon->value, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($coupon->min_order, 0, ',', '.') }}</td>
                    <td>{{ $coupon->valid_from->format('d/m/Y') }} – {{ $coupon->valid_until->format('d/m/Y') }}</td>
                    <td>{{ $coupon->used_count }}{{ $coupon->usage_limit ? '/' . $coupon->usage_limit : '' }}</td>
                    <td>
                        <span class="badge {{ $coupon->isValid() ? 'badge-success' : 'badge-secondary' }}">
                            {{ $coupon->isValid() ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus coupon ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center">Belum ada coupon.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
