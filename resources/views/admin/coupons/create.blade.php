@extends('admin.layouts.app')

@section('title', 'Tambah Coupon')
@section('page-title', 'Tambah Coupon')

@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            @include('admin.coupons._form')
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
