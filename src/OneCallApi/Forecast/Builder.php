<?php

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

interface Builder
{
    /**
     * @param mixed[] $data
     * @return mixed
     */
    public function build(array $data);
}
