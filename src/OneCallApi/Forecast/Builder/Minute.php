<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely\Minute as MinuteValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Minute implements Builder
{
    use Calculator;

    private Precipitation $precipitation;

    public function __construct(Precipitation $precipitation)
    {
        $this->precipitation = $precipitation;
    }

    public function build(array $data): MinuteValue
    {
        $minute                = new MinuteValue();
        $minute->precipitation = $this->precipitation->build($data);
        $minute->dateTime      = $this->getDateTime($data['dt'], $data['timezone_offset']);

        return $minute;
    }
}
