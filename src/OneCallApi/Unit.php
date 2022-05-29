<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi;

class Unit
{
    public const   MAP      = [self::DEFAULT => true, self::METRIC => true, self::IMPERIAL => true];

    public const DEFAULT    = 'standard';
    public const   METRIC   = 'metric';
    public const   IMPERIAL = 'imperial';

    private const  KNOWN_UNITS = [
        self::DEFAULT  => [
            'temperature' => 'K',
            'speed'       => 'meter/sec'
        ],
        self::METRIC   => [
            'temperature' => '°C',
            'speed'       => 'meter/sec'
        ],
        self::IMPERIAL => [
            'temperature' => '°F',
            'speed'       => 'miles/hour'
        ]
    ];

    private string $unit;

    public function __construct(string $unit)
    {
        $this->unit = $unit;
    }

    public function get(): string
    {
        return $this->unit;
    }

    public function getFromType(string $type): string
    {
        switch ($type) {
            case 'temperature':
                return self::KNOWN_UNITS[$this->unit]['temperature'];

            case 'speed':
            case 'gust':
                return self::KNOWN_UNITS[$this->unit]['speed'];

            case 'precipitation':
                return 'mm';

            case 'pressure':
                return 'hPa';

            case 'visibility':
                return 'm';

            case 'degree':
                return '°';

            case 'humidity':
            case 'probability':
            case 'cloudiness':
                return '%';
        }
    }
}
