<div class="comment-item {{ $depth > 0 ? 'is-reply' : 'is-root' }}" id="comment-{{ $comment['id'] }}">
    <div class="comment-header" style="display: flex; align-items: center; gap: 12px;">
        @if(!empty($comment['avatar']))
            <img src="{{ $comment['avatar'] }}" alt="{{ $comment['name'] }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
        @else
            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--color-primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; flex-shrink: 0;">
                {{ strtoupper(substr($comment['name'], 0, 1)) }}
            </div>
        @endif
        <div style="flex: 1; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 5px;">
            <div style="display: flex; align-items: center; gap: 6px;">
                <span class="comment-author" style="font-size: 0.95rem;">{{ $comment['name'] }}</span>
                @if($comment['is_admin'] ?? false)
                    <span style="background: var(--color-primary); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: bold;">Admin</span>
                @endif
            </div>
            <span class="comment-date" style="font-size: 0.8rem; color: var(--color-text-muted);">{{ $comment['date'] }}</span>
        </div>
    </div>
    <div class="comment-body">
        {!! nl2br(e($comment['body'])) !!}
    </div>
    
    @auth
        @if(auth()->user()->is_admin ?? auth()->user()->role === 'admin')
        <div class="comment-actions" style="margin-top: 10px; margin-bottom: 15px;">
            <button class="reply-btn" data-id="{{ $comment['id'] }}" data-author="{{ $comment['name'] }}" style="background: none; border: none; color: var(--color-primary); font-size: 0.8rem; font-weight: 700; cursor: pointer; padding: 0;">
                <svg style="width: 12px; height: 12px; display: inline-block; margin-right: 3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                Balas
            </button>
        </div>
        @endif
    @endauth
    
    @if(isset($comment['replies']) && count($comment['replies']) > 0)
        <div class="comment-replies">
            @foreach($comment['replies'] as $reply)
                @include('partials.comment_item', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>
