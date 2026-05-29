@extends('layouts.admin')
@section('title', 'Opini')
@section('header_title', 'Manajemen Opini')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Opini</h2>
            <a href="{{ route('admin.opinions.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Opini
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.opinions.index'), 'placeholder' => 'Cari judul atau penulis...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Judul</th><th>Penulis</th><th>Status</th><th>Tanggal</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($opinions as $opinion)
                    <tr>
                        <td class="td-title">{{ Str::limit($opinion->title, 50) }}</td>
                        <td>
                            <div class="td-secondary">{{ $opinion->author }}</div>
                            <div class="td-sub">{{ $opinion->role }}</div>
                        </td>
                        <td>
                            @if($opinion->status->value === 'published')<span class="badge badge-success">Terbit</span>
                            @else<span class="badge badge-muted">Draft</span>@endif
                        </td>
                        <td class="td-muted">{{ $opinion->published_date }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.opinions.edit', $opinion) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.opinions.destroy', $opinion) }}" method="POST" onsubmit="return confirm('Hapus opini ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada opini.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $opinions->links('vendor.pagination.admin') }}
</div>
@endsection
