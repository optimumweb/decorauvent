<!DOCTYPE html>
<html lang="{{ $site->locale->name }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $meta['title'] ?? $site->description }} - {{ $site->name }}</title>

        @foreach (['description', 'keywords', 'author'] as $metaName)
            @isset($meta[$metaName])
                <meta name="{{ $metaName }}" content="{{ $meta[$metaName] }}" />
            @endisset
        @endforeach

        @if ($favicon = $site->theme->setting('favicon'))
            <link rel="icon" href="{{ Storage::url($favicon) }}" />
        @endif

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Condensed:wght@300;400;700&family=Sofia+Sans:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
        <!-- /Google Fonts -->

        <link rel="stylesheet" href="{{ $site->theme->asset(path: 'css/theme.css', version: time()) }}">

        @if ($fontawesome = $site->theme->config('fontawesome'))
            <!-- FontAwesome -->
            <script src="https://kit.fontawesome.com/{{ $fontawesome }}.js" crossorigin="anonymous"></script>
            <!-- /FontAwesome -->
        @endif

        <!-- AOS -->
        <link rel="stylesheet" href="{{ $site->theme->asset('vendor/aos/aos.css') }}" />
        <script src="{{ $site->theme->asset('vendor/aos/aos.js') }}"></script>
        <noscript>
            <style type="text/css">
                [data-aos] {
                    opacity: 1 !important;
                    transform: translate(0) scale(1) !important;
                }
            </style>
        </noscript>
        <!-- /AOS -->

        <!-- jQuery -->
        <script src="{{ $site->theme->asset('vendor/jquery/jquery.min.js') }}"></script>
        <!-- /jQuery -->

        <!-- stonehenge.js -->
        <link rel="stylesheet" href="{{ $site->theme->asset('vendor/stonehenge.js/stonehenge.css') }}" />
        <script src="{{ $site->theme->asset('vendor/stonehenge.js/stonehenge.js') }}"></script>
        <!-- /stonehenge.js -->

        <!-- Theme JS -->
        <script src="{{ $site->theme->asset(path: 'js/theme.js', version: time()) }}"></script>
        <!-- /Theme JS -->

        <!-- Header Code -->
        {!! $site->blocks('header_code')->get()->render() !!}
        <!-- /Header Code -->
    </head>
    <body>
        @include('partials.top-bar')

        @include('partials.site-header')

        <main id="site-content">
            @yield('content')
        </main>

        @include('partials.site-footer')

        <!-- Footer Code -->
        {!! $site->blocks('footer_code')->get()->render() !!}
        <!-- /Footer Code -->
    </body>
</html>
