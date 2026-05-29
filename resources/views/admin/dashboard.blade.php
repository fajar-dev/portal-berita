@extends('layouts.admin')
@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--admin-primary-soft);color:var(--admin-primary);">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['articles_count']) }}</div>
            <div class="stat-label">Total Artikel</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--admin-success-soft);color:var(--admin-success);">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['published_count']) }}</div>
            <div class="stat-label">Artikel Terbit</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--admin-info-soft);color:var(--admin-info);">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['users_count']) }}</div>
            <div class="stat-label">Pengguna</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--admin-warning-soft);color:var(--admin-warning);">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['comments_count']) }}</div>
            <div class="stat-label">Komentar</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Artikel Terbaru</h2>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th></tr></thead>
                <tbody>
                @forelse($recentArticles as $article)
                    <tr>
                        <td style="font-weight:600;">{{ Str::limit($article->title, 50) }}</td>
                        <td>{{ $article->category }}</td>
                        <td>
                            @if($article->status->value === 'published')
                                <span class="badge badge-success">Terbit</span>
                            @else
                                <span class="badge badge-muted">Draft</span>
                            @endif
                        </td>
                        <td style="color:var(--admin-text-muted);font-size:.85rem;">{{ $article->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">Belum ada artikel.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
