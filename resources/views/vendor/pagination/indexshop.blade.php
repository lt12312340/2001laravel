@if ($paginator->hasPages())
<div class="fr page">
    <div class="sui-pagination pagination-large">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="prev disabled">
                    <a href="#">«上一页</a>
                </li>
            @else
                <li class="prev">
                    <a href="{{ $paginator->previousPageUrl() }}">«上一页</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="dotted"><span>...</span></li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="active">
                            <a href="#">{{ $page }}</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="next">
                    <a href="{{ $paginator->nextPageUrl() }}">下一页»</a>
                </li>
            @else
                <li class="next disabled">
                    <a href="#">下一页»</a>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif
