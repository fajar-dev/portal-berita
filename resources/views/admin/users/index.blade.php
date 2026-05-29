@extends('layouts.admin')
@section('title', 'Pengguna')
@section('header_title', 'Manajemen Pengguna')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Pengguna</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.users.index'), 'placeholder' => 'Cari nama, email, username...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Nama</th><th>Email</th><th>Username</th><th>Role</th><th>Artikel</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="td-title">{{ $user->name }}</td>
                        <td class="td-secondary">{{ $user->email }}</td>
                        <td class="td-muted">{{ $user->username ?? '—' }}</td>
                        <td><span class="badge {{ $user->role === 'admin' ? 'badge-danger' : 'badge-info' }}">{{ ucfirst($user->role) }}</span></td>
                        <td class="td-num">{{ $user->articles_count }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada pengguna.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $users->links('vendor.pagination.admin') }}
</div>
@endsection
