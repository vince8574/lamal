<?php

return [
    'dumps' => [
        'users',
        'age_ranges',
        'anonymous_users',
        'cantons',
        'primes',
        'franchises',
        'cards',
        'insurers',
        'profiles',
        'tariftypes',
        'cities',
        'municipalities',
        'districts',
    ],
    'database' => env('DB_DATABASE', ''),
    'exclude_tables' => [],
    'exclude_providers' => [],
    'refresh_env' => 'refresh',
    'dump_empty_seeds' => false,
    'disk' => 'dumps',
    'env_presets' => [

    ],
];
