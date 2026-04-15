@extends('admin.layouts.app')

@section('title', 'Edit Pesanan')
@section('page-title', 'Edit Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Status Pesanan {{ $order->order_number }}</h3>
    </div>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Status Pesanan</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="awaiting_confirmation" {{ old('status', $order->status) == 'awaiting_confirmation' ? 'selected' : '' }}>Awaiting Confirmation</option>
                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Catatan Admin</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
