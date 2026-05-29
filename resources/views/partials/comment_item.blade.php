<div class="comment-item {{ $depth > 0 ? 'is-reply' : 'is-root' }}" id="comment-{{ $comment['id'] }}">
    <div class="comment-header">
        <span class="comment-author">{{ $comment['name'] }}</span>
        <span class="comment-date">{{ $comment['date'] }}</span>
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
