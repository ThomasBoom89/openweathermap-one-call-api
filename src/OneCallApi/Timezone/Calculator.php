<?php

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
