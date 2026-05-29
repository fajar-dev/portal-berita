@extends('layouts.admin')
@section('title', isset($poll) ? 'Edit Polling' : 'Buat Polling')
@section('header_title', isset($poll) ? 'Edit Polling' : 'Buat Polling Baru')
@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ isset($poll) ? route('admin.polls.update', $poll) : route('admin.polls.store') }}" method="POST">
            @csrf
            @if(isset($poll)) @method('PUT') @endif
            <div class="form-group"><label class="form-label">Pertanyaan</label><input type="text" name="question" class="form-control" value="{{ old('question', $poll->question ?? '') }}" required></div>
            <div class="form-group"><label class="form-label">Opsi 1 *</label><input type="text" name="opt1" class="form-control" value="{{ old('opt1', $poll->opt1 ?? '') }}" required></div>
            <div class="form-group"><label class="form-label">Opsi 2 *</label><input type="text" name="opt2" class="form-control" value="{{ old('opt2', $poll->opt2 ?? '') }}" required></div>
            <div class="form-group"><label class="form-label">Opsi 3 (Opsional)</label><input type="text" name="opt3" class="form-control" value="{{ old('opt3', $poll->opt3 ?? '') }}"></div>
            <div class="form-group"><label class="form-label">Opsi 4 (Opsional)</label><input type="text" name="opt4" class="form-control" value="{{ old('opt4', $poll->opt4 ?? '') }}"></div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $poll->is_active ?? false) ? 'checked' : '' }} style="accent-color:var(--admin-primary);width:16px;height:16px;">
                    <span style="font-weight:600;font-size:.9rem;">Aktifkan polling ini</span>
                </label>
                <div class="form-hint">Hanya 1 polling yang bisa aktif. Mengaktifkan ini akan menonaktifkan polling lain.</div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">{{ isset($poll) ? 'Simpan' : 'Buat Polling' }}</button>
                <a href="{{ route('admin.polls.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
