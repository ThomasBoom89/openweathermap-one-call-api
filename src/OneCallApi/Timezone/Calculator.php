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
use Exception;

trait Calculator
{
    /**
     * @throws Exception
     */
    private function getDateTime(int $timestamp, int $timezoneOffset): DateTime
    {
        $dateTime = new DateTime('@' . $timestamp);

        $timezoneOffset = (int)($timezoneOffset / 60 / 60);

        if ($timezoneOffset === 0) {
            return $dateTime;
        }

        $prefix = '+';
        if (0 > $timezoneOffset) {
            $prefix = '';
        }
        $dateTimeZone = new DateTimeZone($prefix . $timezoneOffset);

        $dateTime->setTimezone($dateTimeZone);

        return $dateTime;
    }
}
