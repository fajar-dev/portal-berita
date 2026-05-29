<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Dynamic SEO Titles and Descriptions -->
    <title>@yield('title', 'NusaKini - Portal Berita Modern, Kredibel, & Tepercaya')</title>
    <meta name="description" content="@yield('meta_description', 'NusaKini menyajikan portal berita terkini seputar Politik, Ekonomi, Teknologi, Olahraga, Gaya Hidup, dan Internasional secara mendalam, cerdas, dan kredibel.')">
    <meta name="keywords" content="portal berita, berita terkini, EBT, ekonomi digital, AI medis, sport science, NusaKini, berita indonesia">
    <meta name="author" content="NusaKini Editorial Team">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ request()->url() }}">
    <link rel="alternate" type="application/rss+xml" title="NusaKini RSS Feed" href="{{ route('news.feed') }}">
    
    <!-- Favicon & Themes -->
    @php
        $favicon = \App\Models\Setting::get('site_favicon');
        $faviconUrl = $favicon ? asset($favicon) : asset('favicon.ico');
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
    
    <!-- OpenGraph Social Tags -->
    <meta property="og:title" content="@yield('title', 'NusaKini - Portal Berita Tepercaya')">
    <meta property="og:description" content="@yield('meta_description', 'NusaKini menyajikan portal berita terkini seputar Politik, Ekonomi, Teknologi, Olahraga secara mendalam dan berimbang.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="@yield('og_image', asset('storage/images/hero_ebt.jpg'))">
    <meta property="og:site_name" content="NusaKini News Portal">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'NusaKini - Portal Berita Tepercaya')">
    <meta name="twitter:description" content="@yield('meta_description', 'NusaKini menyajikan portal berita terkini seputar Politik, Ekonomi, Teknologi, Olahraga secara mendalam dan berimbang.')">
    <meta name="twitter:image" content="@yield('og_image', asset('storage/images/hero_ebt.jpg'))">

    <!-- Dynamic Schema.org JSON-LD structured data -->
    @yield('schema_json_ld')

    <!-- Dark Mode FOUC Prevention -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>

    <!-- Vite Assets compiled -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Dynamic Reading Progress Bar (Loaded on details view) -->
    @yield('progress_bar')

    <!-- Header Section -->
    @include('partials.header')

    <!-- Header Advertisement Space -->
    <div class="portal-container">
        @include('partials.ad', ['position' => 'header'])
    </div>

    <!-- Main Content Slot Wrapper -->
    <main id="main-content-section" class="portal-container">
        @yield('content')
    </main>

    <!-- Footer Section -->
    @include('partials.footer')

    <!-- Unique Identifier element for automation/browser testing -->
    <div id="nusakini-app-loaded" style="display:none;" data-version="1.0" data-theme-engine="clean-light"></div>

    <!-- Global Premium Media Lightbox Modal -->
    <div id="media-modal" class="media-modal" aria-hidden="true" role="dialog">
        <div class="media-modal-backdrop"></div>
        <div class="media-modal-container">
            <button class="media-modal-close" aria-label="Tutup Media">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="media-modal-content">
                <!-- YouTube Video Element Container -->
                <div id="modal-video-wrapper" class="modal-media-wrapper" style="display: none;">
                    <div class="video-iframe-aspect">
                        <iframe id="modal-youtube-iframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
                <!-- Infographic Image Element Container -->
                <div id="modal-image-wrapper" class="modal-media-wrapper" style="display: none;">
                    <div class="infographic-zoom-wrap">
                        <img id="modal-infographic-img" data-src="" alt="Infografis" class="lazy-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                    </div>
                    <h3 id="modal-infographic-title" class="modal-media-caption"></h3>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
