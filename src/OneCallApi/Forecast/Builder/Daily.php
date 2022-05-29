<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Daily as DailyValue;

class Daily implements Builder
{

    private Day $day;

    public function __construct(Day $day)
    {
        $this->day = $day;
    }

    public function build(array $data): DailyValue
    {
        $timeZoneOffset = $data['timezone_offset'];
        unset($data['timezone_offset']);
        $days = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $timeZoneOffset;
            $days[]                  = $this->day->build($item);
        }

        return new DailyValue($days);
    }
}
