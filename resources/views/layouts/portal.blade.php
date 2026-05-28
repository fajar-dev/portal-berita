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
    
    <!-- OpenGraph Social Tags -->
    <meta property="og:title" content="@yield('title', 'NusaKini - Portal Berita Tepercaya')">
    <meta property="og:description" content="@yield('meta_description', 'NusaKini menyajikan portal berita terkini seputar Politik, Ekonomi, Teknologi, Olahraga secara mendalam dan berimbang.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="NusaKini News Portal">

    <!-- Vite Assets compiled -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Dynamic Reading Progress Bar (Loaded on details view) -->
    @yield('progress_bar')

    <!-- Header Section -->
    @include('partials.header')

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
                        <img id="modal-infographic-img" src="" alt="Infografis">
                    </div>
                    <h3 id="modal-infographic-title" class="modal-media-caption"></h3>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
