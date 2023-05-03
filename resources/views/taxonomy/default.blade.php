@extends('layouts.default', [
    'meta' => [
        'title' => $taxonomy->title,
        'description' => $taxonomy->description,
    ],
])

@section('content')
    <section
        class="section is-primary is-inverted"
    >
        <div class="overlay is-primary"></div>

        <div class="container">
            <div class="columns">
                <div class="column is-6">
                    <h1 class="title is-1">
                        {{ $taxonomy->title }}
                    </h1>

                    <p class="lead">
                        {{ $taxonomy->summary }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
