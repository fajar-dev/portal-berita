@extends('layouts.admin')
@section('title', 'Polling')
@section('header_title', 'Manajemen Polling')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h2>Semua Polling</h2>
            <a href="{{ route('admin.polls.create') }}" class="btn btn-primary btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Polling
            </a>
        </div>
        @include('admin.partials.search', ['action' => route('admin.polls.index'), 'placeholder' => 'Cari pertanyaan polling...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Pertanyaan</th><th>Votes</th><th>Status</th><th>Tanggal</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($polls as $poll)
                    <tr>
                        <td class="td-title">{{ Str::limit($poll->question, 55) }}</td>
                        <td class="td-num">{{ number_format($voteCounts[$poll->id] ?? 0) }}</td>
                        <td>@if($poll->is_active)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-muted">Nonaktif</span>@endif</td>
                        <td class="td-muted">{{ $poll->created_at->format('d M Y') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.polls.show', $poll) }}" class="btn btn-outline btn-sm">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m6 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m4 0V5a2 2 0 012-2h2a2 2 0 012 2v14"/></svg>
                                Hasil
                            </a>
                            <a href="{{ route('admin.polls.edit', $poll) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.polls.destroy', $poll) }}" method="POST" onsubmit="return confirm('Hapus polling ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada polling.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $polls->links('vendor.pagination.admin') }}
</div>
@endsection
