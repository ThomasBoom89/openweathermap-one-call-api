<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Thomasboom89\OpenWeatherMap\OneCallApi;

require_once '../vendor/autoload.php';

$httpClient  = new Client();
$httpFactory = new HttpFactory();
$pool        = new ArrayAdapter();
$cache       = new Psr16Cache($pool);
$owmoca      = new OneCallApi("YOUR-API-KEY", $httpClient, $httpFactory, $cache, 5);

$forecast = $owmoca->getForecast(-78.944450, 19.458971, 'de', OneCallApi\Unit::METRIC);
//$forecast = $owmoca->getForecast(232.512209, -167.045075, 'de', OneCallApi\Unit::METRIC);


print_r($forecast->current->temperature);

if ($forecast->minutely->count() > 0) {
    print_r($forecast->minutely[0]);
}

print_r($forecast->hourly[0]);

print_r($forecast->daily[0]);

$alerts = $forecast->alerts;
if (count($alerts) > 0) {
    foreach ($alerts as $alert) {
        echo $alert->description;
    }
} else {
    echo 'Keine Alerts vorhanden';
}
