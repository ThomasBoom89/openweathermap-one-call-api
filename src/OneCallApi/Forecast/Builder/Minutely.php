<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely as MinutelyValue;

class Minutely implements Builder
{
    private Minute $minute;

    public function __construct(Minute $minute)
    {
        $this->minute = $minute;
    }

    public function build(array $data): MinutelyValue
    {
        $timeZoneOffset = $data['timezone_offset'];
        unset($data['timezone_offset']);
        $minutes = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $timeZoneOffset;
            $minutes[]               = $this->minute->build($item);
        }

        return new MinutelyValue($minutes);
    }
}
