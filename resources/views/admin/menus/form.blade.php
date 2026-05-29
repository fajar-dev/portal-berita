@extends('layouts.admin')
@section('title', isset($menu) ? 'Edit Menu' : 'Tambah Menu')
@section('header_title', isset($menu) ? 'Edit Menu' : 'Tambah Menu')
@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ isset($menu) ? route('admin.menus.update', $menu) : route('admin.menus.store') }}" method="POST">
            @csrf
            @if(isset($menu)) @method('PUT') @endif
            <div class="form-group"><label class="form-label">Nama Menu</label><input type="text" name="name" class="form-control" value="{{ old('name', $menu->name ?? '') }}" required></div>
            <div class="form-group"><label class="form-label">URL</label><input type="text" name="url" class="form-control" value="{{ old('url', $menu->url ?? '') }}" required placeholder="/category/politik-hukum"></div>
            <div class="form-group">
                <label class="form-label">Parent Menu (Opsional)</label>
                <select name="parent_id" class="form-control">
                    <option value="">— Tidak ada (Menu Utama) —</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="order" class="form-control" value="{{ old('order', $menu->order ?? 0) }}" min="0"></div>
                <div class="form-group" style="display:flex;align-items:end;gap:8px;padding-bottom:4px;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menu->is_active ?? true) ? 'checked' : '' }} style="accent-color:var(--admin-primary);width:16px;height:16px;">
                    <label style="font-weight:600;font-size:.9rem;">Aktif</label>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">{{ isset($menu) ? 'Simpan' : 'Tambah Menu' }}</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
