@extends('admin.layouts.app')

@section('title', 'Newsletter')
@section('page-title', 'Newsletter')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Subscriber Newsletter</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>Email</th>
                    <th>Tanggal Subscribe</th>
                    <th class="no-sort" style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>{{ $subscriber->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.newsletters.destroy', $subscriber) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada subscriber.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
