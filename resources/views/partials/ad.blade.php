@if(isset($globalAds) && isset($globalAds[$position]))
    <div class="ad-container ad-{{ $position }}" style="margin: 20px 0; text-align: center;">
        @foreach($globalAds[$position] as $ad)
            @php
                // Tentukan ukuran maksimal berdasarkan posisi
                $maxHeight = ($position === 'sidebar') ? '250px' : '100px';
                $objectFit = ($position === 'sidebar') ? 'contain' : 'cover';
                $width = ($position === 'sidebar') ? '100%' : '100%';
            @endphp
            <a href="{{ $ad->target_url }}" target="_blank" rel="nofollow noopener" style="display: block; position: relative; max-width: 800px; margin: 0 auto; overflow: hidden; border-radius: var(--border-radius-sm); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                <span style="position: absolute; top: 0; right: 0; background: rgba(0,0,0,0.6); color: #fff; font-size: 0.65rem; padding: 3px 8px; border-bottom-left-radius: 6px; z-index: 10;">IKLAN</span>
                <img class="lazy-image" data-src="{{ asset($ad->image_url) }}" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="{{ $ad->title }}" style="width: {{ $width }}; height: {{ $maxHeight }}; object-fit: {{ $objectFit }}; display: block;">
            </a>
        @endforeach
    </div>
@endif
