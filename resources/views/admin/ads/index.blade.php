@extends('layouts.admin')
@section('title', 'Iklan')
@section('header_title', 'Manajemen Iklan')

@section('content')
<div class="card" style="margin-bottom:var(--sp-xl);">
    <div class="card-header">
        <h2>Slot Iklan Website</h2>
        <span class="badge badge-info">4 Posisi</span>
    </div>
    <div class="card-body" style="padding:var(--sp-lg);">
        <p style="color:var(--admin-text-muted);font-size:var(--fs-base);margin-bottom:var(--sp-xl);">
            Kelola gambar iklan pada setiap posisi. Aktifkan atau nonaktifkan iklan sesuai kebutuhan.
        </p>

        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:var(--sp-lg);">
            @foreach($ads as $ad)
            <div style="border:1px solid var(--admin-border);border-radius:var(--admin-radius);overflow:hidden;background:var(--admin-surface);">
                {{-- Preview Image --}}
                <div style="position:relative;width:100%;height:140px;background:var(--admin-surface-hover);display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    @if($ad->image_url)
                        <img src="{{ asset($ad->image_url) }}" alt="{{ $ad->title }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="text-align:center;color:var(--admin-text-muted);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:32px;height:32px;opacity:.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <div style="font-size:var(--fs-xs);margin-top:4px;">Belum ada gambar</div>
                        </div>
                    @endif
                    <div style="position:absolute;top:8px;right:8px;">
                        @if($ad->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-muted">Nonaktif</span>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div style="padding:var(--sp-md) var(--sp-lg);">
                    <div style="display:flex;align-items:center;gap:var(--sp-sm);margin-bottom:var(--sp-xs);">
                        <span class="badge badge-info" style="font-size:.65rem;">{{ strtoupper(str_replace('_', ' ', $ad->position->value ?? $ad->position)) }}</span>
                    </div>
                    <div style="font-weight:700;font-size:var(--fs-md);margin-bottom:2px;">{{ $ad->title }}</div>
                    @if($ad->target_url)
                        <div style="font-size:var(--fs-xs);color:var(--admin-text-muted);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $ad->target_url }}</div>
                    @endif
                </div>

                {{-- Action --}}
                <div style="padding:0 var(--sp-lg) var(--sp-md);">
                    <a href="{{ route('admin.ads.edit', $ad) }}" class="btn btn-outline btn-sm" style="width:100%;justify-content:center;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Iklan
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
