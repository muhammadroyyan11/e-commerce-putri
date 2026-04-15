@extends('admin.layouts.app')

@section('title', 'Produk')
@section('page-title', 'Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Produk</h3>
        <div class="card-tools">
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah Produk</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="stock-filter" class="mb-1">Filter Stok</label>
                <select id="stock-filter" class="form-control">
                    <option value="">Semua Stok</option>
                    <option value="out">Stok Habis</option>
                    <option value="low">Stok Menipis (<= 5)</option>
                    <option value="available">Tersedia (> 5)</option>
                </select>
            </div>
        </div>

        <table id="products-table" class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="no-sort" style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        const stockFilter = document.getElementById('stock-filter');
        const dataTable = $('#products-table').DataTable();

        $.fn.dataTable.ext.search.push(function (settings, data) {
            if (settings.nTable.id !== 'products-table') {
                return true;
            }

            const filterValue = stockFilter.value;
            const stock = parseInt(data[4], 10) || 0;

            if (!filterValue) {
                return true;
            }

            if (filterValue === 'out') {
                return stock <= 0;
            }

            if (filterValue === 'low') {
                return stock > 0 && stock <= 5;
            }

            if (filterValue === 'available') {
                return stock > 5;
            }

            return true;
        });

        stockFilter.addEventListener('change', function () {
            dataTable.draw();
        });
    });
</script>
@endpush
