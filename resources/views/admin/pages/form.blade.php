@extends('layouts.admin')
@section('title', isset($page) ? 'Edit Halaman' : 'Buat Halaman')
@section('header_title', isset($page) ? 'Edit Halaman' : 'Buat Halaman Baru')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
<style>
    #gjs {
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius-sm);
        height: 600px;
        width: 100%;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form id="page-form" action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
            @csrf
            @if(isset($page)) @method('PUT') @endif
            <div class="form-group"><label class="form-label">Judul</label><input type="text" id="title-input" name="title" class="form-control" value="{{ old('title', $page->title ?? '') }}" required></div>
            <div class="form-group"><label class="form-label">Slug (URL)</label><input type="text" id="slug-input" name="slug" class="form-control" value="{{ old('slug', $page->slug ?? '') }}" required placeholder="contoh-halaman-baru">
                <small style="color: var(--admin-text-muted); font-size: 0.8rem; margin-top: 4px; display: block;">Slug akan otomatis terisi dari Judul, namun Anda bisa mengubahnya jika diperlukan.</small>
            </div>
            
            <input type="hidden" name="content" id="input-html">
            <input type="hidden" name="css" id="input-css">
            <input type="hidden" name="builder_data" id="input-builder-data">

            <div class="form-group" style="margin-top: 20px; margin-bottom: 20px;">
                <label class="form-label" style="margin-bottom: 10px; display: block;">Page Builder</label>
                <div id="gjs"></div>
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
<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>
<script>
const editor = grapesjs.init({
    container: '#gjs',
    height: '600px',
    width: 'auto',
    storageManager: false,
    plugins: ['gjs-blocks-basic'],
    pluginsOpts: {
        'gjs-blocks-basic': { flexGrid: true }
    },
});

// Load existing data if available
const savedData = `{!! addslashes(old('builder_data', $page->builder_data ?? '')) !!}`;
if (savedData) {
    try {
        editor.loadProjectData(JSON.parse(savedData));
    } catch (e) {
        console.error("Failed to load builder data", e);
    }
} else {
    // Fallback to load old HTML content if builder_data is empty
    const oldContent = `{!! addslashes(old('content', $page->content ?? '')) !!}`;
    if (oldContent) {
        editor.setComponents(oldContent);
    }
}

document.getElementById('page-form').addEventListener('submit', function(e) {
    document.getElementById('input-html').value = editor.getHtml();
    document.getElementById('input-css').value = editor.getCss();
    document.getElementById('input-builder-data').value = JSON.stringify(editor.getProjectData());
});

// Auto-generate slug from title if slug is empty or hasn't been manually edited heavily
const titleInput = document.getElementById('title-input');
const slugInput = document.getElementById('slug-input');
let slugEdited = false;

slugInput.addEventListener('input', function() {
    slugEdited = true;
});

titleInput.addEventListener('input', function() {
    if (!slugEdited && !'{{ isset($page) ? $page->id : '' }}') {
        let slug = this.value.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove non-word chars
            .replace(/[\s_-]+/g, '-') // Swap whitespace and underscores for hyphens
            .replace(/^-+|-+$/g, ''); // Trim hyphens
        slugInput.value = slug;
    }
});
</script>
@endpush
