@extends('layouts.default', [
    'meta' => [
        'title' => $entryType,
    ],
])

@section('content')
    <section class="section">
        <div class="container">
            {{ $entryType }}

            <ul>
                @foreach ($entries->paginate() as $entry)
                    <li>
                        {{ $entry }}
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
