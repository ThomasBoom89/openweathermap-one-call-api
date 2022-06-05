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
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely as MinutelyValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Timezone;

/**
 * @phpstan-type MinutelyArray array<int,array{'dt': int, 'timezone_offset': int, 'precipitation': float}>
 */
class Minutely implements Builder, Timezone
{
    private Minute $minute;
    private int    $timezone;

    public function __construct(Minute $minute)
    {
        $this->minute = $minute;
    }

    /**
     * @noinspection PhpDocSignatureInspection
     * @param MinutelyArray $data
     */
    public function build(array $data): MinutelyValue
    {
        $minutes = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $this->timezone;
            $minutes[]               = $this->minute->build($item);
        }

        return new MinutelyValue($minutes);
    }

    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }
}
