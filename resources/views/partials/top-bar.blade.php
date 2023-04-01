<section id="top-bar" class="section is-small is-primary is-inverted">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    {!! $site->menu('top') !!}
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <div class="field is-grouped">
                        @foreach ($site->locales()->get() as $locale)
                            <div class="control">
                                <a
                                    href="{{ route('locale.home', ['locale' => $locale]) }}"
                                    hreflang="{{ $locale->name }}"
                                >
                                    <span class="icon"><i class="fa-solid {{ $locale->is($site->locale) ? 'fa-square-check has-text-purple' : 'fa-square' }}"></i></span>
                                    <span>{{ $locale->title }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
