@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; border-top: 1px solid var(--color-border); padding-top: 25px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 8px 14px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-text-muted); pointer-events: none; opacity: 0.5;">
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 14px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-dark); transition: all 0.2s;">
                Sebelumnya
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="font-size: 0.82rem; color: var(--color-text-muted);">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--color-primary); color: #fff; border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; border: 1px solid var(--color-primary);">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-dark); transition: all 0.2s;">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 14px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-dark); transition: all 0.2s;">
                Berikutnya
            </a>
        @else
            <span style="padding: 8px 14px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--color-text-muted); pointer-events: none; opacity: 0.5;">
                Berikutnya
            </span>
        @endif
    </div>
@endif
