@extends('layouts.admin')
@section('title', 'Menu Navigasi')
@section('header_title', 'Menu Navigasi')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Menu Website</h2>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Menu
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.menus.index'), 'placeholder' => 'Cari nama menu...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Nama</th><th>URL</th><th>Urutan</th><th>Status</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td class="td-title">{{ $menu->name }}</td>
                        <td class="td-muted">{{ $menu->url }}</td>
                        <td class="td-num">{{ $menu->order }}</td>
                        <td>@if($menu->is_active)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-muted">Nonaktif</span>@endif</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Hapus menu ini beserta sub-menunya?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                    @foreach($menu->children as $child)
                    <tr>
                        <td class="td-secondary" style="padding-left:40px;">↳ {{ $child->name }}</td>
                        <td class="td-muted">{{ $child->url }}</td>
                        <td class="td-num">{{ $child->order }}</td>
                        <td>@if($child->is_active)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-muted">Nonaktif</span>@endif</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.menus.edit', $child) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.menus.destroy', $child) }}" method="POST" onsubmit="return confirm('Hapus sub-menu ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                    @endforeach
                @empty
                    <tr><td colspan="5" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada menu.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $menus->links('vendor.pagination.admin') }}
</div>
@endsection
