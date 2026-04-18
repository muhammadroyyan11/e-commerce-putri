@extends('admin.layouts.app')
@section('title','FAQ')
@section('page-title','Manajemen FAQ')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar FAQ</h3>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah FAQ
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover datatable mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pertanyaan (ID)</th>
                    <th>Pertanyaan (EN)</th>
                    <th>Kategori</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th class="no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td>{{ $faq->id }}</td>
                    <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $faq->question_id }}</td>
                    <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $faq->question_en }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($faq->category) }}</span></td>
                    <td>{{ $faq->sort_order }}</td>
                    <td>
                        @if($faq->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-xs btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Hapus FAQ ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada FAQ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
