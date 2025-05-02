<?php

// config for KDA/Laravel\Locale
return [
    'fallback' => 'en',
    'available' => ['en', 'fr', 'de', 'it', 'rm'],
    'emojis' => [
        'en' => '🇬🇧', // Drapeau du Royaume-Uni pour l'anglais
        'fr' => '🇨🇭', // Drapeau de la France
        'de' => '🇩🇪', // Drapeau de l'Allemagne
        'it' => '🇮🇹', // Drapeau de l'Italie
    ],
    'querystring' => [
        'enabled' => true,
        'key' => 'lang'
    ],
    'cookie' => [
        'enabled' => true,
        "name" => 'laravel-locale-lang',
        'expiration' => 60
    ]
];
