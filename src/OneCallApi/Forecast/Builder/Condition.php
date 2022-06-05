<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Condition as ConditionValue;

class Condition implements Builder
{
    public function build(array $data): ConditionValue
    {
        $weather                = $data['weather'][0];
        $condition              = new ConditionValue();
        $condition->identifier  = $weather['id'];
        $condition->main        = $weather['main'];
        $condition->description = $weather['description'];
        $condition->icon        = $weather['icon'];

        return $condition;
    }
}
