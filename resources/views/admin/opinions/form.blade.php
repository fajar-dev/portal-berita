@extends('layouts.admin')
@section('title', isset($opinion) ? 'Edit Opini' : 'Tambah Opini')
@section('header_title', isset($opinion) ? 'Edit Opini' : 'Tambah Opini')

@section('content')
<div class="card">
    <div class="card-header"><h2>{{ isset($opinion) ? 'Edit Opini' : 'Tambah Opini Baru' }}</h2></div>
    <div class="card-body">
        <form action="{{ isset($opinion) ? route('admin.opinions.update', $opinion) : route('admin.opinions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($opinion)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Judul Opini</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $opinion->title ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Ringkasan / Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="4" required>{{ old('excerpt', $opinion->excerpt ?? '') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nama Penulis</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $opinion->author ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan / Peran</label>
                    <input type="text" name="role" class="form-control" value="{{ old('role', $opinion->role ?? '') }}" placeholder="Contoh: Pakar Ekonomi" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Foto Penulis</label>
                    @if(isset($opinion) && $opinion->author_avatar)
                        <div style="margin-bottom:10px;">
                            <img src="{{ asset($opinion->author_avatar) }}" alt="Avatar" style="width:64px;height:64px;border-radius:50%;object-fit:cover;border:1px solid var(--admin-border);">
                        </div>
                    @endif
                    <input type="file" name="author_avatar" class="form-control" accept="image/*">
                    <div class="form-hint">Foto profil penulis (opsional). JPG/PNG.{{ isset($opinion) ? ' Kosongkan jika tidak ingin mengganti.' : '' }}</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Publikasi</label>
                    <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $opinion->published_date ?? now()->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="published" {{ old('status', $opinion->status->value ?? '') === 'published' ? 'selected' : '' }}>Terbit</option>
                    <option value="draft" {{ old('status', $opinion->status->value ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary">{{ isset($opinion) ? 'Simpan Perubahan' : 'Tambah Opini' }}</button>
                <a href="{{ route('admin.opinions.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
