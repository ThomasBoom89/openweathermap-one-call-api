<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Hourly as HourlyValue;

class Hourly implements Builder
{
    private Hour $hour;

    public function __construct(Hour $hour)
    {
        $this->hour = $hour;
    }

    public function build(array $data): HourlyValue
    {
        $timeZoneOffset = $data['timezone_offset'];
        unset($data['timezone_offset']);
        $hours = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $timeZoneOffset;
            $hours[]                 = $this->hour->build($item);
        }

        return new HourlyValue($hours);
    }
}
