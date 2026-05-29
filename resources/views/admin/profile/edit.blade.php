@extends('layouts.admin')
@section('title', 'Profil Saya')
@section('header_title', 'Profil Saya')

@push('styles')
<style>
    .profile-avatar-section {
        display: flex; align-items: center; gap: var(--sp-xl);
        padding-bottom: var(--sp-xl); margin-bottom: var(--sp-xl);
        border-bottom: 1px solid var(--admin-border-light);
    }
    .profile-avatar-wrap { position: relative; }
    .profile-avatar {
        width: 96px; height: 96px; border-radius: 50%;
        object-fit: cover; border: 3px solid var(--admin-border);
        background: var(--admin-surface-hover);
    }
    .profile-avatar-placeholder {
        width: 96px; height: 96px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: var(--admin-primary); color: #fff;
        font-size: 2rem; font-weight: 800;
        border: 3px solid var(--admin-border);
    }
    .profile-avatar-info { flex: 1; }
    .profile-avatar-name {
        font-family: var(--admin-font-heading);
        font-size: 1.15rem; font-weight: 700; margin-bottom: 2px;
    }
    .profile-avatar-email {
        font-size: var(--fs-sm); color: var(--admin-text-muted); margin-bottom: var(--sp-sm);
    }
    .profile-avatar-actions { display: flex; gap: var(--sp-sm); flex-wrap: wrap; }
    .section-divider {
        display: flex; align-items: center; gap: var(--sp-sm);
        margin: var(--sp-2xl) 0 var(--sp-xl);
        padding-bottom: var(--sp-md);
        border-bottom: 1px solid var(--admin-border-light);
    }
    .section-divider-icon {
        width: 28px; height: 28px; border-radius: var(--admin-radius-xs);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .section-divider-icon svg { width: 14px; height: 14px; }
    .section-divider-icon--info { background: var(--admin-primary-soft); color: var(--admin-primary); }
    .section-divider-icon--lock { background: var(--admin-warning-soft); color: var(--admin-warning); }
    .section-divider-title {
        font-family: var(--admin-font-heading);
        font-size: var(--fs-md); font-weight: 700;
    }
    @media (max-width: 768px) {
        .profile-avatar-section { flex-direction: column; text-align: center; }
        .profile-avatar-actions { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">

        {{-- Avatar Section --}}
        <div class="profile-avatar-section">
            <div class="profile-avatar-wrap">
                @if($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="profile-avatar">
                @else
                    <div class="profile-avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
            </div>
            <div class="profile-avatar-info">
                <div class="profile-avatar-name">{{ $user->name }}</div>
                <div class="profile-avatar-email">{{ $user->email }}</div>
                <div class="profile-avatar-actions">
                    <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Ganti Foto
                        <input type="file" id="avatarInput" accept="image/*" style="display:none;" onchange="document.getElementById('avatarForm').submit();">
                    </label>
                    @if($user->avatar)
                    <form action="{{ route('admin.profile.remove-avatar') }}" method="POST" onsubmit="return confirm('Hapus foto profil?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger-outline btn-sm">Hapus Foto</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Hidden avatar upload form --}}
        <form id="avatarForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf @method('PUT')
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="username" value="{{ $user->username }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="hidden" name="bio" value="{{ $user->bio }}">
            <input type="file" name="avatar" id="avatarFormFile">
        </form>

        {{-- Profile Info --}}
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="section-divider">
                <div class="section-divider-icon section-divider-icon--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="section-divider-title">Informasi Profil</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    @error('username')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3" placeholder="Tulis bio singkat tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                <div class="form-hint">Maks 500 karakter.</div>
            </div>

            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Profil
            </button>
        </form>

        {{-- Change Password --}}
        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf @method('PUT')

            <div class="section-divider">
                <div class="section-divider-icon section-divider-icon--lock">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div class="section-divider-title">Ubah Password</div>
            </div>

            <div class="form-group">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-control" required>
                @error('current_password')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                    <div class="form-hint">Minimal 8 karakter.</div>
                    @error('password')<div class="form-hint" style="color:var(--admin-danger);">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                </div>
            </div>

            <button type="submit" class="btn btn-outline">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Ubah Password
            </button>
        </form>

    </div>
</div>

@push('scripts')
<script>
    document.getElementById('avatarInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('avatarFormFile').files = dt.files;
            document.getElementById('avatarForm').submit();
        }
    });
</script>
@endpush
@endsection
