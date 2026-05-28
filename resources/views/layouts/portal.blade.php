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

</body>
</html>
