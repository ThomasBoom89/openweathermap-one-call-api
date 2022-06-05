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
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Rain as RainValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Rain implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array{'rain'?: float|array{'1h': float}} $data
     */
    public function build(array $data): RainValue
    {
        $rain  = new RainValue();
        $value = $data['rain'] ?? 0.0;
        if (is_array($value)) {
            $value = $value['1h'];
        }
        $rain->value = $value;
        $rain->unit  = $this->unit->getFromType('precipitation');

        return $rain;
    }
}
