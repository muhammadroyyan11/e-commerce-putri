@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Produk Baru</h3>
    </div>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="editor" class="form-control">{{ old('description') }}</textarea>
                <button type="button" id="btn-generate-ai"
                    style="margin-top:8px; padding:7px 16px; background:#6366f1; color:white; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                    🤖 Generate Deskripsi dengan AI
                </button>
                <small class="text-muted ml-2" id="ai-gen-status"></small>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Harga Asli <small class="text-muted">(opsional)</small></label>
                        <input type="number" name="original_price" class="form-control" value="{{ old('original_price') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diskon (%)</label>
                        <input type="number" name="discount" class="form-control" value="{{ old('discount') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tinggi</label>
                        <input type="text" name="height" class="form-control" value="{{ old('height') }}" placeholder="60-80cm">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cahaya</label>
                        <select name="light" class="form-control">
                            <option value="">Pilih</option>
                            @foreach(['Cerah','Teduh','Rendah','Semi Teduh','Cahaya Penuh'] as $v)
                            <option value="{{ $v }}" {{ old('light') == $v ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tingkat Perawatan</label>
                        <select name="care_level" class="form-control">
                            <option value="">Pilih</option>
                            @foreach(['Sangat Mudah','Mudah','Sedang','Sulit','Sangat Sulit'] as $v)
                            <option value="{{ $v }}" {{ old('care_level') == $v ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Penyiraman</label>
                        <select name="watering" class="form-control">
                            <option value="">Pilih</option>
                            @foreach(['Jarang','Sedang','Sering','Rutin','Setiap Hari','Seminggu Sekali','Dua Minggu Sekali'] as $v)
                            <option value="{{ $v }}" {{ old('watering') == $v ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Badge</label>
                        <select name="badge" class="form-control">
                            <option value="">Tidak Ada</option>
                            @foreach(['new','sale','rare','bestseller','limited','indoor','outdoor'] as $v)
                            <option value="{{ $v }}" {{ old('badge') == $v ? 'selected' : '' }}>{{ ucfirst($v) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Berat (gram) <small class="text-muted">untuk ongkir</small></label>
                        <input type="number" name="weight" class="form-control" value="{{ old('weight', 500) }}" min="1" required>
                    </div>
                </div>
            </div>

            {{-- Multi Image Upload --}}
            <div class="form-group">
                <label>Foto Produk <small class="text-muted">(bisa pilih lebih dari 1, maks 3MB/foto)</small></label>
                <div id="drop-zone"
                     style="border:2px dashed #ced4da; border-radius:8px; padding:30px; text-align:center; cursor:pointer; background:#f8f9fa; transition:border-color .2s;"
                     onclick="document.getElementById('imageInput').click()"
                     ondragover="event.preventDefault(); this.style.borderColor='#28a745';"
                     ondragleave="this.style.borderColor='#ced4da';"
                     ondrop="handleDrop(event)">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                    <p class="mb-0 text-muted">Klik atau drag & drop foto di sini</p>
                    <small class="text-muted">JPG, PNG, WEBP — maks 3MB per foto</small>
                </div>
                <input type="file" id="imageInput" name="images[]" multiple accept="image/*" style="display:none" onchange="previewImages(this.files)">
                @error('images.*')<div class="text-danger mt-1" style="font-size:13px;">{{ $message }}</div>@enderror

                <div id="preview-grid" style="display:flex; flex-wrap:wrap; gap:10px; margin-top:12px;"></div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                    <label class="custom-control-label" for="is_active">Aktif</label>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@include('admin.partials.ckeditor', ['selector' => '#editor'])

@push('scripts')
<script>
// ── AI Generate Description ───────────────────────────
document.getElementById('btn-generate-ai')?.addEventListener('click', async function () {
    const status = document.getElementById('ai-gen-status');
    const name       = document.querySelector('[name="name"]').value.trim();
    const category   = document.querySelector('[name="category_id"] option:checked')?.text || '';
    const care_level = document.querySelector('[name="care_level"]').value;
    const watering   = document.querySelector('[name="watering"]').value;
    const light      = document.querySelector('[name="light"]').value;
    const height     = document.querySelector('[name="height"]').value;

    if (!name) { alert('Isi nama produk terlebih dahulu.'); return; }

    this.disabled = true;
    this.textContent = '⏳ Generating...';
    status.textContent = '';

    try {
        const res = await fetch('{{ route('admin.ai.generate-description') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ name, category, care_level, watering, light, height }),
        });
        const data = await res.json();
        if (data.description && window.editorInstance) {
            window.editorInstance.setData(data.description);
            status.textContent = '✅ Deskripsi berhasil digenerate!';
            status.style.color = '#16a34a';
        }
    } catch {
        status.textContent = '❌ Gagal generate. Coba lagi.';
        status.style.color = '#dc2626';
    } finally {
        this.disabled = false;
        this.textContent = '🤖 Generate Deskripsi dengan AI';
    }
});

let selectedFiles = new DataTransfer();

function previewImages(files) {
    for (const file of files) {
        selectedFiles.items.add(file);
    }
    document.getElementById('imageInput').files = selectedFiles.files;
    renderPreviews();
}

function handleDrop(e) {
    e.preventDefault();
    document.getElementById('drop-zone').style.borderColor = '#ced4da';
    previewImages(e.dataTransfer.files);
}

function removePreview(index) {
    const dt = new DataTransfer();
    const files = selectedFiles.files;
    for (let i = 0; i < files.length; i++) {
        if (i !== index) dt.items.add(files[i]);
    }
    selectedFiles = dt;
    document.getElementById('imageInput').files = selectedFiles.files;
    renderPreviews();
}

function renderPreviews() {
    const grid = document.getElementById('preview-grid');
    grid.innerHTML = '';
    const files = selectedFiles.files;
    for (let i = 0; i < files.length; i++) {
        const url = URL.createObjectURL(files[i]);
        const div = document.createElement('div');
        div.style.cssText = 'position:relative; width:100px; height:100px; border-radius:8px; overflow:hidden; border:2px solid #dee2e6;';
        div.innerHTML = `
            <img src="${url}" style="width:100%;height:100%;object-fit:cover;">
            ${i === 0 ? '<span style="position:absolute;bottom:0;left:0;right:0;background:rgba(40,167,69,.85);color:white;font-size:10px;text-align:center;padding:2px;">Utama</span>' : ''}
            <button type="button" onclick="removePreview(${i})"
                style="position:absolute;top:3px;right:3px;width:20px;height:20px;border-radius:50%;background:rgba(220,53,69,.9);color:white;border:none;cursor:pointer;font-size:12px;line-height:1;padding:0;">✕</button>
        `;
        grid.appendChild(div);
    }
}
</script>
@endpush
