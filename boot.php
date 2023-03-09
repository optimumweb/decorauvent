<?php

Parser::registerShortcode('recent-entries', function (array $parameters = []) {
    $query = site()->entries()->orderBy('published_at', 'desc');

    if (isset($parameters['type'])) {
        $query->byType($parameters['type']);
    }

    if (isset($parameters['count'])) {
        $query->take($parameters['count']);
    }

    return view('shortcodes.recent-entries', [
        'entries' => $query->get(),
    ]);
});
