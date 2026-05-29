@extends('layouts.admin')
@section('title', 'Hasil Polling')
@section('header_title', 'Hasil Polling')

@push('styles')
<style>
    .poll-question {
        font-family: var(--admin-font-heading);
        font-size: 1.1rem; font-weight: 700;
        margin-bottom: var(--sp-xl);
        line-height: 1.5;
    }
    .poll-stats {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: var(--sp-md); margin-bottom: var(--sp-2xl);
    }
    .poll-stat-card {
        background: var(--admin-surface-hover);
        border-radius: var(--admin-radius-sm);
        padding: var(--sp-lg);
        text-align: center;
    }
    .poll-stat-value {
        font-family: var(--admin-font-heading);
        font-size: 1.6rem; font-weight: 800; line-height: 1;
    }
    .poll-stat-label {
        font-size: var(--fs-sm); color: var(--admin-text-muted);
        margin-top: var(--sp-xs);
    }
    .poll-option {
        margin-bottom: var(--sp-lg);
    }
    .poll-option-header {
        display: flex; justify-content: space-between; align-items: baseline;
        margin-bottom: 6px;
    }
    .poll-option-label {
        font-size: var(--fs-md); font-weight: 600;
    }
    .poll-option-meta {
        font-size: var(--fs-sm); color: var(--admin-text-muted);
        font-weight: 600;
    }
    .poll-option-bar {
        width: 100%; height: 28px;
        background: var(--admin-surface-hover);
        border-radius: 6px; overflow: hidden;
        position: relative;
    }
    .poll-option-fill {
        height: 100%; border-radius: 6px;
        transition: width 0.8s ease;
        display: flex; align-items: center;
        padding-left: 10px;
        font-size: var(--fs-xs); font-weight: 700; color: #fff;
        min-width: fit-content;
    }
    .poll-color-1 { background: var(--admin-primary); }
    .poll-color-2 { background: var(--admin-info); }
    .poll-color-3 { background: var(--admin-success); }
    .poll-color-4 { background: var(--admin-warning); }
</style>
@endpush

@section('content')
<div style="margin-bottom:var(--sp-lg);">
    <a href="{{ route('admin.polls.index') }}" class="btn btn-outline btn-sm">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div class="card" style="margin-bottom:var(--sp-xl);">
    <div class="card-header">
        <h2>Hasil Polling</h2>
        <div>
            @if($poll->is_active)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-muted">Nonaktif</span>@endif
        </div>
    </div>
    <div class="card-body">
        <div class="poll-question">{{ $poll->question }}</div>

        <div class="poll-stats">
            <div class="poll-stat-card">
                <div class="poll-stat-value" style="color:var(--admin-primary);">{{ number_format($totalVotes) }}</div>
                <div class="poll-stat-label">Total Suara</div>
            </div>
            @foreach($options as $i => $opt)
            <div class="poll-stat-card">
                <div class="poll-stat-value">{{ number_format($opt['votes']) }}</div>
                <div class="poll-stat-label">{{ Str::limit($opt['label'], 20) }}</div>
            </div>
            @endforeach
        </div>

        @foreach($options as $i => $opt)
        <div class="poll-option">
            <div class="poll-option-header">
                <span class="poll-option-label">{{ $opt['label'] }}</span>
                <span class="poll-option-meta">{{ $opt['votes'] }} suara ({{ $opt['percent'] }}%)</span>
            </div>
            <div class="poll-option-bar">
                <div class="poll-option-fill poll-color-{{ $i + 1 }}" style="width: {{ max($opt['percent'], 2) }}%;">
                    @if($opt['percent'] >= 8){{ $opt['percent'] }}%@endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Recent Votes --}}
<div class="card">
    <div class="card-header"><h2>Suara Terakhir (20)</h2></div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Opsi Dipilih</th><th>IP Address</th><th>Waktu</th></tr></thead>
                <tbody>
                @forelse($recentVotes as $vote)
                    <tr>
                        <td>
                            @php
                                $optLabel = $poll->{$vote->option_key} ?? $vote->option_key;
                            @endphp
                            <span class="badge badge-info">{{ $optLabel }}</span>
                        </td>
                        <td class="td-muted">{{ $vote->ip_address }}</td>
                        <td class="td-muted">{{ \Carbon\Carbon::parse($vote->created_at)->format('d M Y, H:i:s') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty-state">Belum ada suara masuk.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
