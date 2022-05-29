<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi;

enum Unit: string
{
    case Default = 'standard';
    case Metric = 'metric';
    case Imperial = 'imperial';

    public function getFromType(string $type): string
    {
        switch ($type) {
            case 'temperature':
                return $this->getUnitForTemperature();

            case 'speed':
            case 'gust':
                return $this->getUnitForSpeed();

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
