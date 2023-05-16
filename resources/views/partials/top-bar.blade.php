<section id="top-bar" class="section is-small is-primary is-inverted">
    <div class="container">
        <div class="columns is-mobile is-vcentered">
            <div class="column">
                {!! $site->menu('top')->render(['class' => 'is-primary']) !!}
            </div>

            <div class="column is-narrow">
                <div class="field is-grouped">
                    @if ($businessPhone = $site->theme->setting('business_phone'))
                        <div class="control">
                            <span class="icon"><i class="fa-solid fa-phone"></i></span>
                            <span>{{ $businessPhone }}</span>
                        </div>
                    @endif

                    @forelse ($translations ?? [] as $translation)
                        @isset($translation->locale)
                            <div class="control site-translation">
                                <a
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
