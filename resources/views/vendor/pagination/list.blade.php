@if ($paginator->hasPages())
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <p><span>>{{ $element }}</span></p>
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
@endif
