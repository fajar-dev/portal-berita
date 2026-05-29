@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('header_title', 'Detail Pesan')
@section('content')
<div class="card">
    <div class="card-body">
        <div style="margin-bottom:24px;">
            <div style="font-size:.78rem;color:var(--admin-text-muted);margin-bottom:4px;">Dari</div>
            <div style="font-weight:600;">{{ $contact->name }} &lt;{{ $contact->email }}&gt;</div>
        </div>
        <div style="margin-bottom:24px;">
            <div style="font-size:.78rem;color:var(--admin-text-muted);margin-bottom:4px;">Subjek</div>
            <div style="font-weight:600;">{{ $contact->subject }}</div>
        </div>
        <div style="margin-bottom:24px;">
            <div style="font-size:.78rem;color:var(--admin-text-muted);margin-bottom:4px;">Tanggal</div>
            <div>{{ $contact->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div style="margin-bottom:24px;">
            <div style="font-size:.78rem;color:var(--admin-text-muted);margin-bottom:4px;">Pesan</div>
            <div style="line-height:1.7;padding:16px;background:var(--admin-surface-hover);border-radius:var(--admin-radius-sm);">{{ $contact->message }}</div>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>
@endsection
