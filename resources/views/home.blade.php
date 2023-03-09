@extends('layouts.default')

@section('content')
    @if ($home = $site->entries()->home()->first())
        {!! $home->html !!}
    @endif
@endsection
