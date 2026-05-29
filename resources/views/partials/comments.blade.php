@if(count($comments) > 0)
    @foreach($comments as $comment)
        @include('partials.comment_item', ['comment' => $comment, 'depth' => 0])
    @endforeach
@else
    <div class="empty-comments-state" style="text-align: center; padding: 30px; color: var(--color-text-muted); font-size: 0.9rem;">
        Belum ada komentar. Jadilah yang pertama memberikan tanggapan!
    </div>
@endif
