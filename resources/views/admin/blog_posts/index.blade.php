@extends('admin.layouts.app')

@section('title', 'Blog / Artikel')
@section('page-title', 'Blog / Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Artikel</h3>
        <div class="card-tools">
            <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah Artikel</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th class="no-sort" style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category }}</td>
                    <td>{{ $post->author }}</td>
                    <td>
                        @if($post->is_published)
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-secondary">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.blog-posts.edit', $post) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
