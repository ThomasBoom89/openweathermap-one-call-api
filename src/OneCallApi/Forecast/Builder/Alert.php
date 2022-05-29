<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts\Alert as AlertValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Alert implements Builder
{
    use Calculator;

    public function build(array $data): AlertValue
    {
        $alert              = new AlertValue();
        $alert->senderName  = $data['sender_name'];
        $alert->event       = $data['event'];
        $alert->start       = $this->getDateTime($data['start'], $data['timezone_offset']);//$data['start']
        $alert->end         = $this->getDateTime($data['end'], $data['timezone_offset']);//$data['end']
        $alert->description = $data['description'];
        $alert->tags        = array_unique($data['tags']);

        return $alert;
    }
}
