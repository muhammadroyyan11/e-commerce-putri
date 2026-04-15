@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Konfigurasi Umum</h3>
    </div>
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Website / Toko</label>
                        <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $settings['site_name']) }}" required>
                        @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Logo Website</label>
                        @if($settings['site_logo'])
                            <div class="mb-2">
                                <img src="{{ $settings['site_logo'] }}" style="max-height: 60px;" class="img-thumbnail">
                            </div>
                        @endif
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                            </div>
                            <input type="text" name="site_logo" class="form-control" placeholder="URL Logo (opsional)" value="{{ old('site_logo', $settings['site_logo']) }}">
                        </div>
                        <div class="custom-file">
                            <input type="file" name="site_logo_file" class="custom-file-input @error('site_logo_file') is-invalid @enderror" id="site_logo_file" accept="image/*">
                            <label class="custom-file-label" for="site_logo_file">Upload logo...</label>
                            @error('site_logo_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">Pilih salah satu: isi URL atau upload file.</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Metode Pembayaran</label>
                <textarea name="payment_methods" class="form-control" rows="5">{{ old('payment_methods', $settings['payment_methods']) }}</textarea>
                <small class="text-muted">Tulis satu metode pembayaran per baris. Contoh: Transfer Bank BCA, COD, dll.</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
</script>
@endpush
