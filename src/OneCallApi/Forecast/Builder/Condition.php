<?php

/*
 * This file is part of Openweathermap One Call Api.
 *
 * (c) ThomasBoom89 <51998416+ThomasBoom89@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Condition as ConditionValue;

class Condition implements Builder
{
    /**
     * @param array{
     *     'weather': array{
     *          array{
     *              'id': int,
     *              'main': string,
     *              'description': string,
     *              'icon': string
     *          }
     *     }
     * } $data
     */
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
