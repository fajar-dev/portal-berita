@extends('layouts.admin')
@section('title', isset($infographic) ? 'Edit Infografis' : 'Tambah Infografis')
@section('header_title', isset($infographic) ? 'Edit Infografis' : 'Tambah Infografis')

@section('content')
<div class="card">
    <div class="card-header"><h2>{{ isset($infographic) ? 'Edit Infografis' : 'Tambah Infografis Baru' }}</h2></div>
    <div class="card-body">
        <form action="{{ isset($infographic) ? route('admin.infographics.update', $infographic) : route('admin.infographics.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($infographic)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Judul Infografis</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $infographic->title ?? '') }}" required>
                @error('title')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Infografis</label>
                @if(isset($infographic) && $infographic->image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset($infographic->image) }}" alt="Preview" style="max-height:180px;border-radius:var(--admin-radius-sm);border:1px solid var(--admin-border);">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" {{ isset($infographic) ? '' : 'required' }}>
                <div class="form-hint">Upload gambar infografis (JPG/PNG). Maks 5MB.{{ isset($infographic) ? ' Kosongkan jika tidak ingin mengganti.' : '' }}</div>
                @error('image')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="published" {{ old('status', $infographic->status->value ?? '') === 'published' ? 'selected' : '' }}>Terbit</option>
                    <option value="draft" {{ old('status', $infographic->status->value ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary">{{ isset($infographic) ? 'Simpan Perubahan' : 'Tambah Infografis' }}</button>
                <a href="{{ route('admin.infographics.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
