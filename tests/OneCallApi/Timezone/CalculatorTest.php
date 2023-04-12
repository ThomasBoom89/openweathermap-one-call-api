<?php

declare(strict_types=1);

namespace OneCallApi\Timezone;

use PHPUnit\Framework\TestCase;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class CalculatorTest extends TestCase
{
    use Calculator;

    public function testGetDateTime(): void
    {
        $dateTime = $this->getDateTime(1653502190, -21600);
        $this->assertEquals('25.05.2022 12:09:50', $dateTime->format('d.m.Y H:i:s'));

        // edge case when timezone is zero
        $dateTime = $this->getDateTime(1653502190, 0);
        $this->assertEquals('25.05.2022 18:09:50', $dateTime->format('d.m.Y H:i:s'));
    }
}
