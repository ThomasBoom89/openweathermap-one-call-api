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

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use ArrayIterator;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely\Minute;

/**
 * @extends ArrayIterator<int, Minute>
 */
class Minutely extends ArrayIterator
{
    public function current(): Minute
    {
        return parent::current();
    }
}
