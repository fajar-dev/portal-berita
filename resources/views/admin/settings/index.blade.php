@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('header_title', 'Pengaturan Website')

@push('styles')
<style>
    .settings-section {
        margin-bottom: var(--sp-2xl);
    }
    .settings-section:last-child { margin-bottom: 0; }
    .settings-section-header {
        display: flex; align-items: center; gap: var(--sp-sm);
        padding-bottom: var(--sp-md); margin-bottom: var(--sp-xl);
        border-bottom: 1px solid var(--admin-border-light);
    }
    .settings-section-icon {
        width: 32px; height: 32px; border-radius: var(--admin-radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .settings-section-icon svg { width: 16px; height: 16px; }
    .settings-section-icon--brand { background: var(--admin-primary-soft); color: var(--admin-primary); }
    .settings-section-icon--contact { background: var(--admin-info-soft); color: var(--admin-info); }
    .settings-section-icon--social { background: var(--admin-success-soft); color: var(--admin-success); }
    .settings-section-icon--seo { background: var(--admin-warning-soft); color: var(--admin-warning); }
    .settings-section-icon--misc { background: #f3e8ff; color: #7c3aed; }
    .settings-section-title {
        font-family: var(--admin-font-heading);
        font-size: var(--fs-md); font-weight: 700;
    }
    .settings-section-desc {
        font-size: var(--fs-xs); color: var(--admin-text-muted);
    }
    .logo-preview {
        display: inline-flex; align-items: center; justify-content: center;
        padding: var(--sp-sm); border: 1px dashed var(--admin-border);
        border-radius: var(--admin-radius-sm); margin-bottom: var(--sp-sm);
        background: var(--admin-surface-hover); min-height: 48px;
    }
    .social-input-group {
        display: flex; align-items: center; gap: 0;
    }
    .social-input-prefix {
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; flex-shrink: 0;
        border: 1px solid var(--admin-border);
        border-right: none; border-radius: var(--admin-radius-sm) 0 0 var(--admin-radius-sm);
        background: var(--admin-surface-hover); color: var(--admin-text-muted);
    }
    .social-input-prefix svg { width: 18px; height: 18px; }
    .social-input-group .form-control {
        border-radius: 0 var(--admin-radius-sm) var(--admin-radius-sm) 0;
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    {{-- Identitas Website --}}
    <div class="card" style="margin-bottom:var(--sp-xl);">
        <div class="card-body">
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon settings-section-icon--brand">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <div class="settings-section-title">Identitas Website</div>
                        <div class="settings-section-desc">Nama, tagline, deskripsi, logo, dan favicon</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Website</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi Website</label>
                    <textarea name="site_description" class="form-control" rows="3" placeholder="Deskripsi lengkap tentang website...">{{ $settings['site_description'] }}</textarea>
                    <div class="form-hint">Ditampilkan di halaman "Tentang Kami" dan meta tag.</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Logo Website</label>
                        @if($settings['site_logo'])
                            <div class="logo-preview">
                                <img src="{{ asset($settings['site_logo']) }}" style="max-height:36px;">
                            </div>
                        @endif
                        <input type="file" name="site_logo" class="form-control" accept="image/*">
                        <div class="form-hint">Format PNG/SVG transparan. Tinggi disarankan 40px.</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Favicon</label>
                        @if($settings['site_favicon'])
                            <div class="logo-preview">
                                <img src="{{ asset($settings['site_favicon']) }}" style="max-height:24px;">
                            </div>
                        @endif
                        <input type="file" name="site_favicon" class="form-control" accept="image/*">
                        <div class="form-hint">Format ICO/PNG, ukuran 32×32 atau 64×64.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Kontak & Kantor --}}
    <div class="card" style="margin-bottom:var(--sp-xl);">
        <div class="card-body">
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon settings-section-icon--contact">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <div class="settings-section-title">Kontak & Kantor Redaksi</div>
                        <div class="settings-section-desc">Email, telepon, fax, WhatsApp, dan alamat redaksi</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Redaksi</label>
                        <input type="email" name="office_email" class="form-control" value="{{ $settings['office_email'] }}" placeholder="redaksi@nusakini.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="office_whatsapp" class="form-control" value="{{ $settings['office_whatsapp'] }}" placeholder="+62 811-xxxx-xxxx">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="office_phone" class="form-control" value="{{ $settings['office_phone'] }}" placeholder="(021) 555-xxxx">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fax</label>
                        <input type="text" name="office_fax" class="form-control" value="{{ $settings['office_fax'] }}" placeholder="(021) 555-xxxx">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Kantor Redaksi</label>
                    <textarea name="office_address" class="form-control" rows="2" placeholder="Jl. ...">{{ $settings['office_address'] }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Media Sosial --}}
    <div class="card" style="margin-bottom:var(--sp-xl);">
        <div class="card-body">
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon settings-section-icon--social">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    <div>
                        <div class="settings-section-title">Media Sosial</div>
                        <div class="settings-section-desc">Link akun media sosial yang ditampilkan di footer website</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Facebook</label>
                        <div class="social-input-group">
                            <div class="social-input-prefix">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <input type="url" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] }}" placeholder="https://facebook.com/...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Twitter / X</label>
                        <div class="social-input-group">
                            <div class="social-input-prefix">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </div>
                            <input type="url" name="twitter_url" class="form-control" value="{{ $settings['twitter_url'] }}" placeholder="https://x.com/...">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Instagram</label>
                    <div class="social-input-group">
                        <div class="social-input-prefix">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </div>
                        <input type="url" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] }}" placeholder="https://instagram.com/...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lainnya --}}
    <div class="card" style="margin-bottom:var(--sp-xl);">
        <div class="card-body">
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon settings-section-icon--misc">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <div class="settings-section-title">Lainnya</div>
                        <div class="settings-section-desc">Link e-Paper dan fitur tambahan</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Link e-Paper</label>
                    <input type="url" name="epaper_link" class="form-control" value="{{ $settings['epaper_link'] }}" placeholder="https://epaper.nusakini.com/...">
                    <div class="form-hint">Link ke edisi e-Paper terbaru. Ditampilkan di navigasi website.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- SEO --}}
    <div class="card" style="margin-bottom:var(--sp-xl);">
        <div class="card-body">
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon settings-section-icon--seo">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div>
                        <div class="settings-section-title">SEO & Meta</div>
                        <div class="settings-section-desc">Konfigurasi untuk optimasi mesin pencari</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3" placeholder="Deskripsi singkat website untuk hasil pencarian Google...">{{ $settings['meta_description'] }}</textarea>
                    <div class="form-hint">Ideal 150–160 karakter. Tampil di hasil pencarian Google.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" value="{{ $settings['meta_keywords'] }}" placeholder="berita, indonesia, terkini, nasional">
                    <div class="form-hint">Pisahkan dengan koma.</div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:var(--sp-sm);">
        <button type="submit" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Pengaturan
        </button>
    </div>
</form>
@endsection
