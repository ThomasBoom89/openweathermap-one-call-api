<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts;

use DateTime;

class Alert
{
    public string   $senderName;
    public string   $event;
    public DateTime $start;
    public DateTime $end;
    public string   $description;

    /** var string[]  */
    public array $tags;
}
