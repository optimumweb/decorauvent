@extends('layouts.default')

@section('content')
    @if ($homePage = $site->homePage())
        {!! $homePage->html !!}
    @endif
@endsection
