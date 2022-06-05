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
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Visibility as VisibilityValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Visibility implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array{'visibility' : int} $data
     */
    public function build(array $data): VisibilityValue
    {
        $visibility        = new VisibilityValue();
        $visibility->value = $data['visibility'];
        $visibility->unit  = $this->unit->getFromType('visibility');

        return $visibility;
    }
}
