@extends('layouts.default', [
    'meta' => [
        'title' => $entry->title,
        'description' => $entry->summary,
    ],
])

@section('content')
    <article
        id="entry-{{ $entry->id }}"
        class="entry post"
        itemscope
        itemtype="https://schema.org/Article"
    >
        <section class="section is-primary is-inverted">
            <div class="overlay is-primary"></div>

            <div class="container">
                <hgroup class="block">
                    <h4 class="subtitle is-4">
                        <span>{{ $site->trans('common.advice') }}</span>
                        &nbsp;
                        <span class="has-text-purple">/ / /</span>
                    </h4>

                    <h1
                        class="title is-1 entry-title"
                        itemprop="headline"
                    >
                        {!! $entry->title !!}
                    </h1>
                </hgroup>

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
            </div>
        </section>

        <section class="section">
            <div class="container">
                @isset($entry->cover, $entry->cover->url)
                    <figure class="entry-cover image">
                        <img
                            src="{{ $entry->cover->url }}"
                            alt="{{ $entry->title }}"
                        />
                    </figure>
                @endisset
            </div>
        </section>

        <section class="section">
            <div class="container is-medium">
                <div
                    class="entry-content content"
                    itemprop="articleBody"
                >
                    {!! $entry->html !!}
                </div>
            </div>
        </section>
    </article>
@endsection
