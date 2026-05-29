@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('header_title', 'Pesan Kontak')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Semua Pesan</h2>
        @include('admin.partials.search', ['action' => route('admin.contacts.index'), 'placeholder' => 'Cari nama, email, subjek...'])
    </div>
    <div class="card-body--flush">
        <div class="table-wrap">
            <table class="admin-tbl">
                <thead><tr><th>Pengirim</th><th>Subjek</th><th>Tanggal</th><th class="td-actions">Aksi</th></tr></thead>
                <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>
                            <div class="td-title">{{ $contact->name }}</div>
                            <div class="td-sub">{{ $contact->email }}</div>
                        </td>
                        <td class="td-secondary">{{ Str::limit($contact->subject, 50) }}</td>
                        <td class="td-muted" style="white-space:nowrap;">{{ $contact->created_at->format('d M Y, H:i') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-outline btn-sm">Lihat</a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger-outline btn-sm">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">{{ request('q') ? 'Tidak ditemukan hasil untuk "'.request('q').'".' : 'Belum ada pesan masuk.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $contacts->links('vendor.pagination.admin') }}
</div>
@endsection
