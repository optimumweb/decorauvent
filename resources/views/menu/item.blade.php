<li>
    <a
        href="{{ $item->href }}"
        class="{{ $item->metadata['class'] ?? '' }}"
        rel="{{ $item->metadata['rel'] ?? '' }}"
        target="{{ $item->metadata['target'] ?? '_self' }}"
    >
        <span>{!! $item !!}</span>
        @if ($item->children->count() > 0)
            <span class="icon"><i class="fa-solid fa-xs fa-chevron-down"></i></span>
        @endif
    </a>

    @if ($item->children->count() > 0)
        <ul>
            @foreach($item->children as $child)
                @include('menu.item', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>