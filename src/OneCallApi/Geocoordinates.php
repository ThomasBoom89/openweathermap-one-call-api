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

namespace Thomasboom89\OpenWeatherMap\OneCallApi;

class Geocoordinates
{
    private float $lat;
    private float $lon;
    private const LAT_LIMIT = 90;
    private const LON_LIMIT = 180;

    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLon(): float
    {
        return $this->lon;
    }

    /*
     * Die erste Zahl der Breitengradkoordinate muss zwischen -90 und 90 liegen.
     * Die erste Zahl der Längengradkoordinate muss zwischen -180 und 180 liegen.
     */
    public function normalize(): void
    {
        $this->lat = $this->getNormalized($this->lat, self::LAT_LIMIT);
        $this->lon = $this->getNormalized($this->lon, self::LON_LIMIT);
    }

    private function getNormalized(float $value, int $limit): float
    {
        if ($value > $limit) {
            $factor = max(floor($value / (2 * $limit)), 1);
            return $value - ($factor * (2 * $limit));
        }

        if ($value < (-1 * $limit)) {
            $factor = max(floor($value / (2 * $limit)), 1);
            return $value + ($factor * (2 * $limit));
        }

        return $value;
    }
}
