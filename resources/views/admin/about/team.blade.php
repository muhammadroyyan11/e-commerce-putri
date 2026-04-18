@extends('admin.layouts.app')

@section('title', 'Kelola Tim')
@section('page-title', 'Our Team')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    {{-- Form Tambah --}}
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Tambah Anggota</h3></div>
            <div class="card-body">
                <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Jabatan <span class="badge badge-warning">ID</span></label>
                        <input type="text" name="position_id" class="form-control @error('position_id') is-invalid @enderror" value="{{ old('position_id') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Position <span class="badge badge-info">EN</span></label>
                        <input type="text" name="position_en" class="form-control @error('position_en') is-invalid @enderror" value="{{ old('position_en') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Bio <span class="badge badge-warning">ID</span></label>
                        <textarea name="bio_id" class="form-control" rows="3">{{ old('bio_id') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Bio <span class="badge badge-info">EN</span></label>
                        <textarea name="bio_en" class="form-control" rows="3">{{ old('bio_en') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus mr-1"></i>Tambah</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Tim --}}
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users mr-2"></i>Daftar Anggota Tim</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.about.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-cog mr-1"></i>Pengaturan About</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="60">Foto</th>
                            <th>Nama</th>
                            <th>Jabatan (ID)</th>
                            <th>Position (EN)</th>
                            <th width="60">Urutan</th>
                            <th width="80">Status</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>
                                @if($member->photo)
                                    <img src="{{ $member->photo }}" class="img-circle" style="width:40px;height:40px;object-fit:cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle font-weight-bold">{{ $member->name }}</td>
                            <td class="align-middle">{{ $member->position_id }}</td>
                            <td class="align-middle">{{ $member->position_en }}</td>
                            <td class="align-middle text-center">{{ $member->order }}</td>
                            <td class="align-middle">
                                <span class="badge badge-{{ $member->is_active ? 'success' : 'secondary' }}">
                                    {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal{{ $member->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus {{ $member->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('admin.team.update', $member) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit: {{ $member->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jabatan <span class="badge badge-warning">ID</span></label>
                                                        <input type="text" name="position_id" class="form-control" value="{{ $member->position_id }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Position <span class="badge badge-info">EN</span></label>
                                                        <input type="text" name="position_en" class="form-control" value="{{ $member->position_en }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bio <span class="badge badge-warning">ID</span></label>
                                                        <textarea name="bio_id" class="form-control" rows="3">{{ $member->bio_id }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bio <span class="badge badge-info">EN</span></label>
                                                        <textarea name="bio_en" class="form-control" rows="3">{{ $member->bio_en }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Foto Baru</label>
                                                        @if($member->photo)
                                                            <img src="{{ $member->photo }}" style="max-height:60px;" class="img-thumbnail d-block mb-1">
                                                        @endif
                                                        <input type="file" name="photo" class="form-control-file" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Urutan</label>
                                                        <input type="number" name="order" class="form-control" value="{{ $member->order }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select name="is_active" class="form-control">
                                                            <option value="1" {{ $member->is_active ? 'selected' : '' }}>Aktif</option>
                                                            <option value="0" {{ !$member->is_active ? 'selected' : '' }}>Nonaktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada anggota tim.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
