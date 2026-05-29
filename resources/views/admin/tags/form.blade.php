@extends('layouts.admin')
@section('title', isset($tag) ? 'Edit Tag' : 'Tambah Tag')
@section('header_title', isset($tag) ? 'Edit Tag' : 'Tambah Tag')
@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ isset($tag) ? route('admin.tags.update', $tag) : route('admin.tags.store') }}" method="POST">
            @csrf
            @if(isset($tag)) @method('PUT') @endif
            <div class="form-group"><label class="form-label">Nama Tag</label><input type="text" name="name" class="form-control" value="{{ old('name', $tag->name ?? '') }}" required placeholder="Contoh: Ekonomi Digital"></div>
            <div style="display:flex;gap:12px;margin-top:24px;">
                <button type="submit" class="btn btn-primary">{{ isset($tag) ? 'Simpan' : 'Tambah Tag' }}</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
