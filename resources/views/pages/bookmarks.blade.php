@extends('layouts.portal')

@section('title', 'Artikel Tersimpan - NusaKini')
@section('meta_description', 'Akses daftar berita dan analisis eksklusif yang Anda simpan untuk dibaca kembali kapan saja di NusaKini.')

@section('content')

    <!-- Bookmark Page Main Header -->
    <div style="margin-top: 30px; margin-bottom: 30px; background-color: var(--color-card-bg); border: 1px solid var(--color-border); padding: 30px; border-radius: var(--border-radius-md); box-shadow: var(--shadow-sm);">
        <span style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 6px; letter-spacing: 1px;">
            DAFTAR BACAAN PRIBADI
        </span>
        <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--color-dark); margin: 0;">
            Artikel <span style="border-bottom: 3px solid var(--color-primary); padding-bottom: 4px;">Tersimpan</span>
        </h1>
        <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-top: 15px; max-width: 700px; line-height: 1.5;">
            Daftar ini disimpan secara lokal di dalam browser Anda. Anda dapat membaca artikel-artikel pilihan Anda kembali kapan saja bahkan saat bersantai di waktu senggang.
        </p>
    </div>

    <!-- Main Grid Layout -->
    <div class="portal-main-grid">
        
        <!-- Left Column: Dynamic LocalStorage Bookmarks Container -->
        <div class="main-left-column" id="bookmarks-list-container">
            
            <!-- Default Loading State (Replaced immediately by app.js Bookmarks Engine) -->
            <div style="text-align: center; padding: 60px 20px; background-color: var(--color-card-bg); border-radius: var(--border-radius-md); border: 1px solid var(--color-border);">
                <div style="width: 40px; height: 40px; border: 3px solid var(--color-border); border-top-color: var(--color-primary); border-radius: 50%; display: inline-block; animation: spin 1s linear infinite; margin-bottom: 15px;"></div>
                <h4 style="font-family: var(--font-heading); font-size: 1.2rem; margin: 0;">Sinkronisasi Penanda...</h4>
                <p style="font-size: 0.88rem; color: var(--color-text-muted); margin-top: 5px;">Membaca data artikel tersimpan dari memori lokal browser Anda.</p>
            </div>

        </div>

        <!-- Right Column: Sidebar widgets inclusion -->
        <aside class="main-right-column">
            @include('partials.sidebar')
        </aside>

    </div>

@endsection
