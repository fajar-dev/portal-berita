@extends('layouts.portal')

@section('title', $page->title . ' - NusaKini')
@section('meta_description', strip_tags(substr($page->content, 0, 160)))

@section('content')

    <!-- Main Content Layout Grid -->
    <div class="portal-main-grid" style="margin-top: 30px;">
        
        <!-- Left Column: Custom Page Body Content -->
        <div class="main-left-column">
            
            <!-- Dynamic Custom Page Header -->
            <div class="article-header" style="margin-bottom: 35px; border-bottom: 2px solid var(--color-border); padding-bottom: 20px;">
                <h1 class="article-title-main" style="font-size: 2.5rem; font-weight: 800; color: var(--color-dark); font-family: var(--font-heading); margin-bottom: 12px; letter-spacing: -0.8px; line-height: 1.2;">
                    {{ $page->title }}
                </h1>
                <div style="font-size: 0.8rem; color: var(--color-text-muted); font-weight: 700; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <svg style="width: 14px; height: 14px; color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Pembaruan Terakhir: {{ $page->updated_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>

            <!-- Builder CSS -->
            @if(!empty($page->css))
                <style>
                    {!! $page->css !!}
                </style>
            @endif

            <!-- Dynamic Custom Page Rich Content Body -->
            <div class="article-rich-content" style="font-size: 1.05rem; line-height: 1.8; color: var(--color-text); background-color: var(--color-card-bg); border-radius: var(--border-radius-md); padding: 40px; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm); margin-bottom: 30px;">
                {!! $page->content !!}
            </div>

        </div>

        <!-- Right Column: Sidebar widgets inclusion -->
        <aside class="main-right-column">
            @include('partials.sidebar')
        </aside>

    </div>

@endsection
