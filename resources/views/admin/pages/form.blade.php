@extends('layouts.admin')
@section('title', isset($page) ? 'Edit Halaman' : 'Buat Halaman')
@section('header_title', isset($page) ? 'Edit Halaman' : 'Buat Halaman Baru')
@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
            @csrf
            @if(isset($page)) @method('PUT') @endif
            <div class="form-group"><label class="form-label">Judul</label><input type="text" name="title" class="form-control" value="{{ old('title', $page->title ?? '') }}" required></div>
            <div class="form-group">
                <label class="form-label">Konten</label>
                <textarea id="wysiwyg-editor" name="content">{{ old('content', $page->content ?? '') }}</textarea>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }} style="accent-color:var(--admin-primary);">
                <label style="font-weight:600;font-size:.9rem;">Aktifkan halaman</label>
            </div>
            <div style="display:flex;gap:12px;margin-top:24px;">
                <button type="submit" class="btn btn-primary">{{ isset($page) ? 'Simpan' : 'Buat Halaman' }}</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
Jodit.make('#wysiwyg-editor', {
    height: 400,
    toolbarAdaptive: false,
    showCharsCounter: false,
    showWordsCounter: true,
    showXPathInStatusbar: false,
    askBeforePasteHTML: false,
    askBeforePasteFromWord: false,
    defaultActionOnPaste: 'insert_clear_html',
    buttons: [
        'bold', 'italic', 'underline', 'strikethrough', '|',
        'font', 'fontsize', 'brush', '|',
        'paragraph', 'align', '|',
        'ul', 'ol', 'indent', 'outdent', '|',
        'image', 'video', 'table', 'link', 'hr', '|',
        'superscript', 'subscript', 'symbol', '|',
        'copyformat', 'eraser', '|',
        'source', 'fullsize', 'preview', 'print', '|',
        'undo', 'redo'
    ],
    uploader: {
        insertImageAsBase64URI: true,
    },
    style: {
        font: "'Plus Jakarta Sans', sans-serif",
        fontSize: '15px',
        lineHeight: '1.7',
        color: '#1e2330',
    },
});
</script>
@endpush
