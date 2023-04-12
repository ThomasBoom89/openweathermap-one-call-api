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
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Snow as SnowValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

use function array_key_exists;
use function is_float;

/**
 * @phpstan-type BuildDataVariantOne array{'snow'?: float}
 * @phpstan-type BuildDataVariantTwo array{'snow'?: array{'1h': float}}
 */
class Snow implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array<BuildDataVariantOne|BuildDataVariantTwo> $data
     */
    public function build(array $data): SnowValue
    {
        $snow  = new SnowValue();
        $value = $data['snow'] ?? 0.0;
        if (!is_float($value) && array_key_exists('snow', $data) && array_key_exists('1h', $data['snow'])) {
            $value = $data['snow']['1h'];
        }
        $snow->value = $value;
        $snow->unit  = $this->unit->getFromType('precipitation');

        return $snow;
    }
}
