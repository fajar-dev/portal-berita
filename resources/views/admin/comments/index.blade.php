@extends('layouts.admin')
@section('title', 'Komentar')
@section('header_title', 'Manajemen Komentar')

@push('styles')
<style>
    .comment-card {
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius);
        margin-bottom: var(--sp-md);
        overflow: hidden;
    }
    .comment-main {
        padding: var(--sp-lg);
        display: flex; gap: var(--sp-md);
    }
    .comment-avatar {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: var(--fs-sm); color: #fff;
        background: var(--admin-primary);
    }
    .comment-avatar--admin { background: var(--admin-success); }
    .comment-content { flex: 1; min-width: 0; }
    .comment-meta {
        display: flex; align-items: center; gap: var(--sp-sm);
        flex-wrap: wrap; margin-bottom: 4px;
    }
    .comment-name { font-weight: 700; font-size: var(--fs-base); }
    .comment-email { font-size: var(--fs-xs); color: var(--admin-text-muted); }
    .comment-date { font-size: var(--fs-xs); color: var(--admin-text-muted); }
    .comment-article {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: var(--fs-xs); color: var(--admin-info);
        background: var(--admin-info-soft); padding: 2px 8px;
        border-radius: var(--admin-radius-xs);
    }
    .comment-body {
        font-size: var(--fs-base); color: var(--admin-text-secondary);
        line-height: 1.6; margin-top: var(--sp-xs);
    }
    .comment-actions {
        display: flex; gap: var(--sp-xs); margin-top: var(--sp-sm);
    }
    .comment-replies {
        border-top: 1px solid var(--admin-border-light);
        background: var(--admin-surface-hover);
        padding: var(--sp-md) var(--sp-lg) var(--sp-md) 64px;
    }
    .reply-item {
        display: flex; gap: var(--sp-sm); margin-bottom: var(--sp-md);
    }
    .reply-item:last-child { margin-bottom: 0; }
    .reply-content { flex: 1; min-width: 0; }
    .reply-meta {
        display: flex; align-items: center; gap: var(--sp-sm);
        margin-bottom: 2px;
    }
    .reply-name { font-weight: 700; font-size: var(--fs-sm); }
    .reply-date { font-size: var(--fs-xs); color: var(--admin-text-muted); }
    .reply-body { font-size: var(--fs-sm); color: var(--admin-text-secondary); line-height: 1.5; }
    .reply-form-wrap {
        border-top: 1px solid var(--admin-border-light);
        background: var(--admin-surface-hover);
        padding: var(--sp-md) var(--sp-lg) var(--sp-md) 64px;
        display: none;
    }
    .reply-delete-form { display: inline; }
    @media (max-width: 768px) {
        .comment-replies, .reply-form-wrap { padding-left: var(--sp-lg); }
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Komentar Masuk</h2>
        @include('admin.partials.search', ['action' => route('admin.comments.index'), 'placeholder' => 'Cari nama, email, isi...'])
    </div>
    <div class="card-body" style="padding:var(--sp-lg);">
        @forelse($comments as $comment)
        <div class="comment-card">
            {{-- Parent Comment --}}
            <div class="comment-main">
                @if($comment->user && $comment->user->avatar)
                    <div class="comment-avatar" style="background: none;">
                        <img src="{{ asset($comment->user->avatar) }}" alt="{{ $comment->name }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
                    </div>
                @else
                    <div class="comment-avatar">{{ strtoupper(substr($comment->name, 0, 1)) }}</div>
                @endif
                <div class="comment-content">
                    <div class="comment-meta">
                        <span class="comment-name">{{ $comment->name }}</span>
                        <span class="comment-email">{{ $comment->email }}</span>
                        <span class="comment-date">{{ $comment->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($comment->article)
                    <a href="{{ route('news.detail', $comment->article->slug ?? '#') }}" target="_blank" class="comment-article">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/></svg>
                        {{ Str::limit($comment->article->title, 40) }}
                    </a>
                    @endif
                    <div class="comment-body">{{ $comment->body }}</div>
                    <div class="comment-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="toggleReply({{ $comment->id }})">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            Balas
                        </button>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="reply-delete-form" onsubmit="return confirm('Hapus komentar ini beserta semua balasan?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button>
                        </form>
                        @if($comment->replies->count())
                            <span style="font-size:var(--fs-xs);color:var(--admin-text-muted);display:flex;align-items:center;gap:4px;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-1"/></svg>
                                {{ $comment->replies->count() }} balasan
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Replies (hierarchy) --}}
            @if($comment->replies->count())
            <div class="comment-replies">
                @foreach($comment->replies as $reply)
                <div class="reply-item">
                    @if($reply->user && $reply->user->avatar)
                        <div class="comment-avatar" style="width:28px;height:28px;background:none;">
                            <img src="{{ asset($reply->user->avatar) }}" alt="{{ $reply->name }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
                        </div>
                    @else
                        <div class="comment-avatar {{ ($reply->user && $reply->user->role === 'admin') ? 'comment-avatar--admin' : '' }}" style="width:28px;height:28px;font-size:.65rem;">
                            {{ strtoupper(substr($reply->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="reply-content">
                        <div class="reply-meta">
                            <span class="reply-name">
                                {{ $reply->name }}
                                @if($reply->user && $reply->user->role === 'admin')
                                    <span class="badge badge-success" style="font-size:.6rem;padding:1px 6px;margin-left:2px;">Admin</span>
                                @endif
                            </span>
                            <span class="reply-date">{{ $reply->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="reply-body">{{ $reply->body }}</div>
                    </div>
                    <form action="{{ route('admin.comments.destroy', $reply) }}" method="POST" class="reply-delete-form" onsubmit="return confirm('Hapus balasan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--admin-danger);padding:2px 6px;" title="Hapus balasan">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Reply Form --}}
            <div class="reply-form-wrap" id="reply-{{ $comment->id }}">
                <form action="{{ route('admin.comments.reply', $comment) }}" method="POST" style="display:flex;gap:var(--sp-sm);align-items:flex-start;">
                    @csrf
                    <div class="comment-avatar comment-avatar--admin" style="width:28px;height:28px;font-size:.65rem;">A</div>
                    <textarea name="body" class="form-control" rows="2" placeholder="Tulis balasan sebagai Admin..." required style="flex:1;min-height:auto;font-size:var(--fs-sm);"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
                </form>
            </div>
        </div>
        @empty
            <div class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada komentar.' }}</div>
        @endforelse
    </div>
    {{ $comments->links('vendor.pagination.admin') }}
</div>
@endsection

@push('scripts')
<script>
    function toggleReply(id) {
        const el = document.getElementById('reply-' + id);
        if (el.style.display === 'none' || !el.style.display) {
            el.style.display = 'block';
            el.querySelector('textarea').focus();
        } else {
            el.style.display = 'none';
        }
    }
</script>
@endpush
