@extends('admin.layouts.app')
@section('title', 'Zona Pengiriman')
@section('page-title', 'Zona Pengiriman Internasional')

@section('content')
<div class="row">
    {{-- Form Tambah --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Tambah Zona</h3></div>
            <div class="card-body">
                <form action="{{ route('admin.shipping-zones.store') }}" method="POST">
                    @csrf
                    @include('admin.shipping-zones._form')
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Zona --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Daftar Zona</h3></div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Nama Zona</th>
                            <th>Negara</th>
                            <th>Flat Rate</th>
                            <th>Status</th>
                            <th class="no-sort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($zones as $zone)
                        <tr>
                            <td><strong>{{ $zone->name }}</strong></td>
                            <td>
                                <small>{{ implode(', ', array_slice($zone->countries ?? [], 0, 5)) }}
                                @if(count($zone->countries ?? []) > 5)
                                    <span class="text-muted">+{{ count($zone->countries) - 5 }} lainnya</span>
                                @endif
                                </small>
                            </td>
                            <td>Rp {{ number_format($zone->flat_rate, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $zone->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $zone->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-zone="{{ json_encode($zone) }}"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('admin.shipping-zones.destroy', $zone) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">Belum ada zona.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Zona</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    @include('admin.shipping-zones._form', ['editing' => true])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('.btn-edit').on('click', function () {
    const z = $(this).data('zone');
    const form = $('#editForm');
    form.attr('action', '/admin/shipping-zones/' + z.id);
    form.find('[name="name"]').last().val(z.name);
    form.find('[name="flat_rate"]').last().val(z.flat_rate);
    form.find('[name="sort_order"]').last().val(z.sort_order);
    form.find('[name="is_active"]').last().prop('checked', z.is_active == 1);
    // countries textarea
    form.find('[name="countries_text"]').last().val((z.countries || []).join('\n'));
    $('#editModal').modal('show');
});
</script>
@endpush
