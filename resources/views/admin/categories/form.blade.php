@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('header_title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru')
@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="form-row">
                <div class="form-group" style="flex:3;">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required placeholder="Contoh: Politik & Hukum">
                </div>
                <div class="form-group" style="flex:1;">
                    <label class="form-label">Warna</label>
                    <input type="color" name="color" class="form-control" value="{{ old('color', $category->color ?? '#2563eb') }}" style="height:40px;padding:4px;">
                </div>
                <div class="form-group" style="flex:1;">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $category->order ?? 0) }}" min="0">
                </div>
            </div>

            <div class="form-hint" style="margin-bottom:var(--sp-xl);">Slug otomatis di-generate dari nama. Warna digunakan untuk badge kategori di frontend.</div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Simpan' : 'Tambah Kategori' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
