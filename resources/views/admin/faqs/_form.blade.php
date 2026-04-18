<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>🇮🇩 Pertanyaan (Indonesia) <span class="text-danger">*</span></label>
            <input type="text" name="question_id" class="form-control @error('question_id') is-invalid @enderror"
                   value="{{ old('question_id', $faq->question_id ?? '') }}" required>
            @error('question_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>🇮🇩 Jawaban (Indonesia) <span class="text-danger">*</span></label>
            <textarea name="answer_id" class="form-control @error('answer_id') is-invalid @enderror" rows="4"
                      required>{{ old('answer_id', $faq->answer_id ?? '') }}</textarea>
            @error('answer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>🇬🇧 Question (English) <span class="text-danger">*</span></label>
            <input type="text" name="question_en" class="form-control @error('question_en') is-invalid @enderror"
                   value="{{ old('question_en', $faq->question_en ?? '') }}" required>
            @error('question_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>🇬🇧 Answer (English) <span class="text-danger">*</span></label>
            <textarea name="answer_en" class="form-control @error('answer_en') is-invalid @enderror" rows="4"
                      required>{{ old('answer_en', $faq->answer_en ?? '') }}</textarea>
            @error('answer_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Kategori</label>
            <select name="category" class="form-control">
                @foreach(['general'=>'Umum','shipping'=>'Pengiriman','payment'=>'Pembayaran','care'=>'Perawatan'] as $val => $label)
                <option value="{{ $val }}" {{ old('category', $faq->category ?? 'general') === $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Urutan Tampil</label>
            <input type="number" name="sort_order" class="form-control" min="0"
                   value="{{ old('sort_order', $faq->sort_order ?? 0) }}">
        </div>
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                       {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_active">Aktif / Tampilkan</label>
            </div>
        </div>
    </div>
</div>
