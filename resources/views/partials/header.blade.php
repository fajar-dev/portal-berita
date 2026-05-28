<!-- Upper Premium Top Bar -->
<div class="top-bar">
    <div class="portal-container top-bar-content">
        <div class="top-bar-left">
            <span id="live-clock" style="font-weight: 600; letter-spacing: 0.2px;">Memuat waktu...</span>
        </div>
        
        <!-- Live Financial Market Ticker center section (Desktop Only) -->
        <div class="top-bar-center" id="financial-ticker-bar">
            <!-- Dynamically populated fluctuating values by JavaScript -->
        </div>

        <div class="top-bar-right">
            <!-- Simulated Weather Status (Synced with Sidebar Widget) -->
            <div id="topbar-weather-display" style="display: flex; align-items: center; gap: 6px; font-weight: 600;" title="Sinkron dengan Widget Cuaca Bilah Samping">
                <svg id="topbar-weather-icon" style="width: 14px; height: 14px; color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                </svg>
                <span id="topbar-weather-text">Jakarta, 31°C</span>
            </div>
            <span>•</span>
            <!-- Saved Reading List Badge Link -->
            <a href="{{ route('news.bookmarks') }}" style="display: flex; align-items: center; gap: 6px; font-weight: 700; color: var(--color-primary-soft); background-color: var(--color-primary); padding: 2px 10px; border-radius: var(--border-radius-sm); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">
                <svg style="width: 11px; height: 11px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                </svg>
                <span>Simpanan</span>
                <span id="bookmark-count-badge" style="background-color: #fff; color: var(--color-primary); font-size: 0.65rem; padding: 0px 5px; border-radius: 50%; font-weight: 800; min-width: 14px; text-align: center; display: none;">0</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Logo & Brand Banner Bar -->
<div class="brand-section">
    <div class="portal-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <a href="{{ route('news.home') }}" class="logo-main">
            @php
                $siteName = \App\Models\Setting::get('site_name', 'NusaKini');
                $firstPart = substr($siteName, 0, 4); // "NUSA"
                $secondPart = substr($siteName, 4); // "KINI"
            @endphp
            {{ strtoupper($firstPart) }}<span>{{ strtoupper($secondPart) }}</span>
        </a>
        
        <!-- Interactive Search Bar -->
        <div class="search-bar-container">
            <form action="{{ route('news.search') }}" method="GET">
                <input type="text" name="q" class="search-input" placeholder="Cari berita hangat hari ini..." required value="{{ $query ?? '' }}">
                <button type="submit" class="search-icon" aria-label="Cari Berita">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Sticky Main Navigation Bar -->
<nav class="main-navigation">
    <div class="portal-container nav-flex">
        <!-- Responsive Category Menu Lists -->
        <ul class="nav-links">
            @php
                $navbarMenus = \App\Models\Menu::whereNull('parent_id')
                    ->where('is_active', true)
                    ->orderBy('order', 'asc')
                    ->with(['children' => function($q) {
                        $q->where('is_active', true)->orderBy('order', 'asc');
                    }])
                    ->get();
            @endphp
            @foreach($navbarMenus as $menu)
                @php
                    $hasChildren = $menu->children->count() > 0;
                    $isActive = request()->is(trim($menu->url, '/')) || (request()->routeIs('news.home') && $menu->url === '/');
                    
                    if (!$isActive && $hasChildren) {
                        foreach($menu->children as $child) {
                            if (request()->is(trim($child->url, '/'))) {
                                $isActive = true;
                                break;
                            }
                        }
                    }
                @endphp
                
                @if($hasChildren)
                    <li class="nav-item has-dropdown {{ $isActive ? 'active' : '' }}" style="position: relative;">
                        <a href="{{ $menu->url }}" style="display: flex; align-items: center; gap: 4px;">
                            {{ $menu->name }}
                            <svg style="width: 10px; height: 10px; transition: transform 0.3s ease;" class="dropdown-caret" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        
                        <!-- Premium Dropdown Menu -->
                        <ul class="dropdown-menu">
                            @foreach($menu->children as $child)
                                <li class="dropdown-item {{ request()->is(trim($child->url, '/')) ? 'active' : '' }}">
                                    <a href="{{ $child->url }}">{{ $child->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-item {{ $isActive ? 'active' : '' }}">
                        <a href="{{ $menu->url }}">{{ $menu->name }}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>

<!-- Breaking News Sliding Text Ticker -->
<div class="news-ticker">
    <div class="portal-container ticker-wrap">
        <span class="ticker-badge">
            <svg style="width: 11px; height: 11px; animation: pulse 1s infinite;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
            </svg>
            TERHANGAT
        </span>
        <div class="ticker-scroll">
            <div class="ticker-track">
                @php
                    $tickerArticles = \App\Models\Article::orderByRaw('(reactions_suka + reactions_terkejut + reactions_inspiratif + reactions_sedih) desc')
                        ->take(4)
                        ->get();
                @endphp
                @foreach($tickerArticles as $index => $ticker)
                    <span class="ticker-item">
                        <span>{{ $index + 1 }}.</span> 
                        <a href="{{ route('news.detail', $ticker->slug) }}" style="color: inherit; text-decoration: none; font-weight: 500;">
                            {{ $ticker->title }}
                        </a>
                    </span>
                @endforeach
                <!-- Repeat list for smooth endless loop illusion -->
                @foreach($tickerArticles as $index => $ticker)
                    <span class="ticker-item">
                        <span>{{ $index + 1 }}.</span> 
                        <a href="{{ route('news.detail', $ticker->slug) }}" style="color: inherit; text-decoration: none; font-weight: 500;">
                            {{ $ticker->title }}
                        </a>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
