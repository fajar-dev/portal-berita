@extends('layouts.admin')
@section('title', 'Infografis')
@section('header_title', 'Manajemen Infografis')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Infografis</h2>
            <a href="{{ route('admin.infographics.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Infografis
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.infographics.index'), 'placeholder' => 'Cari judul infografis...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Judul</th><th>Slug</th><th>Status</th><th>Tanggal</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($infographics as $ig)
                    <tr>
                        <td class="td-title">{{ Str::limit($ig->title, 50) }}</td>
                        <td class="td-muted">{{ $ig->slug }}</td>
                        <td>
                            @if($ig->status->value === 'published')<span class="badge badge-success">Terbit</span>
                            @else<span class="badge badge-muted">Draft</span>@endif
                        </td>
                        <td class="td-muted">{{ $ig->created_at->format('d M Y') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.infographics.edit', $ig) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.infographics.destroy', $ig) }}" method="POST" onsubmit="return confirm('Hapus infografis ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada infografis.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $infographics->links('vendor.pagination.admin') }}
</div>
@endsection
