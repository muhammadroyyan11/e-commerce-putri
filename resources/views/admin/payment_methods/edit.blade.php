@extends('admin.layouts.app')

@section('title', 'Edit Metode Pembayaran')
@section('page-title', 'Edit Metode Pembayaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Metode Pembayaran</h3>
    </div>
    <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Nama Bank / Metode</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $paymentMethod->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Logo</label>
                @if($paymentMethod->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $paymentMethod->logo) }}" alt="Logo" style="height: 40px; border: 1px solid #dee2e6; border-radius: 4px; padding: 4px; background: #fff;">
                    </div>
                @endif
                <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" accept="image/*">
                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Nomor Rekening</label>
                <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ old('account_number', $paymentMethod->account_number) }}" required>
                @error('account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Atas Nama</label>
                <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror" value="{{ old('account_name', $paymentMethod->account_name) }}" required>
                @error('account_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $paymentMethod->sort_order) }}">
                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
