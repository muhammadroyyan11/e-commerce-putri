@extends('admin.layouts.app')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Artikel</h3>
    </div>
    <form action="{{ route('admin.blog-posts.update', $blogPost) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blogPost->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $blogPost->category) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Penulis</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $blogPost->author ?? auth()->user()->name) }}">
                        <small class="text-muted">Otomatis terisi dari user login jika kosong.</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
            </div>
            <div class="form-group">
                <label>Konten</label>
                <textarea name="content" id="editor" class="form-control">{{ old('content', $blogPost->content) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gambar Thumbnail</label>
                        @if($blogPost->image)
                            <div class="mb-2">
                                <img src="{{ $blogPost->image }}" class="img-thumbnail" style="max-height: 120px;">
                            </div>
                        @endif
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                            </div>
                            <input type="text" name="image" class="form-control" placeholder="URL Gambar (opsional)" value="{{ old('image', $blogPost->image) }}">
                        </div>
                        <div class="custom-file">
                            <input type="file" name="image_file" class="custom-file-input @error('image_file') is-invalid @enderror" id="image_file" accept="image/*">
                            <label class="custom-file-label" for="image_file">Ganti gambar...</label>
                            @error('image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">Pilih salah satu: isi URL atau upload file.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Avatar Penulis</label>
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ old('author_avatar', $blogPost->author_avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?d=mp&s=100') }}" class="rounded-circle mr-2" style="width: 40px; height: 40px; object-fit: cover;" id="avatar_preview">
                            <span class="text-muted">Avatar saat ini</span>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                            </div>
                            <input type="text" name="author_avatar" class="form-control" placeholder="URL Avatar (opsional)" value="{{ old('author_avatar', $blogPost->author_avatar) }}">
                        </div>
                        <div class="custom-file">
                            <input type="file" name="author_avatar_file" class="custom-file-input @error('author_avatar_file') is-invalid @enderror" id="author_avatar_file" accept="image/*">
                            <label class="custom-file-label" for="author_avatar_file">Ganti avatar...</label>
                            @error('author_avatar_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">Pilih salah satu: isi URL atau upload file.</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ old('is_published', $blogPost->is_published) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_published">Publish</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 600px !important;
        max-height: 800px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
// Update custom-file label on file select
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);

    // Update avatar preview if author_avatar_file changed
    if (this.id === 'author_avatar_file' && this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#avatar_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);

                fetch('{{ route('admin.upload-image') }}', {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.url) {
                        resolve({ default: result.url });
                    } else {
                        reject(result.error || 'Upload gagal');
                    }
                })
                .catch(error => {
                    reject('Upload gagal: ' + error);
                });
            }));
    }

    abort() {}
}

function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

ClassicEditor
    .create(document.querySelector('#editor'), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'uploadImage', 'blockQuote', 'insertTable', '|',
                'undo', 'redo'
            ]
        },
        image: {
            toolbar: [
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                '|',
                'toggleImageCaption',
                'imageTextAlternative'
            ]
        }
    })
    .catch(error => {
        console.error(error);
    });
</script>
@endpush
