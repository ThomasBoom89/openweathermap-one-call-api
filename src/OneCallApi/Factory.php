<?php

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

    public function createMinutelyBuilder(): Minutely
    {
        return new Minutely(new Minute(new Precipitation($this->unit)));
    }

    public function createAlertsBuilder(): Alerts
    {
        return new Alerts(new Alert());
    }

    public function createCurrentBuilder(): Current
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

    public function createHourBuilder(): Hour
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

    public function createHourlyBuilder(): Hourly
    {
        return new Hourly($this->createHourBuilder());
    }

    public function createDayBuilder(): Day
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

    public function createDailyBuilder(): Daily
    {
        return new Daily($this->createDayBuilder());
    }

    public function createTemperatureBuilder(): Temperature
    {
        return new Temperature($this->unit);
    }

    public function createDailyTemperatureBuilder(): Forecast\Builder\Daily\Temperature
    {
        return new Forecast\Builder\Daily\Temperature($this->unit);
    }

    public function createFeelsLikeBuilder(): FeelsLike
    {
        return new FeelsLike($this->unit);
    }

    public function createDailyFeelsLikeBuilder(): Forecast\Builder\Daily\FeelsLike
    {
        return new Forecast\Builder\Daily\FeelsLike($this->unit);
    }

    public function createPressureBuilder(): Pressure
    {
        return new Pressure($this->unit);
    }

    public function createHumidityBuilder(): Humidity
    {
        return new Humidity($this->unit);
    }

    public function createDewPointBuilder(): DewPoint
    {
        return new DewPoint($this->unit);
    }

    public function createUVIndexBuilder(): UVIndex
    {
        return new UVIndex();
    }

    public function createCloudinessBuilder(): Cloudiness
    {
        return new Cloudiness($this->unit);
    }

    public function createVisibilityBuilder(): Visibility
    {
        return new Visibility($this->unit);
    }

    public function createWindBuilder(): Wind
    {
        return new Wind($this->unit);
    }

    public function createRainBuilder(): Rain
    {
        return new Rain($this->unit);
    }

    public function createSnowBuilder(): Snow
    {
        return new Snow($this->unit);
    }

    public function createConditionBuilder(): Condition
    {
        return new Condition();
    }

    public function createSunBuilder(): Sun
    {
        return new Sun();
    }

    public function createProbabilityBuilder(): Probability
    {
        return new Probability($this->unit);
    }
}
