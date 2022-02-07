<?php

return [
    'prefix' => 'amp',

    // (optional)
    'view_affix' => '.amp',

    // (optional)
    'view_bool_name' => 'hasAmpUrl',

    // Use non-amp view if affixed view does not exists.
    'view_fallback' => false,

    'layouts' => [
        'amp::tag'
    ]
];
