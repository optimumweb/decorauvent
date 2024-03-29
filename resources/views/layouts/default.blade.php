<!DOCTYPE html>
<html lang="{{ $site->locale->name }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ $meta['title'] ?? $site->description }} - {{ $site->name }}</title>

        @foreach (['description', 'keywords', 'author'] as $metaName)
            @isset($meta[$metaName])
                <meta name="{{ $metaName }}" content="{{ $meta[$metaName] }}" />
            @endisset
        @endforeach

        @isset($meta['canonical'])
            <link rel="canonical" href="{{ $meta['canonical'] }}" />
        @endisset

        @isset($translations)
            @foreach ($translations as $translation)
                @isset($translation->url)
                    <link rel="alternate" hreflang="{{ $translation->locale->name }}" href="{{ $translation->url }}" />
                @endisset
            @endforeach
        @endisset

        @if ($favicon = $site->theme()->setting('favicon'))
            <link rel="icon" href="{{ storageUrl($favicon) }}" />
        @endif

        @if ($cookieYesSiteId = $site->theme()->setting('cookieyes_site_id'))
            <!-- Start cookieyes banner -->
            <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/{{ $cookieYesSiteId }}/script.js"></script>
            <!-- End cookieyes banner -->
        @endif

        @if ($googleTagManagerId = $site->theme()->setting('google_tag_manager_id'))
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{ $googleTagManagerId }}');</script>
            <!-- End Google Tag Manager -->
        @endif

        @if ($googleAnalyticsId = $site->theme()->setting('google_analytics_id'))
            <!-- Google tag (gtag.js) -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', '{{ $googleAnalyticsId }}');
            </script>
        @endif

        @if ($matomoEndpoint = $site->theme()->setting('matomo_endpoint'))
            @if ($matomoSiteId = $site->theme()->setting('matomo_site_id'))
                <!-- Matomo -->
                <script>
                    var _paq = window._paq = window._paq || [];
                    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
                    _paq.push(['trackPageView']);
                    _paq.push(['enableLinkTracking']);
                    (function() {
                        var u="{{ $matomoEndpoint }}";
                        _paq.push(['setTrackerUrl', u+'matomo.php']);
                        _paq.push(['setSiteId', '{{ $matomoSiteId }}']);
                        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
                    })();
                </script>
                <!-- End Matomo Code -->
            @endif
        @endif

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Condensed:wght@300;400;700&family=Sofia+Sans:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
        <!-- /Google Fonts -->

        <link rel="stylesheet" href="{{ $site->theme()->asset(path: 'css/theme.css', version: time()) }}">

        @if ($fontawesome = $site->theme()->config('fontawesome'))
            <!-- FontAwesome -->
            <script src="https://kit.fontawesome.com/{{ $fontawesome }}.js" crossorigin="anonymous"></script>
            <!-- /FontAwesome -->
        @endif

        <!-- AOS -->
        <link rel="stylesheet" href="{{ $site->theme()->asset('vendor/aos/aos.css') }}" />
        <script src="{{ $site->theme()->asset('vendor/aos/aos.js') }}"></script>
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
        <script src="{{ $site->theme()->asset('vendor/jquery/jquery.min.js') }}"></script>
        <!-- /jQuery -->

        <!-- stonehenge.js -->
        <link rel="stylesheet" href="{{ $site->theme()->asset('vendor/stonehenge.js/stonehenge.css') }}" />
        <script src="{{ $site->theme()->asset('vendor/stonehenge.js/stonehenge.js') }}"></script>
        <!-- /stonehenge.js -->

        @if ($grecaptchaSiteKey = $site->theme()->setting('grecaptcha_site_key'))
            <!-- Google reCAPTCHA v3 -->
            <meta name="grecaptcha-site-key" content="{{ $grecaptchaSiteKey }}" />
            <script src="https://www.google.com/recaptcha/api.js?render={{ $grecaptchaSiteKey }}"></script>
            <!-- /Google reCAPTCHA v3 -->
        @endif

        <!-- Theme JS -->
        <script src="{{ $site->theme()->asset(path: 'js/theme.js', version: time()) }}"></script>
        <!-- /Theme JS -->

        <!-- Header Code -->
        {!! $site->blocks('header_code')->get()->render() !!}
        <!-- /Header Code -->
    </head>
    <body>
        @include('partials.site-header')

        <main id="site-content">
            @yield('content')
        </main>

        @include('partials.site-footer')

        @include('partials.loading')

        <!-- Footer Code -->
        {!! $site->blocks('footer_code')->get()->render() !!}
        <!-- /Footer Code -->

        @isset($googleTagManagerId)
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $googleTagManagerId }}"
                              height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        @endisset
    </body>
</html>
