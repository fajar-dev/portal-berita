@if(count($comments) > 0)
    @foreach($comments as $comment)
        <div class="comment-item">
            <div class="comment-header">
                <span class="comment-author">{{ $comment['name'] }}</span>
                <span class="comment-date">{{ $comment['date'] }}</span>
            </div>
            <div class="comment-body">
                {!! nl2br(e($comment['body'])) !!}
            </div>
        </div>
    @endforeach
@else
    <div class="empty-comments-state" style="text-align: center; padding: 30px; color: var(--color-text-muted); font-size: 0.9rem;">
        Belum ada komentar. Jadilah yang pertama memberikan tanggapan!
    </div>
@endif
