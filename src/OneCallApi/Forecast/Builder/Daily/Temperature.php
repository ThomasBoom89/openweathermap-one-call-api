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

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Daily;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily\Temperature as TemperatureValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Temperature implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array{
     *     'temp': array{
     *          'morn': float,
     *          'day': float,
     *          'eve': float,
     *          'night': float,
     *          'min': float,
     *          'max': float
     *      }
     * } $data
     */
    public function build(array $data): TemperatureValue
    {
        $temperatureData      = $data['temp'];
        $temperature          = new TemperatureValue();
        $temperature->morning = $temperatureData['morn'];
        $temperature->day     = $temperatureData['day'];
        $temperature->evening = $temperatureData['eve'];
        $temperature->night   = $temperatureData['night'];
        $temperature->min     = $temperatureData['min'];
        $temperature->max     = $temperatureData['max'];
        $temperature->unit    = $this->unit->getFromType('temperature');

        return $temperature;
    }
}
