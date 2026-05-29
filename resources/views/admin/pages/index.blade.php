@extends('layouts.admin')
@section('title', 'Halaman')
@section('header_title', 'Manajemen Halaman')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Halaman</h2>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Halaman
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.pages.index'), 'placeholder' => 'Cari judul halaman...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Judul</th><th>Slug</th><th>Status</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td class="td-title">{{ $page->title }}</td>
                        <td class="td-muted">/page/{{ $page->slug }}</td>
                        <td>@if($page->is_active)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-muted">Nonaktif</span>@endif</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Hapus halaman ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada halaman.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $pages->links('vendor.pagination.admin') }}
</div>
@endsection
