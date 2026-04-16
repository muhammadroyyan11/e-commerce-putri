<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kode Coupon <small class="text-muted">(5 huruf/angka kapital)</small></label>
            <input type="text" name="code" class="form-control text-uppercase" maxlength="5"
                value="{{ old('code', $coupon->code ?? '') }}" placeholder="ABCD1" required
                oninput="this.value=this.value.toUpperCase()">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="description" class="form-control"
                value="{{ old('description', $coupon->description ?? '') }}">
        </div>
        <div class="form-group">
            <label>Tipe Diskon</label>
            <select name="type" class="form-control" required>
                <option value="percent" {{ old('type', $coupon->type ?? '') === 'percent' ? 'selected' : '' }}>Persen (%)</option>
                <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed (Rp)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nilai Diskon</label>
            <input type="number" name="value" class="form-control" min="1" step="0.01"
                value="{{ old('value', $coupon->value ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Minimum Order (Rp)</label>
            <input type="number" name="min_order" class="form-control" min="0"
                value="{{ old('min_order', $coupon->min_order ?? 0) }}">
        </div>
        <div class="form-group">
            <label>Maksimum Diskon (Rp) <small class="text-muted">opsional</small></label>
            <input type="number" name="max_discount" class="form-control" min="0"
                value="{{ old('max_discount', $coupon->max_discount ?? '') }}">
        </div>
        <div class="form-group">
            <label>Batas Pemakaian <small class="text-muted">opsional</small></label>
            <input type="number" name="usage_limit" class="form-control" min="1"
                value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
        </div>
        <div class="form-group">
            <label>Berlaku Dari</label>
            <input type="date" name="valid_from" class="form-control"
                value="{{ old('valid_from', isset($coupon) ? $coupon->valid_from->format('Y-m-d') : '') }}" required>
        </div>
        <div class="form-group">
            <label>Berlaku Sampai</label>
            <input type="date" name="valid_until" class="form-control"
                value="{{ old('valid_until', isset($coupon) ? $coupon->valid_until->format('Y-m-d') : '') }}" required>
        </div>
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>
</div>
