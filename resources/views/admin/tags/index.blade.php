@extends('layouts.admin')
@section('title', 'Tag')
@section('header_title', 'Manajemen Tag')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Tag</h2>
            <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Tag
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.tags.index'), 'placeholder' => 'Cari nama tag...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Nama</th><th>Slug</th><th>Artikel</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($tags as $tag)
                    <tr>
                        <td class="td-title">{{ $tag->name }}</td>
                        <td class="td-muted">{{ $tag->slug }}</td>
                        <td class="td-num">{{ $tag->articles_count }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada tag.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $tags->links('vendor.pagination.admin') }}
</div>
@endsection
