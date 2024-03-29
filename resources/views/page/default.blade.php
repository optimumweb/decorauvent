@extends('layouts.default', [
    'meta' => [
        'title' => $entry->title,
        'description' => $entry->summary,
        'canonical' => $entry->url,
    ],
])

@section('content')
    <section
        class="section is-primary {{ isset($entry->cover) ? 'is-cover is-large' : '' }} is-inverted"
        style="{{ isset($entry->cover) ? "background-image: url({$entry->cover->url});" : '' }}"
    >
        <div class="overlay is-primary"></div>

        <div class="container">
            <div class="columns">
                <div class="column is-6">
                    <h1 class="title is-1">
                        {{ $entry->title }}
                    </h1>

                    <p class="lead">
                        {{ $entry->summary }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {!! $entry->html !!}
@endsection
