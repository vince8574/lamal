<?php

// config for KDA/Laravel\Locale
return [
    'fallback'=>'en',
    'available'=>['en','fr','de','it'],
    'querystring'=>[
        'enabled'=>true,
        'key'=>'lang'
    ],
    'cookie'=>[
        'enabled'=>true,
        "name"=>'laravel-locale-lang',
        'expiration'=>60
    ]
];
