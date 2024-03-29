<?php

/*
 * This file is part of Openweathermap One Call Api.
 *
 * (c) ThomasBoom89 <51998416+ThomasBoom89@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

interface Builder
{
    /**
     * @param mixed[] $data
     * @return mixed
     */
    public function build(array $data): mixed;
}
