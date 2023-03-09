<footer id="site-footer">
    <section id="footer-suppliers" class="section is-white-bis pl-0 pr-0">
        {!! $site->blocks('footer_suppliers')->get()->render() !!}
    </section>

    <section id="footer-cta" class="section is-purple is-inverted">
        {!! $site->blocks('footer_cta')->get()->render() !!}
    </section>

    <section id="footer-contact" class="section is-primary is-inverted">
        <div class="container">
            <div class="level">
                <div class="level-left">
                    @if ($logo = $site->setting('logo_inverted'))
                        <div class="level-item">
                            <a href="{{ $site->home() }}">
                                <img
                                    src="{{ Storage::url($logo) }}"
                                    width="200"
                                    alt="{{ $site->name }} - {{ $site->description }}"
                                />
                            </a>
                        </div>
                    @endif
                </div>

                <div class="level-right">
                    <div class="level-item">
                        <div class="columns is-variable is-8">
                            @if ($businessAddress = $site->setting('business_address'))
                                <div class="column is-narrow">
                                    <div class="media">
                                        <div class="media-left">
                                            <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                                        </div>

                                        <div class="media-content">
                                            <p>
                                                {!! nl2br($businessAddress) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="column is-narrow">
                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                                    </div>

                                    <div class="media-content">
                                        @if ($businessPhone = $site->setting('business_phone'))
                                            <p>
                                                {{ $businessPhone }}
                                            </p>
                                        @endif

                                        @if ($businessTollfree = $site->setting('business_tollfree'))
                                            <p>
                                                {{ $businessTollfree }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($businessEmail = $site->setting('business_email'))
                                <div class="column is-narrow">
                                    <div class="media">
                                        <div class="media-left">
                                            <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                                        </div>

                                        <div class="media-content">
                                            <p>
                                                <a href="mailto:{{ $businessEmail }}">{{ $businessEmail }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="footer-sub" class="section has-background-dark is-inverted">
        {!! $site->blocks('footer_sub')->get()->render() !!}
    </section>
</footer>
