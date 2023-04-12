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

use function array_key_exists;
use function is_float;

/**
 * @phpstan-type BuildDataVariantOne array{'rain'?: float}
 * @phpstan-type BuildDataVariantTwo array{'rain'?: array{'1h': float}}
 */
class Rain implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array<BuildDataVariantOne|BuildDataVariantTwo> $data
     */
    public function build(array $data): RainValue
    {
        $rain  = new RainValue();
        $value = $data['rain'] ?? 0.0;
        if (!is_float($value) && array_key_exists('rain', $data) && array_key_exists('1h', $data['rain'])) {
            $value = $data['rain']['1h'];
        }
        $rain->value = $value;
        $rain->unit  = $this->unit->getFromType('precipitation');

        return $rain;
    }
}
