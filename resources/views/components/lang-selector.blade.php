@php
    use KDA\Laravel\Locale\Facades\LocaleManager;
    $langs = LocaleManager::getAvailableLocales();

    // Mapping des langues vers les emoji de drapeaux correspondants
    $flagEmojis = [
        'en' => 'en.svg',
        'fr' => 'fr.svg',
        'de' => 'de.svg',
        'it' => 'it.svg',
        'rm' => 'rm.svg', // Drapeau suisse pour le romanche
    ];
@endphp

@foreach ($langs as $lang)
    <a href="{{ lang_url($lang) }}" @class([
        'flex items-center gap-2',
        'font-bold underline' => $lang === app()->getLocale(),
    ])>
        @if (isset($flagEmojis[$lang]))
            <img @class([
                'h-6 color-customWhite' => $lang === app()->getLocale(),
                'h-4' => $lang !== app()->getLocale(),
            ]) src="{{ asset('images/flags/' . $flagEmojis[$lang]) }}">
        @endif
        {{ $lang }}
    </a>
@endforeach
