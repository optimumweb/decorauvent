@extends('layouts.default', [
    'meta' => [
        'title' => $entryType,
    ],
])

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                @foreach ($entries->paginate() as $entry)
                    <div class="column is-4">
                        @include('partials.post-preview')
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
