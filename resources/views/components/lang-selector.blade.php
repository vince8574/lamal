@php
    use KDA\Laravel\Locale\Facades\LocaleManager;
    $langs = LocaleManager::getAvailableLocales();
@endphp
@foreach ($langs as $lang)
    <a href="{{ lang_url($lang) }}" @class([
        'underline' => $lang === app()->getLocale(),
    ])>{{ $lang }}</a>
@endforeach
