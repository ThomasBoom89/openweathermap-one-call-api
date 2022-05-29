<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts as AlertsValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

class Alerts implements Builder
{
    private Alert $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    public function build(array $data): AlertsValue
    {
        $timeZoneOffset = $data['timezone_offset'];
        unset($data['timezone_offset']);
        $alertValues = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $timeZoneOffset;
            $alertValues[]           = $this->alert->build($item);
        }

        return new AlertsValue($alertValues);
    }
}
