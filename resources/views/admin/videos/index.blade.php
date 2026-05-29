@extends('layouts.admin')
@section('title', 'Video')
@section('header_title', 'Manajemen Video')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Video</h2>
            <a href="{{ route('admin.videos.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Video
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.videos.index'), 'placeholder' => 'Cari judul video...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Judul</th><th>Status</th><th>Tanggal</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($videos as $video)
                    <tr>
                        <td class="td-title">{{ Str::limit($video->title, 60) }}</td>
                        <td>
                            @if($video->status->value === 'published')<span class="badge badge-success">Terbit</span>
                            @else<span class="badge badge-muted">Draft</span>@endif
                        </td>
                        <td class="td-muted">{{ $video->created_at->format('d M Y') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada video.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $videos->links('vendor.pagination.admin') }}
</div>
@endsection
