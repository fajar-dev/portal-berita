@extends('layouts.portal')

@section('title', 'NusaKini - Portal Berita Modern, Kredibel, & Tepercaya')

@section('content')

    <!-- ==========================================================================
           0. Modern Popular Tags Filter Clouds (Soft Pills Navbar Overlay)
           ========================================================================== -->
    <div
        style="margin-top: 25px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 4px 0;">
        <span
            style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.8px;">
            Topik Hangat:
        </span>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('news.search') }}?q=EBT"
                style="font-size: 0.78rem; font-weight: 700; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); padding: 5px 14px; border-radius: var(--border-radius-pill); color: var(--color-text);">#EnergiHijau</a>
            <a href="{{ route('news.search') }}?q=AI"
                style="font-size: 0.78rem; font-weight: 700; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); padding: 5px 14px; border-radius: var(--border-radius-pill); color: var(--color-text);">#KecerdasanBuatan</a>
            <a href="{{ route('news.search') }}?q=UMKM"
                style="font-size: 0.78rem; font-weight: 700; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); padding: 5px 14px; border-radius: var(--border-radius-pill); color: var(--color-text);">#EkonomiDigital</a>
            <a href="{{ route('news.search') }}?q=Olimpiade"
                style="font-size: 0.78rem; font-weight: 700; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); padding: 5px 14px; border-radius: var(--border-radius-pill); color: var(--color-text);">#SportScience</a>
            <a href="{{ route('news.search') }}?q=Badminton"
                style="font-size: 0.78rem; font-weight: 700; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); padding: 5px 14px; border-radius: var(--border-radius-pill); color: var(--color-text);">#BadmintonJunior</a>
        </div>
    </div>

    <!-- ==========================================================================
           1. Megah Headline Hero Grid (Main Headline & Secondary Stacks)
           ========================================================================== -->
    <div class="headline-hero-grid">

        <!-- Left Pillar: Primary Hero Headline -->
        @if(isset($headline))
            <div class="hero-primary-card">
                <div class="hero-image-wrap">
                    <span class="category-tag">{{ $headline['category'] }}</span>
                    <img data-src="{{ $headline['image'] }}" alt="{{ $headline['title'] }}" class="lazy-image"
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                </div>
                <div class="hero-primary-content">
                    <div class="article-meta">
                        <span class="article-author">{{ $headline['author'] }}</span>
                        <span>•</span>
                        <span>{{ $headline['date'] }}</span>
                        <span>•</span>
                        <span style="display: inline-flex; align-items: center; gap: 4px;">
                            <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            {{ $headline['read_time'] }}
                        </span>
                    </div>
                    <h2 class="hero-primary-title">
                        <a href="{{ route('news.detail', $headline['slug']) }}">{{ $headline['title'] }}</a>
                    </h2>
                    <p class="hero-primary-excerpt">
                        {{ $headline['excerpt'] }}
                    </p>
                    <a href="{{ route('news.detail', $headline['slug']) }}" class="btn-read-more">
                        Baca Selengkapnya
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        @endif

        <!-- Right Pillar: Stacked Secondary Headlines -->
        <div class="hero-secondary-stack">
            @if(isset($secondaryHeadlines) && count($secondaryHeadlines) > 0)
                @foreach($secondaryHeadlines as $item)
                    <a href="{{ route('news.detail', $item['slug']) }}" class="stacked-card">
                        <span class="stacked-category">
                            {{ $item['category'] }}
                        </span>
                        <div class="stacked-thumb">
                            <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image"
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                        </div>
                        <div class="stacked-content">
                            <h3 class="stacked-title">
                                {{ $item['title'] }}
                            </h3>
                            <div class="stacked-card-meta">
                                <span>{{ $item['date'] }}</span>
                                <span>•</span>
                                <span>{{ $item['read_time'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>

    </div>

    <!-- ==========================================================================
           2. Premium Column: Opini & Analisis Cendekiawan (New Section)
           ========================================================================== -->
    <div style="margin-bottom: 50px;">
        <div class="section-header">
            <h3 class="section-title">Opini & <span>Kolom</span></h3>
            <span
                style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Fokus
                Pemikiran</span>
        </div>

        <div class="opinions-grid">
            @if(isset($opinions) && count($opinions) > 0)
                @foreach($opinions as $opinion)
                    <div class="opinion-card">
                        <img data-src="{{ $opinion['author_avatar'] }}" alt="{{ $opinion['author'] }}"
                            class="opinion-author-avatar lazy-image"
                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                        <span class="opinion-author-name">{{ $opinion['author'] }}</span>
                        <span class="opinion-author-role">{{ $opinion['role'] }}</span>
                        <h4 class="opinion-title">{{ $opinion['title'] }}</h4>
                        <p class="opinion-excerpt">"{{ $opinion['excerpt'] }}"</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- ==========================================================================
           3. Multimedia Video & Stories Section (Dark Editorial Look)
           ========================================================================== -->
    </div> <!-- Close container for full-width dark background -->
    <div class="video-section">
        <div class="portal-container">
            <div class="section-header" style="border-bottom-color: rgba(255, 255, 255, 0.1);">
                <h2 class="section-title" style="color: #fff;">Laporan <span>Video</span></h2>
                <span
                    style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Eksklusif</span>
            </div>

            <div class="video-grid">
                @if(isset($videos) && count($videos) > 0)
                    @foreach($videos as $video)
                        <div class="video-card" data-iframe-link="{{ $video['iframe_link'] ?? '' }}">
                            <div class="video-thumb-wrap">
                                <iframe src="{{ $video['iframe_link'] ?? '' }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: var(--border-radius-sm);"></iframe>
                            </div>
                            <div class="video-content">
                                <h4 class="video-title">
                                    <a href="javascript:void(0);" class="open-video-modal">{{ $video['title'] }}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="portal-container"> <!-- Re-open container for standard layout -->

        <!-- Home Middle Advertisement Space -->
        @include('partials.ad', ['position' => 'home_middle'])

        <!-- ==========================================================================
           4. Visual Infographics Section (Horizontal Scrolling Archive) (New Section)
           ========================================================================== -->
        <div style="margin-bottom: 45px;">
            <div class="section-header">
                <h3 class="section-title">Infografis <span>Pilihan</span></h3>
                <span
                    style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Jurnalisme
                    Data</span>
            </div>

            <div class="infographics-scroll-container">
                @if(isset($infographics) && count($infographics) > 0)
                    @foreach($infographics as $info)
                        <div class="infographic-card" data-image-url="{{ $info['image'] }}" data-title="{{ $info['title'] }}"
                            style="cursor: pointer;">
                            <div class="infographic-image-wrap">
                                <img data-src="{{ $info['image'] }}" alt="{{ $info['title'] }}" class="lazy-image"
                                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                            </div>
                            <div class="infographic-content">
                                <h4 class="infographic-title">{{ $info['title'] }}</h4>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- ==========================================================================
           5. Premium Podcast / E-Paper subscription Banner (New Section)
           ========================================================================== -->
        <div class="premium-gradient-banner">
            <div class="premium-banner-left">
                <span class="premium-banner-badge">NusaKini Premium</span>
                <h3 class="premium-banner-title">Jurnalisme Independen Membutuhkan Dukungan Anda</h3>
                <p class="premium-banner-desc">Berlangganan NusaKini Premium untuk mendapatkan laporan investigatif tanpa
                    batas, analisis ekonomi makro mingguan, serta arsip infografis resolusi tinggi bebas gangguan.</p>
            </div>
            <div class="premium-banner-right">
                <a href="{{ \App\Models\Setting::get('epaper_link', '#') }}" target="_blank" class="btn-premium-cta">
                    <span>Mulai Berlangganan</span>
                    <svg style="width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.5; fill: none;"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- ==========================================================================
           6. Main Layout Grid (Core News Category Columns & Sidebar Widgets)
           ========================================================================== -->
        <div class="portal-main-grid">

            <!-- Left Column: Modular Category Feeds -->
            <div class="main-left-column">

                <!-- Category Politik & Hukum -->
                <div style="margin-bottom: 45px;">
                    <div class="section-header">
                        <h3 class="section-title">Politik & <span>Hukum</span></h3>
                        <a href="{{ route('news.category', 'politik-hukum') }}" class="section-view-all">Lihat Semua →</a>
                    </div>
                    <div class="news-grid grid-2">
                        @if(isset($politikArticles) && count($politikArticles) > 0)
                            @foreach($politikArticles as $item)
                                <article class="news-card">
                                    <div class="card-image-wrap lazy-image-wrap">
                                        <span class="category-tag">{{ $item['category'] }}</span>
                                        <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                                    </div>
                                    <div class="card-content">
                                        <div class="article-meta">
                                            <span class="article-author">{{ $item['author'] }}</span>
                                            <span>•</span>
                                            <span>{{ $item['date'] }}</span>
                                        </div>
                                        <h4 class="card-title">
                                            <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                        </h4>
                                        <p class="card-excerpt">
                                            {{ $item['excerpt'] }}
                                        </p>
                                        <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more"
                                            style="margin-top: auto;">Baca Berita →</a>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Category Teknologi & Sains -->
                <div style="margin-bottom: 45px;">
                    <div class="section-header">
                        <h3 class="section-title">Teknologi & <span>Sains</span></h3>
                        <a href="{{ route('news.category', 'teknologi-sains') }}" class="section-view-all">Lihat Semua →</a>
                    </div>
                    <div class="news-grid grid-2">
                        @if(isset($teknologiArticles) && count($teknologiArticles) > 0)
                            @foreach($teknologiArticles as $item)
                                <article class="news-card">
                                    <div class="card-image-wrap lazy-image-wrap">
                                        <span class="category-tag">{{ $item['category'] }}</span>
                                        <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                                    </div>
                                    <div class="card-content">
                                        <div class="article-meta">
                                            <span class="article-author">{{ $item['author'] }}</span>
                                            <span>•</span>
                                            <span>{{ $item['date'] }}</span>
                                        </div>
                                        <h4 class="card-title">
                                            <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                        </h4>
                                        <p class="card-excerpt">
                                            {{ $item['excerpt'] }}
                                        </p>
                                        <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more"
                                            style="margin-top: auto;">Baca Berita →</a>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Category Ekonomi & Bisnis -->
                <div style="margin-bottom: 45px;">
                    <div class="section-header">
                        <h3 class="section-title">Ekonomi & <span>Bisnis</span></h3>
                        <a href="{{ route('news.category', 'ekonomi-bisnis') }}" class="section-view-all">Lihat Semua →</a>
                    </div>
                    <div class="news-grid grid-2">
                        @if(isset($ekonomiArticles) && count($ekonomiArticles) > 0)
                            @foreach($ekonomiArticles as $item)
                                <article class="news-card">
                                    <div class="card-image-wrap lazy-image-wrap">
                                        <span class="category-tag">{{ $item['category'] }}</span>
                                        <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                                    </div>
                                    <div class="card-content">
                                        <div class="article-meta">
                                            <span class="article-author">{{ $item['author'] }}</span>
                                            <span>•</span>
                                            <span>{{ $item['date'] }}</span>
                                        </div>
                                        <h4 class="card-title">
                                            <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                        </h4>
                                        <p class="card-excerpt">
                                            {{ $item['excerpt'] }}
                                        </p>
                                        <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more"
                                            style="margin-top: auto;">Baca Berita →</a>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Category Olahraga & Gaya Hidup (New Section on Homepage) -->
                <div style="margin-bottom: 25px;">
                    <div class="section-header">
                        <h3 class="section-title">Olahraga & <span>Gaya Hidup</span></h3>
                        <a href="{{ route('news.category', 'gaya-hidup') }}" class="section-view-all">Lihat Semua →</a>
                    </div>
                    <div class="news-grid grid-2">
                        @if(isset($lifestyleArticles) && count($lifestyleArticles) > 0)
                            @foreach($lifestyleArticles as $item)
                                <article class="news-card">
                                    <div class="card-image-wrap lazy-image-wrap">
                                        <span class="category-tag">{{ $item['category'] }}</span>
                                        <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                                    </div>
                                    <div class="card-content">
                                        <div class="article-meta">
                                            <span class="article-author">{{ $item['author'] }}</span>
                                            <span>•</span>
                                            <span>{{ $item['date'] }}</span>
                                        </div>
                                        <h4 class="card-title">
                                            <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                        </h4>
                                        <p class="card-excerpt">
                                            {{ $item['excerpt'] }}
                                        </p>
                                        <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more"
                                            style="margin-top: auto;">Baca Berita →</a>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Column: Sidebar Inclusion -->
            <aside class="main-right-column">
                @include('partials.sidebar')
            </aside>

        </div>

@endsection