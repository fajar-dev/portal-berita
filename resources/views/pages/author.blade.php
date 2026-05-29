@extends('layouts.portal')

@section('title', 'Profil Jurnalis: ' . $author['name'] . ' - ' . \App\Models\Setting::get('site_name', 'NusaKini'))
@section('meta_description', 'Kumpulan artikel liputan investigatif dan analisis berita eksklusif oleh jurnalis tepercaya ' . \App\Models\Setting::get('site_name', 'NusaKini') . ': ' . $author['name'])

@section('content')

    <!-- Premium Profile Header Box -->
    <div class="author-profile-header">
        <img data-src="{{ $author['avatar'] }}" alt="{{ $author['name'] }}" class="author-profile-header-avatar lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
        
        <div style="display: block;">
            <h1 class="author-profile-header-name">
                {{ $author['name'] }}
                <span class="verified-badge">
                    <svg style="width: 10px; height: 10px; fill: currentColor;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    VERIFIED JURNALIS
                </span>
            </h1>
        </div>

        <div class="author-profile-header-role">
            Redaktur Liputan Utama {{ \App\Models\Setting::get('site_name', 'NusaKini') }}
        </div>

        <p style="font-size: 0.95rem; color: var(--color-text-muted); max-width: 650px; margin: 15px auto; line-height: 1.6;">
            {{ $author['bio'] }}
        </p>

        <!-- Stats details -->
        <div class="author-profile-header-stats">
            <div class="stat-item">
                <div class="stat-number">{{ number_format($totalViews) }}</div>
                <div class="stat-label">Total Pembaca</div>
            </div>
            <div class="stat-item" style="border-left: 1px solid var(--color-border); border-right: 1px solid var(--color-border); padding: 0 30px;">
                <div class="stat-number">{{ $totalArticles }}</div>
                <div class="stat-label">Artikel Terbit</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Kredibilitas Skor</div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout Grid -->
    <div class="portal-main-grid">
        
        <!-- Left Column: Author Article Archives Feed -->
        <div class="main-left-column">
            
            <div class="section-header">
                <h3 class="section-title">Semua Karya <span>Tulis</span></h3>
                <span style="font-size: 0.8rem; color: var(--color-text-muted); font-weight: 700; text-transform: uppercase;">{{ $author['name'] }}</span>
            </div>

            <div class="news-grid grid-2">
                @if(isset($authorArticles) && count($authorArticles) > 0)
                    @foreach($authorArticles as $item)
                        <article class="news-card">
                            <div class="card-image-wrap lazy-image-wrap">
                                <span class="category-tag" style="background:{{ $item['category_color'] }};">{{ $item['category'] }}</span>
                                <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                            </div>
                            <div class="card-content">
                                <div class="article-meta">
                                    <span>{{ $item['date'] }}</span>
                                    <span>•</span>
                                    <span>{{ $item['read_time'] }}</span>
                                </div>
                                <h4 class="card-title">
                                    <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                </h4>
                                <p class="card-excerpt">
                                    {{ $item['excerpt'] }}
                                </p>
                                <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more" style="margin-top: auto;">Baca Berita →</a>
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>

        </div>

        <!-- Right Column: Sidebar widgets inclusion -->
        <aside class="main-right-column">
            @include('partials.sidebar')
        </aside>

    </div>

@endsection
