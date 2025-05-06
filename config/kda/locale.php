<?php

// config for KDA/Laravel\Locale
return [
    'fallback' => 'fr',
    'available' => ['en', 'fr', 'de', 'it', 'rm'],
    'flags' => [
        'en' => 'en.svg', // Drapeau du Royaume-Uni pour l'anglais
        'fr' => 'fr.svg', // Drapeau de la France
        'de' => 'de.svg', // Drapeau de l'Allemagne
        'it' => 'it.svg', // Drapeau de l'Italie
        'rm' => 'rm.svg', // Drapeau romanche
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
