{{--
    Reusable CKEditor partial.
    Usage: @include('admin.partials.ckeditor', ['selector' => '#editor'])
--}}
@push('styles')
<style>
    .ck-editor__editable {
        min-height: 350px !important;
        max-height: 600px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
class MyUploadAdapter {
    constructor(loader) { this.loader = loader; }
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', file);
            fetch('{{ route('admin.upload-image') }}', {
                method: 'POST',
                body: data,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(r => r.json())
            .then(result => result.url ? resolve({ default: result.url }) : reject(result.error || 'Upload gagal'))
            .catch(err => reject('Upload gagal: ' + err));
        }));
    }
    abort() {}
}
function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = loader => new MyUploadAdapter(loader);
}
ClassicEditor.create(document.querySelector('{{ $selector ?? '#editor' }}'), {
    extraPlugins: [MyCustomUploadAdapterPlugin],
    toolbar: {
        items: ['heading','|','bold','italic','link','|','bulletedList','numberedList','|','uploadImage','blockQuote','insertTable','|','undo','redo']
    },
    image: {
        toolbar: ['imageStyle:inline','imageStyle:block','imageStyle:side','|','toggleImageCaption','imageTextAlternative']
    }
}).then(editor => { window.editorInstance = editor; }).catch(console.error);
</script>
@endpush
