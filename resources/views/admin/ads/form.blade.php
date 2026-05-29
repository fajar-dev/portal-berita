@extends('layouts.admin')
@section('title', 'Edit Iklan')
@section('header_title', 'Edit Iklan')

@section('content')
<div style="margin-bottom:var(--sp-lg);">
    <a href="{{ route('admin.ads.index') }}" class="btn btn-outline btn-sm">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Edit Iklan — <span style="color:var(--admin-primary);">{{ ucwords(str_replace('_', ' ', $ad->position->value ?? $ad->position)) }}</span></h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ads.update', $ad) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Judul / Label Iklan</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $ad->title) }}" required>
                @error('title')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Banner</label>
                @if($ad->image_url)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset($ad->image_url) }}" alt="Preview" style="max-height:160px;border-radius:var(--admin-radius-sm);border:1px solid var(--admin-border);">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <div class="form-hint">Format JPG, PNG, GIF, WebP. Maks 2MB. Kosongkan jika tidak ingin mengganti.</div>
                @error('image')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Target URL (Link Tujuan)</label>
                <input type="text" name="target_url" class="form-control" value="{{ old('target_url', $ad->target_url) }}" placeholder="https://..." required>
            </div>

            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $ad->is_active) ? 'checked' : '' }} style="accent-color:var(--admin-primary);width:16px;height:16px;">
                    <span class="form-label" style="margin:0;">Tampilkan iklan ini di website</span>
                </label>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.ads.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
