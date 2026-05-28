@extends('layouts.portal')

@section('title', $article['title'] . ' - NusaKini')
@section('meta_description', $article['excerpt'])
@section('og_type', 'article')
@section('og_image', asset($article['image']))

@section('schema_json_ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ addslashes($article['title']) }}",
  "image": [
    "{{ asset($article['image']) }}"
  ],
  "datePublished": "{{ date('c', strtotime($article['date'])) }}",
  "dateModified": "{{ date('c', strtotime($article['date'])) }}",
  "author": [{
      "@type": "Person",
      "name": "{{ $article['author'] }}",
      "url": "{{ route('news.author', str_replace('.', '-', $article['author_username'])) }}"
    }],
  "publisher": {
    "@type": "Organization",
    "name": "NusaKini",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('favicon.ico') }}"
    }
  },
  "description": "{{ addslashes($article['excerpt']) }}"
}
</script>
@endsection

@section('progress_bar')
    <!-- Smooth Reading Progress Bar Indicator at top -->
    <div class="reading-progress-container">
        <div id="reading-progress-bar" class="reading-progress-bar"></div>
    </div>
@endsection

@section('content')

    <div class="portal-main-grid">
        
        <!-- Left Column: Rich Article Reading Content -->
        <div class="main-left-column">
            
            <article class="article-container">
                <!-- Article Header Context -->
                <div class="article-header" data-slug="{{ $article['slug'] }}">
                    
                    <a href="{{ route('news.category', strtolower(str_replace(' & ', '-', $article['category']))) }}" class="article-category">
                        {{ $article['category'] }}
                    </a>
                    
                    <h1 class="article-title-main">{{ $article['title'] }}</h1>
                    
                    <!-- Metadata Info Row -->
                    <div class="article-info-bar">
                        
                        <div class="author-meta-block">
                            <img data-src="{{ $article['author_avatar'] }}" alt="{{ $article['author'] }}" class="author-meta-avatar lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                            <div>
                                <a href="{{ route('news.author', str_replace('.', '-', $article['author_username'])) }}" class="author-meta-name">
                                    {{ $article['author'] }}
                                </a>
                                <div style="font-size: 0.72rem; color: var(--color-text-muted); font-weight: 500; margin-top: 2px;">
                                    Diterbitkan {{ $article['date'] }} <span>•</span> Waktu Baca: {{ $article['read_time'] }}
                                </div>
                            </div>
                        </div>

                        <!-- Actions (Bookmark & Shares) -->
                        <div class="article-social-shares">
                            <!-- Premium Interactive Save Button -->
                            <button id="btn-bookmark-trigger" class="btn-bookmark" 
                                    data-slug="{{ $article['slug'] }}"
                                    data-title="{{ $article['title'] }}"
                                    data-category="{{ $article['category'] }}"
                                    data-date="{{ $article['date'] }}"
                                    data-image="{{ $article['image'] }}"
                                    data-author="{{ $article['author'] }}">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                <span class="btn-text">Simpan Artikel</span>
                            </button>
                            
                            <!-- WhatsApp Share -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . ' - ' . request()->url()) }}" target="_blank" class="btn-share" aria-label="Bagikan ke WhatsApp">
                                <svg style="width: 14px; height: 14px; color: #25d366; fill: currentColor;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.003-2.637-1.017-5.114-2.873-6.973-1.857-1.859-4.327-2.882-6.963-2.883-5.438 0-9.864 4.417-9.868 9.861-.002 1.773.475 3.503 1.38 5.045L1.87 22.1l4.777-1.946zM17.52 14.22c-.324-.162-1.92-.949-2.216-1.055-.296-.108-.513-.162-.73.162-.216.324-.838 1.055-1.027 1.27-.189.216-.378.243-.702.08-2.63-1.318-4.354-2.937-5.321-4.604-.256-.441.256-.409.73-.356.175.02.324.037.424.06.324.075.405.162.486.324.08.162.324.78.351.838.027.054.054.108.081.162.243.486-.243.676-.486.919-.243.243-.486.405-.243.649.324.324 1.756 1.756 3.81 3.594 1.34 1.199 2.502 1.622 3.23 1.622.784 0 1.216-.405 1.405-.649.189-.243.324-.54.324-.865 0-.324-.162-.513-.486-.676z" />
                                </svg>
                            </a>
                            
                            <!-- Twitter/X Share -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article['title'] . ' - ' . request()->url()) }}" target="_blank" class="btn-share" aria-label="Bagikan ke Twitter">
                                <svg style="width: 13px; height: 13px; fill: currentColor;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                        </div>

                    </div>

                </div>

                <!-- Main Featured Article Image -->
                <div style="border-radius: var(--border-radius-md); overflow: hidden; margin-bottom: 30px; box-shadow: var(--shadow-sm); border:1px solid var(--color-border);">
                    <img data-src="{{ $article['image'] }}" alt="{{ $article['title'] }}" style="width: 100%; display: block; object-fit: cover;" class="lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                </div>

                <!-- Rich Format Article Body -->
                <div class="article-rich-content">
                    {!! $article['content'] !!}
                </div>

                <!-- Clickable Editorial Tag Badges -->
                @if(isset($article['tags']) && count($article['tags']) > 0)
                    <div class="article-tags-badges" style="margin-top: 35px; padding-top: 20px; border-top: 1px dashed var(--color-border); display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                        <span style="font-size: 0.78rem; font-weight: 800; color: var(--color-dark); text-transform: uppercase; margin-right: 5px; letter-spacing: 0.5px;">Topik:</span>
                        @foreach($article['tags'] as $tag)
                            <a href="{{ route('news.tag', $tag['slug']) }}" class="tag-badge-link" style="font-size: 0.72rem; font-weight: 700; color: var(--color-text-muted); background-color: var(--color-light); border: 1px solid var(--color-border); padding: 5px 12px; border-radius: var(--border-radius-pill); text-decoration: none; transition: var(--transition-smooth);">
                                #{{ $tag['name'] }}
                            </a>
                        @endforeach
                    </div>
                @endif

            </article>

            <!-- ==========================================================================
               Reactions Widget (Soft feedback buttons backed by localStorage)
               ========================================================================== -->
            <div class="reactions-box">
                <h4 class="reactions-title">Bagaimana reaksi Anda terhadap artikel ini?</h4>
                <div class="reactions-flex">
                    <button class="reaction-btn" data-reaction="suka">
                        <span>👍 Suka</span>
                        <span class="reaction-count">{{ $article['reactions']['suka'] }}</span>
                    </button>
                    <button class="reaction-btn" data-reaction="terkejut">
                        <span>😮 Terkejut</span>
                        <span class="reaction-count">{{ $article['reactions']['terkejut'] }}</span>
                    </button>
                    <button class="reaction-btn" data-reaction="inspiratif">
                        <span>💡 Inspiratif</span>
                        <span class="reaction-count">{{ $article['reactions']['inspiratif'] }}</span>
                    </button>
                    <button class="reaction-btn" data-reaction="sedih">
                        <span>😢 Sedih</span>
                        <span class="reaction-count">{{ $article['reactions']['sedih'] }}</span>
                    </button>
                </div>
            </div>

            <!-- ==========================================================================
               Author Profile Card
               ========================================================================== -->
            <div class="author-profile-card">
                <img data-src="{{ $article['author_avatar'] }}" alt="{{ $article['author'] }}" class="author-profile-avatar lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                <div class="author-profile-content">
                    <h4 class="author-profile-name">
                        Ditulis Oleh: <a href="{{ route('news.author', str_replace('.', '-', $article['author_username'])) }}">{{ $article['author'] }}</a>
                        <span class="verified-badge" style="margin-left: 5px;">
                            <svg style="width:9px; height:9px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6.267 3.455a.75.75 0 00-.708-.522 6.002 6.002 0 00-4.7 4.7.75.75 0 00.522.708l1.458.365a3.75 3.75 0 012.723 2.723l.365 1.458a.75.75 0 00.708.522 6.002 6.002 0 004.7-4.7.75.75 0 00-.522-.708l-1.458-.365a3.75 3.75 0 01-2.723-2.723l-.365-1.458zm5.556 12.186a.75.75 0 00.708.522 6.002 6.002 0 004.7-4.7.75.75 0 00-.522-.708l-1.458-.365a3.75 3.75 0 01-2.723-2.723l-.365-1.458a.75.75 0 00-.708-.522 6.002 6.002 0 00-4.7 4.7.75.75 0 00.522.708l1.458.365a3.75 3.75 0 012.723 2.723l.365 1.458z" clip-rule="evenodd" />
                            </svg>
                            Jurnalis Verified
                        </span>
                    </h4>
                    <p class="author-profile-bio">
                        {{ $article['author_bio'] }}
                    </p>
                </div>
            </div>

            <!-- Inline Advertisement Space -->
            @include('partials.ad', ['position' => 'article_inline'])

            <!-- ==========================================================================
               Comments Widget Section (Interactive & Persistent in localStorage)
               ========================================================================== -->
            <div class="comments-widget">
                <h3 id="comments-count-header" class="section-title" style="font-size:1.3rem; margin-bottom: 25px;">
                    Komentar ({{ $article['comments_count'] }})
                </h3>

                <!-- Comments List Container (Lazy Loaded via AJAX) -->
                <div class="comments-list" id="comments-ajax-container" data-slug="{{ $article['slug'] }}">
                    <!-- Skeleton Loader -->
                    <div class="skeleton-loader-container">
                        <div class="skeleton-comment-item">
                            <div class="skeleton-header"></div>
                            <div class="skeleton-body"></div>
                        </div>
                        <div class="skeleton-comment-item">
                            <div class="skeleton-header"></div>
                            <div class="skeleton-body" style="width: 80%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Comment Form -->
                <div class="comment-form">
                    <h4 style="font-family:var(--font-heading); font-size:1.15rem; border-bottom:1px solid var(--color-border); padding-bottom:10px; margin-bottom:20px;">
                        Tinggalkan Umpan Balik / Komentar
                    </h4>
                    <form id="article-comment-form" data-slug="{{ $article['slug'] }}">
                        <div class="comment-input-row">
                            <input type="text" id="comment-name" class="comment-input-field" placeholder="Nama lengkap Anda..." required>
                            <input type="email" id="comment-email" class="comment-input-field" placeholder="Alamat email Anda..." required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <textarea id="comment-body" class="comment-input-field" style="min-height: 120px; resize: vertical;" placeholder="Tulis komentar/opini cerdas Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="comment-submit-btn">Kirim Komentar</button>
                    </form>
                </div>

            </div>

            <!-- ==========================================================================
               Related Articles Section (Dynamic recommendations grid)
               ========================================================================== -->
            @if(isset($related) && count($related) > 0)
                <div style="margin-top: 50px;">
                    <div class="section-header">
                        <h3 class="section-title" style="font-size:1.3rem;">Rekomendasi <span>Terkait</span></h3>
                    </div>
                    <div class="news-grid grid-3">
                        @foreach($related as $item)
                            <article class="news-card">
                                <div class="card-image-wrap lazy-image-wrap" style="padding-top: 55%;">
                                    <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                                </div>
                                <div class="card-content" style="padding: 15px;">
                                    <div class="article-meta" style="font-size: 0.7rem; margin-bottom: 6px;">
                                        <span>{{ $item['date'] }}</span>
                                    </div>
                                    <h4 class="card-title" style="font-size: 0.95rem; line-height: 1.4;">
                                        <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                    </h4>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: Sidebar Widgets Inclusion -->
        <aside class="main-right-column">
            @include('partials.sidebar')
        </aside>

    </div>

@endsection
