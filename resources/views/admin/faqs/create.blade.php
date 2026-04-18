@extends('admin.layouts.app')
@section('title','Tambah FAQ')
@section('page-title','Tambah FAQ')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Form FAQ Baru</h3></div>
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="card-body">
            @include('admin.faqs._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
