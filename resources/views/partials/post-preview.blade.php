<article
    id="entry-{{ $entry->id }}"
    class="entry post block"
    itemscope
    itemtype="https://schema.org/Article"
>
    @isset($entry->cover, $entry->cover->url)
        <figure class="entry-cover image block">
            <a href="{!! $entry->url !!}">
                <img
                    src="{{ $entry->cover->url }}"
                    alt="{{ $entry->title }}"
                    loading="lazy"
                />
            </a>
        </figure>
    @endisset

    <h3
        class="title is-3 entry-title"
        itemprop="headline"
    >
        <a href="{!! $entry->url !!}">
            {!! $entry->title !!}
        </a>
    </h3>

    <div class="entry-meta level block">
        <div class="level-left">
            <div class="level-item">
                <span class="icon"><i class="fas fa-calendar"></i></span>

                <span
                    class="entry-published-at"
                    itemprop="datePublished"
                >
                    {{ $entry->published_at }}
                </span>
            </div>
        </div>
    </div>

    <div
        class="entry-preview content block"
        itemprop="articleBody"
    >
        {!! $entry->preview !!}
    </div>

    <div>
        <a href="{!! $entry->url !!}">
            <span>{{ site()->trans('common.readMore') }}</span>
            <span class="icon"><i class="fa-solid fa-arrow-right-long"></i></span>
        </a>
    </div>
</article>
