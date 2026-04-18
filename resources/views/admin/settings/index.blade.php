@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Website')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- ── Identitas Website ──────────────────────────────────────────── --}}
    <div class="card card-outline card-primary mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-globe mr-2"></i>Identitas Website</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Website / Toko <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror"
                               value="{{ old('site_name', $settings['site_name']) }}" required>
                        @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Logo Website</label>
                        @if($settings['site_logo'])
                            <div class="mb-2">
                                <img src="{{ $settings['site_logo'] }}" style="max-height:60px;" class="img-thumbnail">
                            </div>
                        @endif
                        <div class="input-group mb-2">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-image"></i></span></div>
                            <input type="text" name="site_logo" class="form-control" placeholder="URL Logo (opsional)"
                                   value="{{ old('site_logo', $settings['site_logo']) }}">
                        </div>
                        <div class="custom-file">
                            <input type="file" name="site_logo_file" class="custom-file-input @error('site_logo_file') is-invalid @enderror"
                                   id="site_logo_file" accept="image/*">
                            <label class="custom-file-label" for="site_logo_file">Upload logo...</label>
                            @error('site_logo_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">Pilih salah satu: isi URL atau upload file.</small>
                    </div>
                </div>
            </div>

            <div class="form-group mb-0">
                <label>Deskripsi Toko</label>
                <textarea name="site_description" class="form-control" rows="3"
                          placeholder="Deskripsi singkat toko Anda...">{{ old('site_description', \App\Models\Setting::get('site_description','')) }}</textarea>
                <small class="text-muted">Ditampilkan di footer website.</small>
            </div>
        </div>
    </div>

    {{-- ── Informasi Kontak ────────────────────────────────────────────── --}}
    <div class="card card-outline card-success mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-address-book mr-2"></i>Informasi Kontak</h3>
            <div class="card-tools">
                <small class="text-muted">Ditampilkan di footer website</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt text-danger mr-1"></i> Alamat</label>
                        <textarea name="contact_address" class="form-control" rows="2"
                                  placeholder="Jl. Contoh No. 123, Jakarta">{{ old('contact_address', $settings['contact_address']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-clock text-warning mr-1"></i> Jam Operasional</label>
                        <input type="text" name="contact_hours" class="form-control"
                               placeholder="Senin - Sabtu, 08:00 - 18:00 WIB"
                               value="{{ old('contact_hours', $settings['contact_hours']) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-phone text-success mr-1"></i> Telepon</label>
                        <input type="text" name="contact_phone" class="form-control"
                               placeholder="+62 812 3456 7890"
                               value="{{ old('contact_phone', $settings['contact_phone']) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fab fa-whatsapp text-success mr-1"></i> WhatsApp</label>
                        <input type="text" name="contact_whatsapp" class="form-control"
                               placeholder="+62 812 3456 7890"
                               value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}">
                        <small class="text-muted">Nomor saja, tanpa spasi/tanda hubung</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-envelope text-primary mr-1"></i> Email</label>
                        <input type="email" name="contact_email" class="form-control"
                               placeholder="hello@toko.id"
                               value="{{ old('contact_email', $settings['contact_email']) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Social Media ────────────────────────────────────────────────── --}}
    <div class="card card-outline card-info mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-share-alt mr-2"></i>Social Media</h3>
            <div class="card-tools">
                <small class="text-muted">Isi URL lengkap, kosongkan jika tidak ada</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fab fa-facebook text-primary mr-1"></i> Facebook</label>
                        <input type="url" name="social_facebook" class="form-control @error('social_facebook') is-invalid @enderror"
                               placeholder="https://facebook.com/namatoko"
                               value="{{ old('social_facebook', $settings['social_facebook']) }}">
                        @error('social_facebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fab fa-instagram text-danger mr-1"></i> Instagram</label>
                        <input type="url" name="social_instagram" class="form-control @error('social_instagram') is-invalid @enderror"
                               placeholder="https://instagram.com/namatoko"
                               value="{{ old('social_instagram', $settings['social_instagram']) }}">
                        @error('social_instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fab fa-twitter text-info mr-1"></i> Twitter / X</label>
                        <input type="url" name="social_twitter" class="form-control @error('social_twitter') is-invalid @enderror"
                               placeholder="https://twitter.com/namatoko"
                               value="{{ old('social_twitter', $settings['social_twitter']) }}">
                        @error('social_twitter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label><i class="fab fa-youtube text-danger mr-1"></i> YouTube</label>
                        <input type="url" name="social_youtube" class="form-control @error('social_youtube') is-invalid @enderror"
                               placeholder="https://youtube.com/@namatoko"
                               value="{{ old('social_youtube', $settings['social_youtube']) }}">
                        @error('social_youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label><i class="fab fa-tiktok mr-1"></i> TikTok</label>
                        <input type="url" name="social_tiktok" class="form-control @error('social_tiktok') is-invalid @enderror"
                               placeholder="https://tiktok.com/@namatoko"
                               value="{{ old('social_tiktok', $settings['social_tiktok']) }}">
                        @error('social_tiktok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Trust Badges ────────────────────────────────────────────────── --}}
    <div class="card card-outline card-warning mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Trust Badges (Homepage)</h3>
            <div class="card-tools"><small class="text-muted">Angka yang ditampilkan di section kepercayaan homepage</small></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label><i class="fas fa-users text-success mr-1"></i> Pelanggan Puas</label>
                        <input type="text" name="trust_customers" class="form-control"
                               placeholder="10.000+" value="{{ old('trust_customers', $settings['trust_customers']) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label><i class="fas fa-leaf text-success mr-1"></i> Jenis Tanaman</label>
                        <input type="text" name="trust_products" class="form-control"
                               placeholder="500+" value="{{ old('trust_products', $settings['trust_products']) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label><i class="fas fa-truck text-primary mr-1"></i> Pengiriman Aman</label>
                        <input type="text" name="trust_delivery" class="form-control"
                               placeholder="100%" value="{{ old('trust_delivery', $settings['trust_delivery']) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label><i class="fas fa-star text-warning mr-1"></i> Rating</label>
                        <input type="text" name="trust_rating" class="form-control"
                               placeholder="4.9/5" value="{{ old('trust_rating', $settings['trust_rating']) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save mr-2"></i>Simpan Semua Pengaturan
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
$('.custom-file-input').on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass('selected').html(fileName);
});
</script>
@endpush
