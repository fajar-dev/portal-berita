@extends('layouts.portal')

@section('title', 'Topik Berita ' . $tagName . ' - NusaKini')
@section('meta_description', 'Kumpulan analisis berita mendalam dan kabar eksklusif seputar topik ' . $tagName . ' secara terpercaya di NusaKini.')

@section('content')

    <!-- Tag Archive Main Heading -->
    <div style="margin-top: 30px; margin-bottom: 30px; background-color: var(--color-card-bg); border: 1px solid var(--color-border); padding: 30px; border-radius: var(--border-radius-md); box-shadow: var(--shadow-sm);">
        <span style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 6px; letter-spacing: 1px;">
            TOPIK BERSAMA
        </span>
        <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--color-dark); margin: 0;">
            Tag: <span style="border-bottom: 3px solid var(--color-primary); padding-bottom: 4px;">#{{ $tagName }}</span>
        </h1>
        <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-top: 15px; max-width: 700px; line-height: 1.5;">
            Menyajikan kumpulan laporan investigatif, ulasan mendalam, dan informasi paling kredibel seputar topik #{{ $tagName }} yang dikurasi langsung oleh tim redaksi NusaKini.
        </p>
    </div>

    <!-- Main Grid Layout -->
    <div class="portal-main-grid">
        
        <!-- Left Column: Article Feeds list -->
        <div class="main-left-column">
            
            <div class="news-grid grid-2">
                @if(isset($tagArticles) && count($tagArticles) > 0)
                    @foreach($tagArticles as $item)
                        <article class="news-card">
                            <div class="card-image-wrap lazy-image-wrap">
                                <span class="category-tag" style="background:{{ $item['category_color'] }};">{{ $item['category'] }}</span>
                                <img data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                            </div>
                            <div class="card-content">
                                <div class="article-meta">
                                    <span class="article-author">{{ $item['author'] }}</span>
                                    <span>•</span>
                                    <span>{{ $item['date'] }}</span>
                                </div>
                                <h3 class="card-title" style="font-size: 1.2rem; line-height: 1.3; margin-bottom: 10px;">
                                    <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                </h3>
                                <p class="card-excerpt" style="font-size: 0.88rem; margin-bottom: 20px;">
                                    {{ $item['excerpt'] }}
                                </p>
                                <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more" style="margin-top: auto;">
                                    Baca Berita →
                                </a>
                            </div>
                        </article>
                    @endforeach
                @else
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; background-color: var(--color-card-bg); border-radius: var(--border-radius-md); border: 1px solid var(--color-border);">
                        <svg style="width: 48px; height: 48px; color: var(--color-text-muted); margin-bottom: 15px; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h4 style="font-family: var(--font-heading); font-size: 1.25rem; margin-bottom: 5px;">Belum Ada Berita</h4>
                        <p style="font-size: 0.9rem; color: var(--color-text-muted);">Belum ada berita yang dihubungkan dengan topik #{{ $tagName }} saat ini.</p>
                    </div>
                @endif
            </div>

            <!-- Simulated Elegant Editorial Pagination -->
            @if(isset($tagArticles) && count($tagArticles) > 0)
                <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; border-top: 1px solid var(--color-border); padding-top: 25px;">
                    <a href="#" style="padding: 8px 14px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-text-muted); pointer-events: none; opacity: 0.5;">
                        Sebelumnya
                    </a>
                    <a href="#" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--color-primary); color: #fff; border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; border: 1px solid var(--color-primary);">
                        1
                    </a>
                    <span style="font-size: 0.82rem; color: var(--color-text-muted);">...</span>
                    <a href="#" style="padding: 8px 14px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-dark);">
                        Berikutnya
                    </a>
                </div>
            @endif

        </div>

        <!-- Right Column: Sidebar Inclusion -->
        <aside class="main-right-column">
            @include('partials.sidebar')
        </aside>

    </div>

@endsection
