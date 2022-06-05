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

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily;

class Temperature
{
    public float  $morning;
    public float  $day;
    public float  $evening;
    public float  $night;
    public float  $min;
    public float  $max;
    public string $unit;
}
