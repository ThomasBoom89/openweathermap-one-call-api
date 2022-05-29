<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use DateTime;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Cloudiness;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Condition;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\DewPoint;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Humidity;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Pressure;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Rain;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Snow;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Sun;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Temperature;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\UVIndex;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Visibility;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Wind;

class Current
{
    public DateTime    $dateTime;
    public ?Sun        $sun;
    public Temperature $temperature;
    public Temperature $feelsLike;
    public Pressure    $pressure;
    public Humidity    $humidity;
    public DewPoint    $dewPoint;
    public UVIndex     $uvIndex;
    public Cloudiness  $cloudiness;
    public Visibility  $visibility;
    public Wind        $wind;
    public Rain        $rain;
    public Snow        $snow;
    public Condition   $condition;
}
