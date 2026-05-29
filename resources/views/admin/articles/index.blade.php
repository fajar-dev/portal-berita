@extends('layouts.admin')
@section('title', 'Artikel')
@section('header_title', 'Manajemen Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Artikel</h2>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tulis Artikel
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.articles.index'), 'placeholder' => 'Cari judul, kategori...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead>
                    <tr>
                        <th style="width:38%">Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th class="td-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            <div class="td-title">{{ Str::limit($article->title, 55) }}</div>
                            <div class="td-sub">{{ $article->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="td-secondary">{{ $article->user->name ?? '—' }}</td>
                        <td>
                            @if($article->category)
                                <span class="badge" style="background:{{ $article->category->color }}20;color:{{ $article->category->color }};">{{ $article->category->name }}</span>
                            @else
                                <span class="td-muted">—</span>
                            @endif
                        </td>
                        <td class="td-num">{{ number_format($article->views) }}</td>
                        <td>
                            @if($article->status->value === 'published')
                                <span class="badge badge-success">Terbit</span>
                            @else
                                <span class="badge badge-muted">Draft</span>
                            @endif
                        </td>
                        <td class="td-actions">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada artikel.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $articles->links('vendor.pagination.admin') }}
</div>
@endsection
