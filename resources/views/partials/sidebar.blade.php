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

    <!-- 3. Premium Editorial Promo Card (Bespoke Ad) -->
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
        
        <a href="#" style="background-color: #fff; color: var(--color-dark); padding: 8px 20px; border-radius: var(--border-radius-sm); font-size: 0.78rem; font-weight: 700; display: inline-block; transition: var(--transition-smooth); width: 100%;">
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
