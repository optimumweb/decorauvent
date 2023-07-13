<header id="site-header">
    <section id="site-header-top" class="section is-small is-primary is-inverted">
        <div class="container">
            <div class="columns is-mobile is-vcentered">
                <div class="column">
                    {!! $site->menu('top')->render([
                        'class' => 'is-primary',
                        'label' => $site->trans('common.menu.top.label'),
                    ]) !!}
                </div>

                <div class="column is-narrow">
                    <div class="field is-grouped">
                        @if ($businessPhone = $site->theme()->setting('business_phone'))
                            <div class="control">
                                <span class="icon"><i class="fa-solid fa-phone"></i></span>
                                <span>{{ $businessPhone }}</span>
                            </div>
                        @endif

                        @forelse ($translations ?? [] as $translation)
                            @isset($translation->locale)
                                <div class="control site-translation">
                                    <a
                                        rel="alternate"
                                        href="{{ $translation->url ?? $translation->locale->url }}"
                                        hreflang="{{ $translation->locale->name }}"
                                        title="{{ $translation }}"
                                    >
                                        <span class="icon"><i class="fa-solid fa-comment"></i></span>
                                        <span>{{ $translation->locale }}</span>
                                    </a>
                                </div>
                            @endif
                        @empty
                            @foreach ($site->alternateLocales()->get() as $locale)
                                <div class="control site-alternate-locale">
                                    <a
                                        rel="alternate"
                                        href="{{ $locale->url }}"
                                        hreflang="{{ $locale->name }}"
                                    >
                                        <span class="icon"><i class="fa-solid fa-comment"></i></span>
                                        <span>{{ $locale }}</span>
                                    </a>
                                </div>
                            @endforeach
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="site-header-main" class="section">
        <div class="container">
            <div class="columns is-mobile is-vcentered">
                <div class="column">
                    @if ($logo = $site->theme()->setting('logo'))
                        <h1 id="site-logo">
                            <a href="{{ $site->path() }}">
                                <img
                                    src="{{ storageUrl($logo) }}"
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
                    {!! $site->menu('primary')->render([
                        'class' => 'is-centered',
                        'label' => $site->trans('common.menu.primary.label'),
                    ]) !!}
                </div>
            </div>
        </div>
    </section>
</header>
