<div class="sidebar-widgets">

    <!-- 1. Terpopuler (Trending) Widget -->
    <div class="widget-card">
        <h4 class="widget-title">Terpopuler</h4>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @if(isset($trendingArticles) && count($trendingArticles) > 0)
                @foreach($trendingArticles as $index => $item)
                    <div class="trending-item">
                        <span class="trending-number">{{ sprintf('%02d', $index + 1) }}</span>
                        <div class="trending-content">
                            <span style="font-size: 0.7rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">
                                {{ $item['category'] }}
                            </span>
                            <h5 class="trending-title">
                                <a href="{{ route('news.detail', $item['slug']) }}">{{ $item['title'] }}</a>
                            </h5>
                        </div>
                    </div>
                @endforeach
            @else
                <p style="font-size: 0.85rem; color: var(--color-text-muted);">Tidak ada berita populer saat ini.</p>
            @endif
        </div>
    </div>

    @php
        $activePoll = \App\Models\Poll::where('is_active', true)->latest()->first();
    @endphp

    @if($activePoll)
        <!-- 2. Jajak Pendapat (Opinion Poll) Interactive Widget -->
        <div class="widget-card" id="opinion-poll-widget" data-poll-id="{{ $activePoll->id }}">
            <h4 class="widget-title">Jajak Pendapat</h4>
            
            <div class="poll-question">
                {{ $activePoll->question }}
            </div>

            <!-- Options Choice Mode View -->
            <div class="poll-options-view">
                <button class="poll-option-btn" data-option="opt1">{{ $activePoll->opt1 }}</button>
                <button class="poll-option-btn" data-option="opt2">{{ $activePoll->opt2 }}</button>
                <button class="poll-option-btn" data-option="opt3">{{ $activePoll->opt3 }}</button>
                <button class="poll-option-btn" data-option="opt4">{{ $activePoll->opt4 }}</button>
            </div>

            <!-- Dynamic Poll Fills Results View (Toggled via JS) -->
            <div class="poll-results-view">
                
                <div class="poll-result-bar-wrap">
                    <div class="poll-result-label">
                        <span>{{ $activePoll->opt1 }}</span>
                        <span id="{{ $activePoll->id }}-pct-opt1">0%</span>
                    </div>
                    <div class="poll-result-track">
                        <div class="poll-result-fill" id="{{ $activePoll->id }}-fill-opt1"></div>
                    </div>
                </div>

                <div class="poll-result-bar-wrap">
                    <div class="poll-result-label">
                        <span>{{ $activePoll->opt2 }}</span>
                        <span id="{{ $activePoll->id }}-pct-opt2">0%</span>
                    </div>
                    <div class="poll-result-track">
                        <div class="poll-result-fill" id="{{ $activePoll->id }}-fill-opt2"></div>
                    </div>
                </div>

                <div class="poll-result-bar-wrap">
                    <div class="poll-result-label">
                        <span>{{ $activePoll->opt3 }}</span>
                        <span id="{{ $activePoll->id }}-pct-opt3">0%</span>
                    </div>
                    <div class="poll-result-track">
                        <div class="poll-result-fill" id="{{ $activePoll->id }}-fill-opt3"></div>
                    </div>
                </div>

                <div class="poll-result-bar-wrap">
                    <div class="poll-result-label">
                        <span>{{ $activePoll->opt4 }}</span>
                        <span id="{{ $activePoll->id }}-pct-opt4">0%</span>
                    </div>
                    <div class="poll-result-track">
                        <div class="poll-result-fill" id="{{ $activePoll->id }}-fill-opt4"></div>
                    </div>
                </div>

                <p style="font-size: 0.72rem; color: var(--color-text-muted); text-align: center; margin-top: 15px; font-weight: 500;">
                    Terima kasih! Suara Anda telah terekam secara otomatis.
                </p>
            </div>
        </div>
    @endif

    <!-- 3. Cuaca Pintar Interaktif (Interactive Weather Widget) -->
    <div class="widget-card weather-widget">
        <!-- Weather Card Accent -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background-color: rgba(255, 255, 255, 0.25);"></div>
        
        <div class="weather-widget-header">
            <h4 class="weather-widget-title">
                Cuaca Nusantara
            </h4>
            <!-- City Selection Dropdown Selector -->
            <select id="weather-city-selector" aria-label="Pilih Kota">
                <option value="jakarta">Jakarta</option>
                <option value="surabaya">Surabaya</option>
                <option value="bandung">Bandung</option>
                <option value="medan">Medan</option>
                <option value="bali">Denpasar (Bali)</option>
            </select>
        </div>

        <div class="weather-info-box">
            <div class="weather-temp-wrap" style="display: flex; flex-direction: column;">
                <span class="weather-city-label" id="weather-city-name">DKI JAKARTA</span>
                <span class="weather-temp" id="weather-temp-val">31°C</span>
                <span class="weather-condition" id="weather-condition-val">Cerah Berawan</span>
            </div>
            
            <!-- Dynamic Big Weather Icon -->
            <div class="weather-icon-wrap">
                <svg id="weather-main-icon" style="width: 38px; height: 38px; color: #fff; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                </svg>
            </div>
        </div>

        <div class="weather-footer">
            <div class="weather-footer-item">
                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
                <span>Kelembaban: <span id="weather-humidity-val">65%</span></span>
            </div>
            <div class="weather-footer-item">
                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                <span>Angin: <span id="weather-wind-val">12 km/h</span></span>
            </div>
        </div>
    </div>

    <!-- 4. Premium Editorial Promo Card (Bespoke Ad) -->
    <div class="widget-card" style="background-color: var(--color-dark); color: #fff; text-align: center; border: none; overflow: hidden; position: relative;">
        <!-- Delicate Red Accent bar -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background-color: var(--color-primary);"></div>
        
        <span style="font-size: 0.65rem; font-weight: 800; background-color: var(--color-primary); color: #fff; padding: 2px 8px; border-radius: var(--border-radius-sm); text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 15px;">
            E-PAPER EKSLUSIF
        </span>
        
        <h4 style="font-family: var(--font-heading); font-size: 1.4rem; line-height: 1.3; color: #fff; margin-bottom: 10px;">
            Masa Depan<br>Siber Indonesia
        </h4>
        
        <p style="font-size: 0.8rem; color: hsl(220, 10%, 75%); line-height: 1.5; margin-bottom: 20px; padding: 0 10px;">
            Unduh laporan riset mendalam tim jurnalis NusaKini seputar peta ancaman kejahatan digital nasional edisi terbaru gratis.
        </p>
        
        <a href="{{ \App\Models\Setting::get('epaper_link', '#') }}" target="_blank" style="background-color: #fff; color: var(--color-dark); padding: 8px 20px; border-radius: var(--border-radius-sm); font-size: 0.78rem; font-weight: 700; display: inline-block; transition: var(--transition-smooth); width: 100%; text-align: center; text-decoration: none;">
            Unduh PDF Sekarang
        </a>
    </div>

    <!-- 4. Tag Populer (Popular Tags) Cloud Widget -->
    <div class="widget-card">
        <h4 class="widget-title">Tag Populer</h4>
        @php
            $popularTags = \App\Models\Tag::take(12)->get();
        @endphp
        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
            @if(count($popularTags) > 0)
                @foreach($popularTags as $tag)
                    <a href="{{ route('news.tag', $tag->slug) }}" class="tag-badge-link" style="font-size: 0.72rem; font-weight: 700; color: var(--color-text-muted); background-color: var(--color-light); border: 1px solid var(--color-border); padding: 5px 10px; border-radius: var(--border-radius-pill); text-decoration: none; transition: var(--transition-smooth);">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            @else
                <p style="font-size: 0.85rem; color: var(--color-text-muted);">Belum ada tag populer.</p>
            @endif
        </div>
    </div>

</div>
