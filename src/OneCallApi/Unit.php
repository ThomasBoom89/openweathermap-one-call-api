<?php

/*
 * This file is part of Openweathermap One Call Api.
 *
 * (c) ThomasBoom89 <51998416+ThomasBoom89@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
        return match ($type) {
            'temperature'                           => self::KNOWN_UNITS[$this->unit]['temperature'],
            'speed', 'gust'                         => self::KNOWN_UNITS[$this->unit]['speed'],
            'precipitation'                         => 'mm',
            'pressure'                              => 'hPa',
            'visibility'                            => 'm',
            'degree'                                => '°',
            'humidity', 'probability', 'cloudiness' => '%',
            default                                 => '',
        };
    }
}
