<section id="top-bar" class="section is-small is-primary is-inverted">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    {!! $site->menu('top') !!}
                </div>
            </div>

            <div class="level-right">
                @if ($businessPhone = $site->theme->setting('business_phone'))
                    <div class="level-item">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <span>{{ $businessPhone }}</span>
                    </div>
                @endif

                <div class="level-item">
                    <div class="field is-grouped">
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
    </div>
</section>
