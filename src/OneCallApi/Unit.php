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

enum Unit: string
{
    case Default  = 'standard';
    case Metric   = 'metric';
    case Imperial = 'imperial';

    public function getFromType(string $type): string
    {
        return match ($type) {
            'temperature'                           => $this->getUnitForTemperature(),
            'speed', 'gust'                         => $this->getUnitForSpeed(),
            'precipitation'                         => 'mm',
            'pressure'                              => 'hPa',
            'visibility'                            => 'm',
            'degree'                                => '°',
            'humidity', 'probability', 'cloudiness' => '%',
            default                                 => ''
        };
    }

    private function getUnitForTemperature(): string
    {
        return match ($this) {
            self::Default  => 'K',
            self::Metric   => '°C',
            self::Imperial => '°F'
        };
    }

    private function getUnitForSpeed(): string
    {
        return match ($this) {
            self::Default, self::Metric => 'meter/sec',
            self::Imperial              => 'miles/hour'
        };
    }
}
