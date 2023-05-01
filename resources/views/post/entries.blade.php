@extends('layouts.default', [
    'meta' => [
        'title' => $site->trans('common.advice'),
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
                        {{ $site->trans('common.advice') }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                @foreach ($entries->paginate() as $entry)
                    <div class="column is-4">
                        @include('partials.post-preview')
                    </div>
                @endforeach
            </div>

            {{ $entries->appends(request()->input())->links('partials.pagination') }}
        </div>
    </section>
@endsection
