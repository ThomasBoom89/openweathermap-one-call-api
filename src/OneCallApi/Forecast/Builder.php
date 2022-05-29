<?php

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

interface Builder
{
    public function build(array $data);
}
