@extends('layouts.admin')
@section('title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel')
@section('header_title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru')

@push('styles')
<style>
    .tag-picker { display: flex; flex-wrap: wrap; gap: var(--sp-sm); margin-bottom: var(--sp-sm); }
    .tag-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; border-radius: 20px;
        font-size: var(--fs-sm); font-weight: 600;
        background: var(--admin-primary-soft); color: var(--admin-primary);
        cursor: pointer; transition: var(--admin-transition);
        border: 1px solid transparent; user-select: none;
    }
    .tag-chip:hover { border-color: var(--admin-primary); }
    .tag-chip.active {
        background: var(--admin-primary); color: #fff;
        border-color: var(--admin-primary);
    }
    .tag-chip.active svg { color: rgba(255,255,255,.7); }
    .tag-chip svg { width: 12px; height: 12px; color: var(--admin-primary); flex-shrink: 0; }
    .tag-new-wrap {
        display: flex; gap: var(--sp-sm); align-items: center;
    }
    .tag-new-input {
        padding: 5px 12px; border: 1px dashed var(--admin-border);
        border-radius: 20px; font-size: var(--fs-sm);
        font-family: var(--admin-font); background: var(--admin-surface);
        color: var(--admin-text); width: 160px;
        transition: var(--admin-transition);
    }
    .tag-new-input:focus {
        outline: none; border-color: var(--admin-primary);
        border-style: solid;
    }
    .tag-new-btn {
        padding: 5px 12px; border-radius: 20px;
        font-size: var(--fs-sm); font-weight: 600;
        background: var(--admin-success-soft); color: var(--admin-success);
        border: 1px solid transparent; cursor: pointer;
        transition: var(--admin-transition);
    }
    .tag-new-btn:hover { background: var(--admin-success); color: #fff; }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($article)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Judul Artikel</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}" required placeholder="Masukkan judul artikel...">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" {{ old('status', isset($article) ? $article->status->value : '') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', isset($article) ? $article->status->value : '') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>

            {{-- Tag Picker --}}
            <div class="form-group">
                <label class="form-label">Tag</label>
                <div class="tag-picker" id="tagPicker">
                    @foreach($tags as $tag)
                        <label class="tag-chip {{ in_array($tag->id, $selectedTags) ? 'active' : '' }}">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }} style="display:none;" onchange="this.parentElement.classList.toggle('active')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
                <div class="tag-new-wrap">
                    <input type="text" id="newTagInput" class="tag-new-input" placeholder="Buat tag baru...">
                    <button type="button" class="tag-new-btn" onclick="addNewTag()">+ Tambah</button>
                </div>
                <div class="form-hint" style="margin-top:var(--sp-xs);">Klik tag untuk memilih. Buat tag baru jika belum tersedia.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Utama</label>
                @if(isset($article) && $article->image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset($article->image) }}" alt="Preview" style="max-height:120px;border-radius:8px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <div class="form-hint">Format JPG, PNG, WebP. Maks 2MB.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Konten</label>
                <textarea id="wysiwyg-editor" name="content">{{ old('content', $article->content ?? '') }}</textarea>
            </div>

            <div style="display:flex;gap:12px;margin-top:28px;">
                <button type="submit" class="btn btn-primary">{{ isset($article) ? 'Simpan Perubahan' : 'Terbitkan Artikel' }}</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const editor = Jodit.make('#wysiwyg-editor', {
        height: 450,
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

    function addNewTag() {
        const input = document.getElementById('newTagInput');
        const name = input.value.trim();
        if (!name) return;

        // Create hidden input for new tag name
        const picker = document.getElementById('tagPicker');
        const chip = document.createElement('label');
        chip.className = 'tag-chip active';
        chip.innerHTML = `
            <input type="checkbox" name="new_tags[]" value="${name}" checked style="display:none;" onchange="this.parentElement.classList.toggle('active')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            ${name}
        `;
        picker.appendChild(chip);
        input.value = '';
        input.focus();
    }

    document.getElementById('newTagInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); addNewTag(); }
    });
</script>
@endpush
