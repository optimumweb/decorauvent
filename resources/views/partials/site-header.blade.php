<header id="site-header" class="hero">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-mobile is-vcentered">
                <div class="column">
                    @if ($logo = $site->theme->setting('logo'))
                        <h1 id="site-logo">
                            <a href="{{ $site->path() }}">
                                <img
                                    src="{{ $logo }}"
                                    width="300"
                                    alt="{{ $site->name }} - {{ $site->description }}"
                                />
                            </a>
                        </h1>
                    @else
                        <div id="site-title">
                            <h1 id="site-name" class="title">
                                <a href="{{ $site->path() }}">
                                    {{ $site->name }}
                                </a>
                            </h1>

                            <h2 id="site-description">
                                {{ $site->description }}
                            </h2>
                        </div>
                    @endif
                </div>

                <div class="column is-narrow">
                    {!! $site->menu('primary')->render(['class' => 'is-centered']) !!}
                </div>
            </div>
        </div>
    </div>
</header>
