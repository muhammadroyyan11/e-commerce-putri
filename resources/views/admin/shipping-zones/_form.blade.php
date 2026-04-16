<div class="form-group">
    <label>Nama Zona</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $zone->name ?? '') }}" placeholder="SEA, Europe, dll" required>
</div>
<div class="form-group">
    <label>Daftar Negara <small class="text-muted">(satu per baris)</small></label>
    <textarea name="countries_text" class="form-control" rows="5" placeholder="Malaysia&#10;Singapore&#10;Thailand" required>{{ old('countries_text', isset($zone) ? implode("\n", $zone->countries ?? []) : '') }}</textarea>
</div>
<div class="form-group">
    <label>Flat Rate (Rp)</label>
    <input type="number" name="flat_rate" class="form-control" value="{{ old('flat_rate', $zone->flat_rate ?? 0) }}" min="0" required>
</div>
<div class="form-group">
    <label>Urutan</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $zone->sort_order ?? 0) }}">
</div>
<div class="form-group mb-0">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="is_active_{{ $editing ?? 'new' }}" name="is_active" value="1" {{ old('is_active', $zone->is_active ?? true) ? 'checked' : '' }}>
        <label class="custom-control-label" for="is_active_{{ $editing ?? 'new' }}">Aktif</label>
    </div>
</div>
