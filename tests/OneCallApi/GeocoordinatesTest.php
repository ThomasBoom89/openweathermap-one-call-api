<?php

declare(strict_types=1);

namespace OneCallApi;

use PHPUnit\Framework\TestCase;
use Thomasboom89\OpenWeatherMap\OneCallApi\Geocoordinates;

class GeocoordinatesTest extends TestCase
{
    public function testGetNormalized(): void
    {
        $geocoordinates = new Geocoordinates(270, 540);
        $geocoordinates->normalize();
        $this->assertEquals(90, $geocoordinates->getLat());
        $this->assertEquals(180, $geocoordinates->getLon());

        $geocoordinates = new Geocoordinates(100, 200);
        $geocoordinates->normalize();
        $this->assertEquals(-80, $geocoordinates->getLat());
        $this->assertEquals(-160, $geocoordinates->getLon());


        $geocoordinates = new Geocoordinates(-270, -540);
        $geocoordinates->normalize();
        $this->assertEquals(-90, $geocoordinates->getLat());
        $this->assertEquals(-180, $geocoordinates->getLon());

        $geocoordinates = new Geocoordinates(12, 14);
        $geocoordinates->normalize();
        $this->assertEquals(12, $geocoordinates->getLat());
        $this->assertEquals(14, $geocoordinates->getLon());
    }
}
