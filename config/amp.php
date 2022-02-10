<?php

return [
    'prefix' => 'amp',

    // Affix for view filename.
    'view_affix' => '_amp',

    // Shared view variable indicating amp is available.
    'view_bool_name' => 'hasAmpUrl',

    // Use non-amp view if affixed view does not exists.
    'view_fallback' => false,

    // Shared view variable.
    'url' => 'ampUrl',

    'layouts' => [
        'amp::tag'
    ]
];
