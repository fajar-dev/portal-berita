@extends('layouts.portal')

@section('title', 'Hubungi Redaksi NusaKini - Portal Berita Modern')
@section('meta_description', 'Kirim kritik, saran, pertanyaan, atau rilis pers Anda ke redaksi NusaKini. Kami siap mendengarkan suara Anda.')

@section('content')

    <!-- Contact Page Main Header -->
    <div style="margin-top: 30px; margin-bottom: 30px; background-color: var(--color-card-bg); border: 1px solid var(--color-border); padding: 30px; border-radius: var(--border-radius-md); box-shadow: var(--shadow-sm);">
        <span style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 6px; letter-spacing: 1px;">
            HUBUNGI KAMI
        </span>
        <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--color-dark); margin: 0;">
            Kontak & <span style="border-bottom: 3px solid var(--color-primary); padding-bottom: 4px;">Umpan Balik</span>
        </h1>
        <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-top: 15px; max-width: 700px; line-height: 1.5;">
            Apakah Anda memiliki pertanyaan, kritik konstruktif, rilis pers eksklusif, atau ingin memasang iklan bersama kami? Silakan hubungi tim kami melalui formulir di bawah ini.
        </p>
    </div>

    <!-- Contact Grid Structure -->
    <div class="contact-grid">
        
        <!-- Left Side: Interactive Feedback Form -->
        <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--border-radius-md); padding: 35px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; border-bottom: 1px solid var(--color-border); padding-bottom: 12px; margin-bottom: 25px; color: var(--color-dark);">
                Formulir Pesan Redaksi
            </h3>
            
            <form id="portal-contact-form">
                <div class="comment-input-row" style="margin-bottom: 20px;">
                    <div>
                        <label for="contact-name" style="font-size: 0.8rem; font-weight: 700; color: var(--color-dark); display: block; margin-bottom: 8px;">Nama Lengkap</label>
                        <input type="text" id="contact-name" class="comment-input-field" placeholder="Masukkan nama lengkap Anda..." required>
                    </div>
                    <div>
                        <label for="contact-email" style="font-size: 0.8rem; font-weight: 700; color: var(--color-dark); display: block; margin-bottom: 8px;">Alamat Email</label>
                        <input type="email" id="contact-email" class="comment-input-field" placeholder="Masukkan alamat email Anda..." required>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="contact-subject" style="font-size: 0.8rem; font-weight: 700; color: var(--color-dark); display: block; margin-bottom: 8px;">Subjek / Kategori Pesan</label>
                    <select id="contact-subject" class="comment-input-field" style="background-image: none; height: auto;">
                        <option value="redaksi">Rilis Pers / Liputan Editorial</option>
                        <option value="iklan">Pemasangan Iklan & Sponsorship</option>
                        <option value="karir">Karir & Kontributor Kolom</option>
                        <option value="saran">Kritik, Saran & Koreksi Berita</option>
                    </select>
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="contact-message" style="font-size: 0.8rem; font-weight: 700; color: var(--color-dark); display: block; margin-bottom: 8px;">Pesan Anda</label>
                    <textarea id="contact-message" class="comment-input-field" style="min-height: 150px; resize: vertical;" placeholder="Tuliskan pesan, rilis pers, atau ulasan lengkap Anda di sini..." required></textarea>
                </div>

                <button type="submit" class="comment-submit-btn" style="width: 100%; padding: 14px;">
                    Kirim Formulir Pesan
                </button>
            </form>
        </div>

        <!-- Right Side: Info Box & Beautiful Vector Map Mockup -->
        <div class="contact-card-info">
            
            <!-- Core Coordinates -->
            <div class="info-item-box">
                <div class="info-item-icon">📍</div>
                <div class="info-item-content">
                    <h5>Kantor Editorial Pusat</h5>
                    <p>{{ \App\Models\Setting::get('office_address') }}</p>
                </div>
            </div>

            <div class="info-item-box">
                <div class="info-item-icon">📞</div>
                <div class="info-item-content">
                    <h5>Layanan Kontak Hubungan Masyarakat</h5>
                    <p>
                        Telp: {{ \App\Models\Setting::get('office_phone') }} | 
                        Fax: {{ \App\Models\Setting::get('office_fax') }} | 
                        WhatsApp: {{ \App\Models\Setting::get('office_whatsapp') }}
                    </p>
                </div>
            </div>

            <div class="info-item-box">
                <div class="info-item-icon">✉️</div>
                <div class="info-item-content">
                    <h5>Korespondensi Email</h5>
                    <p>{{ \App\Models\Setting::get('office_email') }}</p>
                </div>
            </div>

            <!-- Highly Custom Vector Map Graphic Outline (Premium Architectural Look) -->
            <div class="svg-map-container">
                <div style="width: 100%; text-align: center;">
                    <span style="font-size: 0.65rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 12px;">
                        PETA LOKASI HQ (VECTOR MAP)
                    </span>
                    <svg viewBox="0 0 400 200" style="width: 100%; max-height: 160px; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.05));" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background Grid lines -->
                        <g stroke="var(--color-border)" stroke-width="0.5" stroke-dasharray="2,2">
                            <line x1="0" y1="40" x2="400" y2="40" />
                            <line x1="0" y1="80" x2="400" y2="80" />
                            <line x1="0" y1="120" x2="400" y2="120" />
                            <line x1="0" y1="160" x2="400" y2="160" />
                            <line x1="80" y1="0" x2="80" y2="200" />
                            <line x1="160" y1="0" x2="160" y2="200" />
                            <line x1="240" y1="0" x2="240" y2="200" />
                            <line x1="320" y1="0" x2="320" y2="200" />
                        </g>

                        <!-- Simulated Blocks/Road outlines -->
                        <rect x="30" y="20" width="120" height="70" rx="4" fill="var(--color-light)" stroke="var(--color-border)" stroke-width="1.5" />
                        <rect x="220" y="20" width="150" height="70" rx="4" fill="var(--color-light)" stroke="var(--color-border)" stroke-width="1.5" />
                        <rect x="30" y="120" width="150" height="60" rx="4" fill="var(--color-light)" stroke="var(--color-border)" stroke-width="1.5" />
                        <rect x="220" y="120" width="120" height="60" rx="4" fill="var(--color-light)" stroke="var(--color-border)" stroke-width="1.5" />

                        <!-- Main Roadway strip -->
                        <line x1="0" y1="105" x2="400" y2="105" stroke="var(--color-border)" stroke-width="12" stroke-linecap="round" />
                        <line x1="0" y1="105" x2="400" y2="105" stroke="#fff" stroke-width="1" stroke-dasharray="6,6" />
                        <text x="180" y="102" font-size="8" fill="var(--color-text-muted)" font-weight="700" letter-spacing="1">SUDIRMAN AVE</text>

                        <!-- Glowing Office Pin Spot -->
                        <circle cx="280" cy="55" r="14" fill="var(--color-primary-soft)" style="animation: pulse 2s infinite;" />
                        <circle cx="280" cy="55" r="6" fill="var(--color-primary)" />
                        
                        <!-- Marker Card bubble -->
                        <rect x="230" y="-5" width="100" height="35" rx="3" fill="var(--color-dark)" />
                        <polygon points="280,30 275,30 280,35" fill="var(--color-dark)" />
                        <text x="240" y="10" font-size="7" fill="#fff" font-weight="700">NUSA MEDIA CENTER</text>
                        <text x="240" y="20" font-size="6" fill="var(--color-primary)">Pusat Redaksi HQ</text>
                    </svg>
                </div>
            </div>

        </div>

    </div>

@endsection
