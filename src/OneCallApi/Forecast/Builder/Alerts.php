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

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts as AlertsValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Timezone;

/**
 * @phpstan-type AlertsArray array<int, array{
 *     'sender_name': string,
 *     'event': string,
 *     'start': int,
 *     'end': int,
 *     'timezone_offset': int,
 *     'description': string,
 *     'tags': string[]
 * }>
 */
class Alerts implements Builder, Timezone
{
    private Alert $alert;
    private int   $timezone;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * @noinspection PhpDocSignatureInspection
     * @param AlertsArray $data
     */
    public function build(array $data): AlertsValue
    {
        $alertValues = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $this->timezone;
            $alertValues[]           = $this->alert->build($item);
        }

        return new AlertsValue($alertValues);
    }

    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }
}
