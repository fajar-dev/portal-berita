@extends('layouts.portal')

@section('title', 'Hasil Pencarian "' . ($query ?? '') . '" - NusaKini')
@section('meta_description', 'Menampilkan hasil pencarian artikel berita NusaKini berdasarkan kata kunci pencarian Anda.')

@section('content')

    <!-- Search Results Header banner -->
    <div style="margin-top: 30px; margin-bottom: 30px; background-color: var(--color-card-bg); border: 1px solid var(--color-border); padding: 30px; border-radius: var(--border-radius-md); box-shadow: var(--shadow-sm);">
        <span style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 6px; letter-spacing: 1px;">
            HASIL PENCARIAN SISTEM
        </span>
        <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--color-dark); margin: 0; line-height: 1.2;">
            Kata Kunci: <span style="border-bottom: 3px solid var(--color-primary); padding-bottom: 4px;">"{{ $query ?? '' }}"</span>
        </h1>
        <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-top: 15px;">
            Ditemukan <strong>{{ count($results ?? []) }}</strong> artikel berita yang relevan dengan kueri pencarian Anda.
        </p>
    </div>

    <!-- Main Grid Layout -->
    <div class="portal-main-grid">
        
        <!-- Left Column: Search Result Articles List -->
        <div class="main-left-column">
            
            @if(isset($results) && count($results) > 0)
                <div class="news-grid grid-2">
                    @foreach($results as $item)
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
                                <h3 class="card-title" style="font-size: 1.15rem; line-height: 1.35; margin-bottom: 10px;">
                                    <a href="{{ route('news.detail', $item['slug']) }}">
                                        <!-- Smart text highlight on match -->
                                        @if(isset($query) && $query !== '')
                                            {!! str_ireplace($query, '<span class="search-highlight">' . e($query) . '</span>', e($item['title'])) !!}
                                        @else
                                            {{ $item['title'] }}
                                        @endif
                                    </a>
                                </h3>
                                <p class="card-excerpt" style="font-size: 0.88rem; margin-bottom: 20px;">
                                    @if(isset($query) && $query !== '')
                                        {!! str_ireplace($query, '<span class="search-highlight">' . e($query) . '</span>', e($item['excerpt'])) !!}
                                    @else
                                        {{ $item['excerpt'] }}
                                    @endif
                                </p>
                                <a href="{{ route('news.detail', $item['slug']) }}" class="btn-read-more" style="margin-top: auto;">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <!-- Elegant Empty Results State -->
                <div style="text-align: center; padding: 60px 30px; background-color: var(--color-card-bg); border-radius: var(--border-radius-md); border: 1px solid var(--color-border);">
                    <svg style="width: 56px; height: 56px; color: var(--color-text-muted); margin-bottom: 20px; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L12 12" />
                    </svg>
                    <h3 style="font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 10px; color: var(--color-dark);">
                        Berita Tidak Ditemukan
                    </h3>
                    <p style="font-size: 0.95rem; color: var(--color-text-muted); max-width: 500px; margin: 0 auto 25px auto; line-height: 1.5;">
                        Maaf, kami tidak menemukan berita yang cocok dengan kata kunci "{{ $query ?? '' }}". Silakan periksa kembali ejaan Anda atau coba kata kunci lainnya.
                    </p>
                    <div style="background-color: var(--color-light); padding: 15px; border-radius: var(--border-radius-md); max-width: 400px; margin: 0 auto; text-align: left; border: 1px solid var(--color-border);">
                        <span style="font-size: 0.72rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase; display: block; margin-bottom: 6px;">Tips Pencarian:</span>
                        <ul style="font-size: 0.8rem; color: var(--color-text-muted); list-style: disc; padding-left: 20px; line-height: 1.6;">
                            <li>Gunakan istilah yang lebih umum (misal: "energi", "ekonomi", "AI").</li>
                            <li>Pastikan ejaan kata kunci pencarian Anda sudah benar.</li>
                            <li>Cari menggunakan kata dasar tanpa imbuhan berlebih.</li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: Sidebar widgets inclusion -->
        <aside class="main-right-column">
            @include('partials.sidebar')
        </aside>

    </div>

@endsection
