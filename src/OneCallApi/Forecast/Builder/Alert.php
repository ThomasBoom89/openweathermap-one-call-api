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

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts\Alert as AlertValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Alert implements Builder
{
    use Calculator;

    /**
     * @param array{
     *     'sender_name': string,
     *     'event': string,
     *     'start': int,
     *     'end': int,
     *     'timezone_offset': int,
     *     'description': string,
     *     'tags': string[]
     * } $data
     */
    public function build(array $data): AlertValue
    {
        $alert              = new AlertValue();
        $alert->senderName  = $data['sender_name'];
        $alert->event       = $data['event'];
        $alert->start       = $this->getDateTime($data['start'], $data['timezone_offset']);//$data['start']
        $alert->end         = $this->getDateTime($data['end'], $data['timezone_offset']);  //$data['end']
        $alert->description = $data['description'];
        $alert->tags        = array_unique($data['tags']);

        return $alert;
    }
}
