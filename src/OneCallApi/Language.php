<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi;

class Language
{
    public const MAP = [
        'af'    => 'Afrikaans',
        'al'    => 'Albanian',
        'ar'    => 'Arabic',
        'az'    => 'Azerbaijani',
        'bg'    => 'Bulgarian',
        'ca'    => 'Catalan',
        'cz'    => 'Czech',
        'da'    => 'Danish',
        'de'    => 'German',
        'el'    => 'Greek',
        'en'    => 'English',
        'eu'    => 'Basque',
        'fa'    => 'Persian (Farsi)',
        'fi'    => 'Finnish',
        'fr'    => 'French',
        'gl'    => 'Galician',
        'he'    => 'Hebrew',
        'hi'    => 'Hindi',
        'hr'    => 'Croatian',
        'hu'    => 'Hungarian',
        'id'    => 'Indonesian',
        'it'    => 'Italian',
        'ja'    => 'Japanese',
        'kr'    => 'Korean',
        'la'    => 'Latvian',
        'lt'    => 'Lithuanian',
        'mk'    => 'Macedonian',
        'no'    => 'Norwegian',
        'nl'    => 'Dutch',
        'pl'    => 'Polish',
        'pt'    => 'Portuguese',
        'pt_br' => 'Português Brasil',
        'ro'    => 'Romanian',
        'ru'    => 'Russian',
        'sv'    => 'Swedish',
        'se'    => 'Swedish',
        'sk'    => 'Slovak',
        'sl'    => 'Slovenian',
        'sp'    => 'Spanish',
        'es'    => 'Spanish',
        'sr'    => 'Serbian',
        'th'    => 'Thai',
        'tr'    => 'Turkish',
        'ua'    => 'Ukrainian',
        'uk'    => 'Ukrainian',
        'vi'    => 'Vietnamese',
        'zh_cn' => 'Chinese Simplified',
        'zh_tw' => 'Chinese Traditional',
        'zu'    => 'Zulu',
    ];

    private string $language;

    public function __construct(string $language)
    {
        $this->language = $language;
    }

    public function get(): string
    {
        return $this->language;
    }
}
