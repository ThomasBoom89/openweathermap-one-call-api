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

namespace Thomasboom89\OpenWeatherMap;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Thomasboom89\OpenWeatherMap\OneCallApi\Exceptions\BadResponse;
use Thomasboom89\OpenWeatherMap\OneCallApi\Exceptions\MalformedRequestBody;
use Thomasboom89\OpenWeatherMap\OneCallApi\Factory;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;
use Thomasboom89\OpenWeatherMap\OneCallApi\Geocoordinates;
use Thomasboom89\OpenWeatherMap\OneCallApi\Language;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @phpstan-import-type ForecastArray from Forecast\Builder\Forecast
 */
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
        $cacheKey = $lat . $lon . $language->value . $unit->value;
        if ($this->cache !== null) {
            $cacheValue = $this->cache->get($cacheKey);
            if ($cacheValue instanceof Forecast) {
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

        $rawResponse = $this->getRawResponse($response);

        $factory = new Factory($unit);

        $forecast = $factory->createForecastBuilder()
                            ->build($rawResponse);

        if ($this->cache !== null) {
            $this->cache->set($cacheKey, $forecast, $this->cacheTTL);
        }

        return $forecast;
    }

    /**
     * @return ForecastArray
     * @throws MalformedRequestBody
     */
    public function getRawResponse(ResponseInterface $response): array
    {
        try {
            $rawResponse = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new MalformedRequestBody('json could not be decoded');
        }

        if (!is_array($rawResponse)) {
            throw new MalformedRequestBody('no json given');
        }
        /** @var ForecastArray */
        return $rawResponse;
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
