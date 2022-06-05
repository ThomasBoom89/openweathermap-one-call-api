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

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Alert;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Alerts;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Cloudiness;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Condition;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Current;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Daily;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Day;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\DewPoint;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\FeelsLike;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Forecast as ForecastBuilder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Hour;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Hourly;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Humidity;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Minute;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Minutely;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Moon;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Precipitation;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Pressure;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Probability;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Rain;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Snow;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Sun;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Temperature;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\UVIndex;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Visibility;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Wind;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Factory
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function createForecastBuilder(): ForecastBuilder
    {
        return new ForecastBuilder(
            $this->createCurrentBuilder(),
            $this->createMinutelyBuilder(),
            $this->createHourlyBuilder(),
            $this->createDailyBuilder(),
            $this->createAlertsBuilder()
        );
    }

    private function createMinutelyBuilder(): Minutely
    {
        return new Minutely(new Minute(new Precipitation($this->unit)));
    }

    private function createAlertsBuilder(): Alerts
    {
        return new Alerts(new Alert());
    }

    private function createCurrentBuilder(): Current
    {
        return new Current(
            $this->createSunBuilder(),
            $this->createTemperatureBuilder(),
            $this->createFeelsLikeBuilder(),
            $this->createPressureBuilder(),
            $this->createHumidityBuilder(),
            $this->createDewPointBuilder(),
            $this->createUVIndexBuilder(),
            $this->createCloudinessBuilder(),
            $this->createVisibilityBuilder(),
            $this->createWindBuilder(),
            $this->createRainBuilder(),
            $this->createSnowBuilder(),
            $this->createConditionBuilder()
        );
    }

    private function createHourBuilder(): Hour
    {
        return new Hour(
            $this->createTemperatureBuilder(),
            $this->createFeelsLikeBuilder(),
            $this->createPressureBuilder(),
            $this->createHumidityBuilder(),
            $this->createDewPointBuilder(),
            $this->createUVIndexBuilder(),
            $this->createCloudinessBuilder(),
            $this->createVisibilityBuilder(),
            $this->createWindBuilder(),
            $this->createRainBuilder(),
            $this->createSnowBuilder(),
            $this->createConditionBuilder(),
            $this->createProbabilityBuilder()
        );
    }

    private function createHourlyBuilder(): Hourly
    {
        return new Hourly($this->createHourBuilder());
    }

    private function createDayBuilder(): Day
    {
        return new Day(
            $this->createSunBuilder(),
            new Moon(),
            $this->createDailyTemperatureBuilder(),
            $this->createDailyFeelsLikeBuilder(),
            $this->createPressureBuilder(),
            $this->createHumidityBuilder(),
            $this->createDewPointBuilder(),
            $this->createWindBuilder(),
            $this->createConditionBuilder(),
            $this->createCloudinessBuilder(),
            $this->createProbabilityBuilder(),
            $this->createRainBuilder(),
            $this->createSnowBuilder(),
            $this->createUVIndexBuilder(),
        );
    }

    private function createDailyBuilder(): Daily
    {
        return new Daily($this->createDayBuilder());
    }

    private function createTemperatureBuilder(): Temperature
    {
        return new Temperature($this->unit);
    }

    private function createDailyTemperatureBuilder(): Forecast\Builder\Daily\Temperature
    {
        return new Forecast\Builder\Daily\Temperature($this->unit);
    }

    private function createFeelsLikeBuilder(): FeelsLike
    {
        return new FeelsLike($this->unit);
    }

    private function createDailyFeelsLikeBuilder(): Forecast\Builder\Daily\FeelsLike
    {
        return new Forecast\Builder\Daily\FeelsLike($this->unit);
    }

    private function createPressureBuilder(): Pressure
    {
        return new Pressure($this->unit);
    }

    private function createHumidityBuilder(): Humidity
    {
        return new Humidity($this->unit);
    }

    private function createDewPointBuilder(): DewPoint
    {
        return new DewPoint($this->unit);
    }

    private function createUVIndexBuilder(): UVIndex
    {
        return new UVIndex();
    }

    private function createCloudinessBuilder(): Cloudiness
    {
        return new Cloudiness($this->unit);
    }

    private function createVisibilityBuilder(): Visibility
    {
        return new Visibility($this->unit);
    }

    private function createWindBuilder(): Wind
    {
        return new Wind($this->unit);
    }

    private function createRainBuilder(): Rain
    {
        return new Rain($this->unit);
    }

    private function createSnowBuilder(): Snow
    {
        return new Snow($this->unit);
    }

    private function createConditionBuilder(): Condition
    {
        return new Condition();
    }

    private function createSunBuilder(): Sun
    {
        return new Sun();
    }

    private function createProbabilityBuilder(): Probability
    {
        return new Probability($this->unit);
    }
}
