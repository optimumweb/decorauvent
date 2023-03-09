@if ($paginator->hasPages())
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        <a
            class="pagination-previous {{ $paginator->onFirstPage() ? 'is-disabled' : '' }}"
            href="{{ !$paginator->onFirstPage() ? $paginator->previousPageUrl() : '#' }}"
            rel="prev"
            aria-label="@lang('pagination.previous')"
        >
            <span class="icon"><i class="fa-light fa-angle-left"></i></span>
        </a>

        <a
            class="pagination-next {{ !$paginator->hasMorePages() ? 'is-disabled' : '' }}"
            href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}"
            rel="next"
            aria-label="@lang('pagination.next')"
        >
            <span class="icon"><i class="fa-light fa-angle-right"></i></span>
        </a>

        <ul class="pagination-list">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <a class="pagination-link">{{ $element }}</a>
                    </li>
                @elseif (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a
                                class="pagination-link {{ $page == $paginator->currentPage() ? 'is-current' : '' }}"
                                href="{{ $url }}"
                            >
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
