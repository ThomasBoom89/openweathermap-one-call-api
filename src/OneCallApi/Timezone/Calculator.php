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

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Timezone;

use DateTime;
use DateTimeZone;

trait Calculator
{
    private function getDateTime(int $timestamp, int $timezoneOffset): DateTime
    {
        $timezoneOffset = (int)($timezoneOffset / 60 / 60);
        $prefix         = '+';
        if (0 >= $timezoneOffset) {
            $prefix = '';
        }
        $dateTimeZone = new DateTimeZone($prefix . $timezoneOffset);

        $dateTime = new DateTime('@' . $timestamp);

        $dateTime->setTimezone($dateTimeZone);

        return $dateTime;
    }
}
