<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Daily;

use DateTime;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Cloudiness;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Condition;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily\FeelsLike;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily\Temperature;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\DewPoint;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Humidity;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Moon;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Pressure;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Probability;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Rain;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Snow;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Sun;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\UVIndex;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Wind;

class Day
{
    public DateTime    $dateTime;
    public ?Sun        $sun;
    public ?Moon       $moon;
    public Temperature $temperature;
    public FeelsLike   $feelsLike;
    public Pressure    $pressure;
    public Humidity    $humidity;
    public DewPoint    $dewPoint;
    public Wind        $wind;
    public Condition   $condition;
    public Cloudiness  $cloudiness;
    public Probability $probability;
    public Rain        $rain;
    public Snow        $snow;
    public UVIndex     $uvIndex;
}
