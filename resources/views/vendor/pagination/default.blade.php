@if ($paginator->hasPages())
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <p><span>&lsaquo;</span></p>
        @else
            <p><a href="{{ $paginator->previousPageUrl() }}"><span>&lsaquo;</span></a></p>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <p><span>{{ $element }}</span></p>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <p class="current"><span>{{ $page }}</span></p>
                    @else
                        <p><a href="{{ $url }}"><span>{{ $page }}</span></a></p>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <p><a href="{{ $paginator->nextPageUrl() }}"><span>&rsaquo;</span></a></p>

        @else
            <p><span>&rsaquo;</span></p>
        @endif
    </ul>
@endif
