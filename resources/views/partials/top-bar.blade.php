<section id="top-bar" class="section is-small is-primary is-inverted">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    {!! $site->menu('top') !!}
                </div>
            </div>

            <div class="level-right">
                @if ($businessPhone = $site->setting('business_phone'))
                    <div class="level-item">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <span>{{ $businessPhone }}</span>
                    </div>
                @endif

                <div class="level-item">
                    <div class="field is-grouped">
                        @forelse ($translations ?? [] as $translation)
                            @isset($translation->locale)
                                <div class="control">
                                    <a
                                        href="{{ $translation->url ?? $translation->locale->url }}"
                                        hreflang="{{ $translation->locale->name }}"
                                        title="{{ $translation }}"
                                    >
                                        {{ $translation->locale }}
                                    </a>
                                </div>
                            @endif
                        @empty
                            @foreach ($site->alternateLocales()->get() as $locale)
                                <div class="control">
                                    <a
                                        href="{{ $locale->url }}"
                                        hreflang="{{ $locale->name }}"
                                    >
                                        {{ $locale }}
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
