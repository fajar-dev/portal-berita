@extends('layouts.admin')
@section('title', isset($video) ? 'Edit Video' : 'Tambah Video')
@section('header_title', isset($video) ? 'Edit Video' : 'Tambah Video')

@section('content')
<div class="card">
    <div class="card-header"><h2>{{ isset($video) ? 'Edit Video' : 'Tambah Video Baru' }}</h2></div>
    <div class="card-body">
        <form action="{{ isset($video) ? route('admin.videos.update', $video) : route('admin.videos.store') }}" method="POST">
            @csrf
            @if(isset($video)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Judul Video</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $video->title ?? '') }}" required>
                @error('title')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Link Embed (iframe)</label>
                <textarea name="iframe_link" class="form-control" rows="3" required placeholder="Paste embed code YouTube, contoh: https://www.youtube.com/embed/xxxxx">{{ old('iframe_link', $video->iframe_link ?? '') }}</textarea>
                <div class="form-hint">Paste URL embed YouTube atau kode iframe lengkap.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="published" {{ old('status', $video->status->value ?? '') === 'published' ? 'selected' : '' }}>Terbit</option>
                    <option value="draft" {{ old('status', $video->status->value ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary">{{ isset($video) ? 'Simpan Perubahan' : 'Tambah Video' }}</button>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
