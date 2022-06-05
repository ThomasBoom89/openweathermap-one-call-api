<?php

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

interface Timezone
{
    public function setTimezone(int $timezone): void;
}
