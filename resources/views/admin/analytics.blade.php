@extends('layouts.admin')
@section('title', 'Analitik')
@section('header_title', 'Analitik Pengunjung')

@push('styles')
<style>
    .analytics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
    .a-stat {
        background: var(--admin-surface); border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius); padding: 20px;
        box-shadow: var(--admin-shadow-sm);
    }
    .a-stat-value { font-family: var(--admin-font-heading); font-size: 1.75rem; font-weight: 800; line-height: 1; }
    .a-stat-label { font-size: .8rem; color: var(--admin-text-secondary); margin-top: 6px; font-weight: 500; }
    .a-stat-sub { font-size: .72rem; color: var(--admin-text-muted); margin-top: 2px; }
    .chart-card { background: var(--admin-surface); border: 1px solid var(--admin-border); border-radius: var(--admin-radius); padding: 22px; box-shadow: var(--admin-shadow-sm); margin-bottom: 24px; }
    .chart-title { font-family: var(--admin-font-heading); font-weight: 700; font-size: .95rem; margin-bottom: 18px; }
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
    @media (max-width: 768px) { .two-col { grid-template-columns: 1fr; } }

    /* Mini bar chart via CSS */
    .bar-row { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
    .bar-label { width: 120px; font-size: .85rem; font-weight: 500; flex-shrink: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .bar-track { flex: 1; height: 24px; background: var(--admin-surface-hover); border-radius: 6px; overflow: hidden; position: relative; }
    .bar-fill { height: 100%; border-radius: 6px; transition: width .6s ease; }
    .bar-value { font-size: .78rem; font-weight: 700; color: var(--admin-text-secondary); min-width: 50px; text-align: right; }
</style>
@endpush

@section('content')
{{-- Overview Stats --}}
<div class="analytics-grid">
    <div class="a-stat">
        <div class="a-stat-value">{{ number_format($todayViews) }}</div>
        <div class="a-stat-label">Hari Ini</div>
    </div>
    <div class="a-stat">
        <div class="a-stat-value">{{ number_format($weekViews) }}</div>
        <div class="a-stat-label">Minggu Ini</div>
    </div>
    <div class="a-stat">
        <div class="a-stat-value">{{ number_format($monthViews) }}</div>
        <div class="a-stat-label">Bulan Ini</div>
    </div>
    <div class="a-stat">
        <div class="a-stat-value">{{ number_format($totalViews) }}</div>
        <div class="a-stat-label">Total Views</div>
    </div>
    <div class="a-stat">
        <div class="a-stat-value">{{ number_format($uniqueVisitors) }}</div>
        <div class="a-stat-label">Unique Visitors</div>
        <div class="a-stat-sub">Berdasarkan IP</div>
    </div>
</div>

{{-- 14-Day Chart --}}
<div class="chart-card">
    <div class="chart-title">Trafik 14 Hari Terakhir</div>
    <canvas id="trafficChart" height="80"></canvas>
</div>

<div class="two-col">
    {{-- Top Articles --}}
    <div class="card">
        <div class="card-header"><h2>Artikel Terpopuler</h2></div>
        <div class="card-body" style="padding:0;">
            <div class="table-wrap">
                <table class="admin-tbl">
                    <thead><tr><th>Judul</th><th style="text-align:right">Views</th></tr></thead>
                    <tbody>
                    @foreach($topArticles as $article)
                        <tr>
                            <td style="font-weight:500;">{{ Str::limit($article->title, 45) }}</td>
                            <td style="text-align:right;font-weight:700;font-family:var(--admin-font-heading);">{{ number_format($article->views) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Search Queries --}}
    <div class="card">
        <div class="card-header"><h2>Pencarian Populer</h2></div>
        <div class="card-body" style="padding:0;">
            <div class="table-wrap">
                <table class="admin-tbl">
                    <thead><tr><th>Kata Kunci</th><th style="text-align:right">Jumlah</th></tr></thead>
                    <tbody>
                    @forelse($topSearches as $s)
                        <tr>
                            <td style="font-weight:500;">{{ $s->query }}</td>
                            <td style="text-align:right;font-weight:700;font-family:var(--admin-font-heading);">{{ number_format($s->total) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" style="text-align:center;padding:30px;color:var(--admin-text-muted);">Belum ada data pencarian.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="two-col">
    {{-- Browsers --}}
    <div class="chart-card">
        <div class="chart-title">Browser</div>
        @php $browserMax = $browsers->max('total') ?: 1; @endphp
        @foreach($browsers as $b)
        <div class="bar-row">
            <span class="bar-label">{{ $b->browser }}</span>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ ($b->total / $browserMax) * 100 }}%;background:var(--admin-primary);opacity:{{ 0.4 + (($b->total / $browserMax) * 0.6) }};"></div>
            </div>
            <span class="bar-value">{{ number_format($b->total) }}</span>
        </div>
        @endforeach
        @if($browsers->isEmpty())
            <div style="text-align:center;padding:20px;color:var(--admin-text-muted);">Belum ada data.</div>
        @endif
    </div>

    {{-- Devices --}}
    <div class="chart-card">
        <div class="chart-title">Perangkat</div>
        @php $deviceMax = $devices->max('total') ?: 1; $deviceColors = ['Desktop' => '#2563eb', 'Mobile' => '#16a34a', 'Tablet' => '#f59e0b']; @endphp
        @foreach($devices as $d)
        <div class="bar-row">
            <span class="bar-label">{{ $d->device }}</span>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ ($d->total / $deviceMax) * 100 }}%;background:{{ $deviceColors[$d->device] ?? 'var(--admin-primary)' }};"></div>
            </div>
            <span class="bar-value">{{ number_format($d->total) }}</span>
        </div>
        @endforeach
        @if($devices->isEmpty())
            <div style="text-align:center;padding:20px;color:var(--admin-text-muted);">Belum ada data.</div>
        @endif
    </div>
</div>

{{-- Views by Category --}}
<div class="chart-card">
    <div class="chart-title">Views per Kategori</div>
    @php $catMax = $categoryViews->max('total_views') ?: 1; $catColors = ['politik-hukum'=>'#dc2626','ekonomi-bisnis'=>'#2563eb','teknologi-sains'=>'#7c3aed','gaya-hidup'=>'#16a34a','olahraga'=>'#f59e0b','internasional'=>'#0891b2']; @endphp
    @foreach($categoryViews as $cat)
    <div class="bar-row">
        <span class="bar-label">{{ $cat->category }}</span>
        <div class="bar-track">
            <div class="bar-fill" style="width:{{ ($cat->total_views / $catMax) * 100 }}%;background:{{ $catColors[$cat->category] ?? 'var(--admin-primary)' }};"></div>
        </div>
        <span class="bar-value">{{ number_format($cat->total_views) }}</span>
    </div>
    @endforeach
</div>

{{-- Reaction Analytics --}}
@php
    $reactionMeta = [
        'reactions_suka' => ['emoji' => '😍', 'label' => 'Suka', 'color' => '#dc2626'],
        'reactions_terkejut' => ['emoji' => '😲', 'label' => 'Terkejut', 'color' => '#f59e0b'],
        'reactions_inspiratif' => ['emoji' => '💡', 'label' => 'Inspiratif', 'color' => '#2563eb'],
        'reactions_sedih' => ['emoji' => '😢', 'label' => 'Sedih', 'color' => '#6b7280'],
    ];
@endphp

<div class="chart-card" style="margin-bottom:24px;">
    <div class="chart-title">Reaksi Pembaca</div>
    <div class="analytics-grid" style="margin-bottom:0;">
        @foreach($reactionMeta as $key => $meta)
        <div class="a-stat" style="text-align:center;border-color:{{ $meta['color'] }}20;">
            <div style="font-size:1.6rem;margin-bottom:4px;">{{ $meta['emoji'] }}</div>
            <div class="a-stat-value" style="color:{{ $meta['color'] }};">{{ number_format($reactionTotals[$key] ?? 0) }}</div>
            <div class="a-stat-label">{{ $meta['label'] }}</div>
            <div class="a-stat-sub">{{ $totalReactions > 0 ? round((($reactionTotals[$key] ?? 0) / $totalReactions) * 100, 1) : 0 }}%</div>
        </div>
        @endforeach
        <div class="a-stat" style="text-align:center;background:var(--admin-surface-hover);">
            <div style="font-size:1.6rem;margin-bottom:4px;">📊</div>
            <div class="a-stat-value">{{ number_format($totalReactions) }}</div>
            <div class="a-stat-label">Total Reaksi</div>
        </div>
    </div>
</div>

<div class="two-col">
    {{-- Reaction Chart --}}
    <div class="chart-card">
        <div class="chart-title">Distribusi Reaksi</div>
        <div style="max-width:280px;margin:0 auto;">
            <canvas id="reactionChart"></canvas>
        </div>
    </div>

    {{-- Top Reacted Articles --}}
    <div class="card">
        <div class="card-header"><h2>Artikel Paling Banyak Reaksi</h2></div>
        <div class="card-body" style="padding:0;">
            <div class="table-wrap">
                <table class="admin-tbl">
                    <thead><tr><th>Judul</th><th style="text-align:center;">😍</th><th style="text-align:center;">😲</th><th style="text-align:center;">💡</th><th style="text-align:center;">😢</th><th style="text-align:right;">Total</th></tr></thead>
                    <tbody>
                    @forelse($topReactedArticles as $ra)
                        <tr>
                            <td style="font-weight:500;">{{ Str::limit($ra->title, 35) }}</td>
                            <td style="text-align:center;font-weight:600;color:#dc2626;">{{ $ra->reactions_suka }}</td>
                            <td style="text-align:center;font-weight:600;color:#f59e0b;">{{ $ra->reactions_terkejut }}</td>
                            <td style="text-align:center;font-weight:600;color:#2563eb;">{{ $ra->reactions_inspiratif }}</td>
                            <td style="text-align:center;font-weight:600;color:#6b7280;">{{ $ra->reactions_sedih }}</td>
                            <td style="text-align:right;font-weight:700;font-family:var(--admin-font-heading);">{{ number_format($ra->total_reactions) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--admin-text-muted);">Belum ada reaksi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Traffic Chart
    const ctx = document.getElementById('trafficChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Total Views',
                    data: {!! json_encode($chartViews) !!},
                    borderColor: 'hsl(354, 70%, 48%)',
                    backgroundColor: 'hsla(354, 70%, 48%, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'hsl(354, 70%, 48%)',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Unique Visitors',
                    data: {!! json_encode($chartUnique) !!},
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.06)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    borderDash: [5, 5],
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 20, font: { family: "'Plus Jakarta Sans'", size: 12, weight: '600' } } },
                tooltip: { backgroundColor: '#1e2330', titleFont: { family: "'Plus Jakarta Sans'" }, bodyFont: { family: "'Plus Jakarta Sans'" }, padding: 12, cornerRadius: 8 }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { family: "'Plus Jakarta Sans'", size: 11 }, color: '#9ca0b0' } },
                y: { beginAtZero: true, grid: { color: '#f0f1f5' }, ticks: { font: { family: "'Plus Jakarta Sans'", size: 11 }, color: '#9ca0b0' } }
            }
        }
    });

    // Reaction Doughnut Chart
    const rctx = document.getElementById('reactionChart').getContext('2d');
    new Chart(rctx, {
        type: 'doughnut',
        data: {
            labels: ['😍 Suka', '😲 Terkejut', '💡 Inspiratif', '😢 Sedih'],
            datasets: [{
                data: [
                    {{ $reactionTotals['reactions_suka'] ?? 0 }},
                    {{ $reactionTotals['reactions_terkejut'] ?? 0 }},
                    {{ $reactionTotals['reactions_inspiratif'] ?? 0 }},
                    {{ $reactionTotals['reactions_sedih'] ?? 0 }}
                ],
                backgroundColor: ['#dc2626', '#f59e0b', '#2563eb', '#6b7280'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true, pointStyle: 'circle', padding: 16,
                        font: { family: "'Plus Jakarta Sans'", size: 12, weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: '#1e2330',
                    titleFont: { family: "'Plus Jakarta Sans'" },
                    bodyFont: { family: "'Plus Jakarta Sans'" },
                    padding: 12, cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.raw.toLocaleString() + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
