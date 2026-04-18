@extends('admin.layouts.app')
@section('title','Edit FAQ')
@section('page-title','Edit FAQ')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Edit FAQ</h3></div>
    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
        @csrf @method('PUT')
        <div class="card-body">
            @include('admin.faqs._form', ['faq' => $faq])
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
