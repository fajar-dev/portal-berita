@extends('layouts.admin')
@section('title', 'Subscriber')
@section('header_title', 'Newsletter Subscriber')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Subscriber ({{ $subscribers->total() }})</h2>
        @include('admin.partials.search', ['action' => route('admin.subscribers.index'), 'placeholder' => 'Cari email subscriber...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Email</th><th>Tanggal Daftar</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($subscribers as $sub)
                    <tr>
                        <td class="td-title">{{ $sub->email }}</td>
                        <td class="td-muted">{{ $sub->created_at->format('d M Y, H:i') }}</td>
                        <td class="td-actions">
                            <form action="{{ route('admin.subscribers.destroy', $sub) }}" method="POST" onsubmit="return confirm('Hapus subscriber ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada subscriber.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $subscribers->links('vendor.pagination.admin') }}
</div>
@endsection
