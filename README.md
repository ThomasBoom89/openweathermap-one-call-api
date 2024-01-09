# Openweathermap One Call API

![PHP](https://img.shields.io/badge/php-%3E%3D8.2-%238892BF?style=plastic&logo=php)
![License](https://img.shields.io/badge/license-MIT-green?style=plastic)

A wrapper for Openweathermap One Call Api v1 -> [Link](https://openweathermap.org/api/one-call-api).

### Attention!

I am not owner or maintainer of the API (https://openweathermap.org/api). This is only a wrapper for it.
You need to get an api-key from their site to use the api.

## Requirement

You need a working environment with php >= 8.2 and composer.

## Installation

```zsh
composer require thomasboom89/openweathermap-one-call-api
```

## Usage

Create an instance of the OneCallApi

```php
$httpClient  = new Client();
$httpFactory = new HttpFactory();
$owmoca      = new OneCallApi("YOUR-API-KEY", $httpClient, $httpFactory);

// Optional use caching interface
$pool        = new ArrayAdapter();
$cache       = new Psr16Cache($pool);
$owmoca      = new OneCallApi("YOUR-API-KEY", $httpClient, $httpFactory, $cache, 240);
```

Now you can use it to make a request

```php
// lat , lon , language , unitsystem
try {
    $forecast = $owmoca->getForecast(-78.944450, 19.458971, OneCallApi\Language::German, OneCallApi\Unit::Metric);
 } catch (Exception $exception){
    // handle exception
 }
```

You will receive a forecast object

```php
var_dump($forecast);
```

## FAQ

Q: Which language is currently supported? \
A: You have to use Enum Thomasboom89\OpenWeatherMap\OneCallApi\Language \
(If a language is missing, please open an issue)

Q: Which unitsystem is currently supported? \
A: You have to use Enum Thomasboom89\OpenWeatherMap\OneCallApi\Unit \

## License

Openweathermap One Call API
Copyright (C) 2023 ThomasBoom89. MIT license.

Openweathermap One Call API includes several third-party Open-Source libraries, which are licensed under their
own respective Open-Source licenses.

See `composer license` for complete list of depending libraries.
