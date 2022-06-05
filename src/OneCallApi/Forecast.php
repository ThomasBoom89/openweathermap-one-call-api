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

namespace Thomasboom89\OpenWeatherMap\OneCallApi;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Current;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Daily;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Hourly;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely;

class Forecast
{
    public Current  $current;
    public Minutely $minutely;
    public Hourly   $hourly;
    public Daily    $daily;
    public Alerts   $alerts;
}
