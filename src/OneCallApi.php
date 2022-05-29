<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Thomasboom89\OpenWeatherMap\OneCallApi\Exceptions\BadResponse;
use Thomasboom89\OpenWeatherMap\OneCallApi\Exceptions\MalformedRequestBody;
use Thomasboom89\OpenWeatherMap\OneCallApi\Factory;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;
use Thomasboom89\OpenWeatherMap\OneCallApi\Geocoordinates;
use Thomasboom89\OpenWeatherMap\OneCallApi\Language;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class OneCallApi
{

    private string $apiKey;

    private ClientInterface $httpClient;

    private RequestFactoryInterface $requestFactory;

    private ?CacheInterface $cache;

    private int $cacheTTL;

    public function __construct(
        string                  $apiKey,
        ClientInterface         $httpClient,
        RequestFactoryInterface $requestFactory,
        CacheInterface          $cache = null,
        int                     $cacheTTL = 60
    ) {
        $this->apiKey         = $apiKey;
        $this->httpClient     = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->cache          = $cache;
        $this->cacheTTL       = $cacheTTL;
    }

    /**
     * @throws MalformedRequestBody
     * @throws BadResponse
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getForecast(
        float    $lat,
        float    $lon,
        Language $language = Language::English,
        Unit     $unit = Unit::Default
    ): Forecast {

        if ($this->cache !== null) {
            $cacheKey   = $lat . $lon . $language->value . $unit->value;
            $cacheValue = $this->cache->get($cacheKey);
            if ($cacheValue !== null) {
                return $cacheValue;
            }
        }

        $geocoordinates = new Geocoordinates($lat, $lon);
        $geocoordinates->normalize();

        $url     = $this->buildUrl($geocoordinates, $language, $unit);
        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() !== 200) {
            throw new BadResponse($response->getStatusCode() . $response->getReasonPhrase());
        }

        try {
            $rawResponse = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new MalformedRequestBody('json could not be decoded');
        }

        $factory = new Factory($unit);

        $forecast = $factory->createForecastBuilder()
                            ->build($rawResponse);

        if ($this->cache !== null && isset($cacheKey)) {
            $this->cache->set($cacheKey, $forecast, $this->cacheTTL);
        }

        return $forecast;
    }

    private function buildUrl(Geocoordinates $geocoordinates, Language $language, Unit $unit): string
    {
        $queryParam = [
            'lat'   => $geocoordinates->getLat(),
            'lon'   => $geocoordinates->getLon(),
            'appid' => $this->apiKey,
            'lang'  => $language->value,
            'units' => $unit->value
        ];

        return 'https://api.openweathermap.org/data/2.5/onecall?' . http_build_query($queryParam);
    }
}
