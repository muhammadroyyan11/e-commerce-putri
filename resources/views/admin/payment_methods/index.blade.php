@extends('admin.layouts.app')

@section('title', 'Metode Pembayaran')
@section('page-title', 'Metode Pembayaran')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Metode Pembayaran</h3>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>Logo</th>
                    <th>Nama Bank</th>
                    <th>Nomor Rekening</th>
                    <th>Atas Nama</th>
                    <th>Status</th>
                    <th>Urutan</th>
                    <th class="no-sort" style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($methods as $method)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($method->logo)
                            <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" style="height: 32px; border-radius: 4px; border: 1px solid #dee2e6; background: #fff; padding: 2px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $method->name }}</td>
                    <td>{{ $method->account_number }}</td>
                    <td>{{ $method->account_name }}</td>
                    <td>
                        <span class="badge {{ $method->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>{{ $method->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.payment-methods.edit', $method) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada metode pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
