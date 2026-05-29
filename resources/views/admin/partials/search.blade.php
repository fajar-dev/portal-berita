<form method="GET" action="{{ $action }}" class="search-bar">
    <div class="search-bar-input">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder ?? 'Cari...' }}">
    </div>
    <button type="submit" class="btn btn-outline btn-sm">Cari</button>
    @if(request('q'))
        <a href="{{ $action }}" class="btn btn-ghost btn-sm" style="color:var(--admin-text-muted);">Reset</a>
    @endif
</form>
