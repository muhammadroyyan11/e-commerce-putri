@extends('admin.layouts.app')
@section('title', 'API Settings')
@section('page-title', 'API Settings')

@section('content')
<form action="{{ route('admin.api-settings.update') }}" method="POST">
    @csrf @method('PUT')

    {{-- Midtrans --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-credit-card mr-2"></i> Midtrans</h3>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="midtrans_enabled" name="midtrans_enabled" value="1" {{ ($settings['midtrans_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                <label class="custom-control-label" for="midtrans_enabled">Aktif</label>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Server Key</label>
                        <input type="text" name="midtrans_server_key" class="form-control" value="{{ $settings['midtrans_server_key'] ?? '' }}" placeholder="SB-Mid-server-...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Client Key</label>
                        <input type="text" name="midtrans_client_key" class="form-control" value="{{ $settings['midtrans_client_key'] ?? '' }}" placeholder="SB-Mid-client-...">
                    </div>
                </div>
            </div>
            <div class="form-group mb-0">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="midtrans_production" name="midtrans_production" value="1" {{ ($settings['midtrans_production'] ?? '0') === '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="midtrans_production">Mode Production (matikan = Sandbox)</label>
                </div>
            </div>
        </div>
    </div>

    {{-- RajaOngkir --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-truck mr-2"></i> RajaOngkir <small class="text-muted">(Domestik Indonesia)</small></h3>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="rajaongkir_enabled" name="rajaongkir_enabled" value="1" {{ ($settings['rajaongkir_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                <label class="custom-control-label" for="rajaongkir_enabled">Aktif</label>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>API Key</label>
                        <input type="text" name="rajaongkir_api_key" class="form-control" value="{{ $settings['rajaongkir_api_key'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ID Kota Asal <small class="text-muted">(<a href="https://rajaongkir.com/dokumentasi" target="_blank">lihat daftar</a>)</small></label>
                        <input type="text" name="rajaongkir_origin_city" class="form-control" value="{{ $settings['rajaongkir_origin_city'] ?? '' }}" placeholder="501 = Surabaya">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shippo --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-globe mr-2"></i> Shippo <small class="text-muted">(Internasional)</small></h3>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="shippo_enabled" name="shippo_enabled" value="1" {{ ($settings['shippo_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                <label class="custom-control-label" for="shippo_enabled">Aktif</label>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>API Token</label>
                        <input type="text" name="shippo_api_key" class="form-control" value="{{ $settings['shippo_api_key'] ?? '' }}" placeholder="shippo_test_...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kode Pos Asal</label>
                        <input type="text" name="shippo_origin_zip" class="form-control" value="{{ $settings['shippo_origin_zip'] ?? '' }}" placeholder="60111">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Negara Asal (ISO)</label>
                        <input type="text" name="shippo_origin_country" class="form-control" value="{{ $settings['shippo_origin_country'] ?? 'ID' }}" placeholder="ID" maxlength="2">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Semua</button>
</form>
@endsection
