@extends('layouts.admin')
@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('header_title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru')
@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
            @csrf
            @if(isset($user)) @method('PUT') @endif
            <div class="form-group"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required></div>
                <div class="form-group"><label class="form-label">Username</label><input type="text" name="username" class="form-control" value="{{ old('username', $user->username ?? '') }}" required></div>
            </div>
            <div class="form-group"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->bio ?? '') }}</textarea></div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="author" {{ old('role', $user->role ?? 'author') === 'author' ? 'selected' : '' }}>Author</option>
                    <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <div class="form-hint">Admin: akses penuh. Author: hanya konten & interaksi.</div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}</label><input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }} minlength="8"></div>
                <div class="form-group"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}></div>
            </div>
            <div style="display:flex;gap:12px;margin-top:24px;">
                <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Simpan' : 'Tambah Pengguna' }}</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
