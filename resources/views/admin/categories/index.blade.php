@extends('layouts.admin')
@section('title', 'Kategori')
@section('header_title', 'Manajemen Kategori')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Kategori</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.categories.index'), 'placeholder' => 'Cari kategori...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Warna</th><th>Nama</th><th>Slug</th><th>Urutan</th><th>Artikel</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td><span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:{{ $cat->color }};"></span></td>
                        <td class="td-title">{{ $cat->name }}</td>
                        <td class="td-muted">{{ $cat->slug }}</td>
                        <td class="td-num">{{ $cat->order }}</td>
                        <td class="td-num">{{ $cat->articles_count }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-outline btn-sm">Edit</a>
                            @if($cat->articles_count === 0)
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">{{ request('q') ? 'Tidak ditemukan.' : 'Belum ada kategori.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $categories->links('vendor.pagination.admin') }}
</div>
@endsection
