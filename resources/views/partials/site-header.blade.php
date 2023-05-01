<header id="site-header" class="hero">
    <div class="hero-body">
        <div class="container">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        @if ($logo = $site->setting('logo'))
                            <h1 id="site-logo">
                                <a href="{{ $site->path() }}">
                                    <img
                                        src="{{ Storage::url($logo) }}"
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
                </div>

                <div class="level-right">
                    <div class="level-item">
                        {!! $site->menu('primary') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
