<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Thomasboom89\OpenWeatherMap\OneCallApi;

class OneCallApiTest extends TestCase
{
    public function testGetForecast(): void
    {
        $owmoca = $this->createOneCallApiMock($this->getValidMockBody());

        $forecast = $owmoca->getForecast(232.512209, -267.045075, 'de', OneCallApi\Unit::METRIC);

        $this->assertEquals('0.17mm', $forecast->current->rain);
        $this->assertEquals('0.17mm', $forecast->current->snow);
        $this->assertEquals('0.34', $forecast->current->uvIndex);
        $this->assertEquals('12.17°C', $forecast->current->dewPoint);
        $this->assertEquals('60%', $forecast->current->humidity);
        $this->assertEquals('1014hPa', $forecast->current->pressure);
        $this->assertEquals('85%', $forecast->current->cloudiness);
        $this->assertEquals('10000m', $forecast->current->visibility);
        $this->assertEquals('20.17°C', $forecast->current->temperature);
        $this->assertEquals('0mm', $forecast->minutely->current()->precipitation);
        $this->assertEquals('0%', $forecast->hourly->current()->probability);
        $this->assertEquals('0.84', $forecast->daily->current()->moon->phase);
        $this->assertEquals('wind gusts', $forecast->alerts->current()->event);

        // for cache coverage
        $owmoca->getForecast(232.512209, -267.045075, 'de', OneCallApi\Unit::METRIC);

    }

    public function testGetForecastUnknownLanguage(): void
    {
        $owmoca = $this->createOneCallApiMock($this->getValidMockBody());

        $this->expectException(OneCallApi\Exceptions\UnkownLanguage::class);
        $owmoca->getForecast(232.512209, -267.045075, 'zzui', OneCallApi\Unit::METRIC);
    }

    public function testGetForecastUnknownUnit(): void
    {
        $owmoca = $this->createOneCallApiMock($this->getValidMockBody());

        $this->expectException(OneCallApi\Exceptions\UnknownUnit::class);
        $owmoca->getForecast(232.512209, -267.045075, 'de', 'wrong');
    }

    public function testGetForecastBadResponse(): void
    {
        $owmoca = $this->createOneCallApiMock('', 401);

        $this->expectException(OneCallApi\Exceptions\BadResponse::class);
        $owmoca->getForecast(232.512209, -267.045075, 'de', OneCallApi\Unit::METRIC);
    }

    public function testGetForecastMalformedRequestBody(): void
    {
        $owmoca = $this->createOneCallApiMock($this->getInvalidMockBody());

        $this->expectException(OneCallApi\Exceptions\MalformedRequestBody::class);
        $owmoca->getForecast(232.512209, -267.045075, 'de', OneCallApi\Unit::METRIC);
    }

    private function getValidMockBody(): string
    {
        return '{"lat":52.5122,"lon":12.9549,"timezone":"Europe/Berlin","timezone_offset":7200,"current":{"dt":1653497999,"sunrise":1653447527,"sunset":1653505904,"temp":20.17,"feels_like":19.81,"pressure":1014,"humidity":60,"dew_point":12.17,"uvi":0.34,"clouds":85,"visibility":10000,"wind_speed":2.01,"wind_deg":276,"wind_gust":3.35,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"rain":{"1h":0.17},"snow":{"1h":0.17}},"minutely":[{"dt":1653498000,"precipitation":0},{"dt":1653498060,"precipitation":0},{"dt":1653498120,"precipitation":0},{"dt":1653498180,"precipitation":0},{"dt":1653498240,"precipitation":0},{"dt":1653498300,"precipitation":0},{"dt":1653498360,"precipitation":0},{"dt":1653498420,"precipitation":0},{"dt":1653498480,"precipitation":0},{"dt":1653498540,"precipitation":0},{"dt":1653498600,"precipitation":0},{"dt":1653498660,"precipitation":0},{"dt":1653498720,"precipitation":0},{"dt":1653498780,"precipitation":0},{"dt":1653498840,"precipitation":0},{"dt":1653498900,"precipitation":0},{"dt":1653498960,"precipitation":0},{"dt":1653499020,"precipitation":0},{"dt":1653499080,"precipitation":0},{"dt":1653499140,"precipitation":0},{"dt":1653499200,"precipitation":0},{"dt":1653499260,"precipitation":0},{"dt":1653499320,"precipitation":0},{"dt":1653499380,"precipitation":0},{"dt":1653499440,"precipitation":0},{"dt":1653499500,"precipitation":0},{"dt":1653499560,"precipitation":0},{"dt":1653499620,"precipitation":0},{"dt":1653499680,"precipitation":0},{"dt":1653499740,"precipitation":0},{"dt":1653499800,"precipitation":0},{"dt":1653499860,"precipitation":0},{"dt":1653499920,"precipitation":0},{"dt":1653499980,"precipitation":0},{"dt":1653500040,"precipitation":0},{"dt":1653500100,"precipitation":0},{"dt":1653500160,"precipitation":0},{"dt":1653500220,"precipitation":0},{"dt":1653500280,"precipitation":0},{"dt":1653500340,"precipitation":0},{"dt":1653500400,"precipitation":0},{"dt":1653500460,"precipitation":0},{"dt":1653500520,"precipitation":0},{"dt":1653500580,"precipitation":0},{"dt":1653500640,"precipitation":0},{"dt":1653500700,"precipitation":0},{"dt":1653500760,"precipitation":0},{"dt":1653500820,"precipitation":0},{"dt":1653500880,"precipitation":0},{"dt":1653500940,"precipitation":0},{"dt":1653501000,"precipitation":0},{"dt":1653501060,"precipitation":0},{"dt":1653501120,"precipitation":0},{"dt":1653501180,"precipitation":0},{"dt":1653501240,"precipitation":0},{"dt":1653501300,"precipitation":0},{"dt":1653501360,"precipitation":0},{"dt":1653501420,"precipitation":0},{"dt":1653501480,"precipitation":0},{"dt":1653501540,"precipitation":0},{"dt":1653501600,"precipitation":0}],"hourly":[{"dt":1653494400,"temp":19.94,"feels_like":19.48,"pressure":1014,"humidity":57,"dew_point":11.18,"uvi":0.75,"clouds":84,"visibility":10000,"wind_speed":4.05,"wind_deg":284,"wind_gust":6.88,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0},{"dt":1653498000,"temp":20.17,"feels_like":19.81,"pressure":1014,"humidity":60,"dew_point":12.17,"uvi":0.34,"clouds":85,"visibility":10000,"wind_speed":2.01,"wind_deg":276,"wind_gust":3.35,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653501600,"temp":19.36,"feels_like":18.97,"pressure":1014,"humidity":62,"dew_point":11.9,"uvi":0.11,"clouds":84,"visibility":10000,"wind_speed":1.59,"wind_deg":231,"wind_gust":1.86,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0},{"dt":1653505200,"temp":17.93,"feels_like":17.42,"pressure":1014,"humidity":63,"dew_point":10.79,"uvi":0,"clouds":90,"visibility":10000,"wind_speed":2.3,"wind_deg":208,"wind_gust":2.37,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653508800,"temp":16.51,"feels_like":15.91,"pressure":1015,"humidity":65,"dew_point":9.92,"uvi":0,"clouds":90,"visibility":10000,"wind_speed":2.87,"wind_deg":230,"wind_gust":4.72,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653512400,"temp":14.61,"feels_like":13.9,"pressure":1015,"humidity":68,"dew_point":8.78,"uvi":0,"clouds":91,"visibility":10000,"wind_speed":3.08,"wind_deg":246,"wind_gust":7.64,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653516000,"temp":12.32,"feels_like":11.54,"pressure":1015,"humidity":74,"dew_point":7.71,"uvi":0,"clouds":93,"visibility":10000,"wind_speed":3.2,"wind_deg":230,"wind_gust":9.28,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653519600,"temp":12.78,"feels_like":11.92,"pressure":1015,"humidity":69,"dew_point":7.11,"uvi":0,"clouds":94,"visibility":10000,"wind_speed":4.05,"wind_deg":238,"wind_gust":11.02,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653523200,"temp":11.58,"feels_like":10.7,"pressure":1015,"humidity":73,"dew_point":6.87,"uvi":0,"clouds":91,"visibility":10000,"wind_speed":3.32,"wind_deg":228,"wind_gust":10.09,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653526800,"temp":12.76,"feels_like":11.87,"pressure":1015,"humidity":68,"dew_point":7.03,"uvi":0,"clouds":96,"visibility":10000,"wind_speed":4.48,"wind_deg":227,"wind_gust":12.51,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653530400,"temp":13.65,"feels_like":12.74,"pressure":1015,"humidity":64,"dew_point":6.87,"uvi":0,"clouds":98,"visibility":10000,"wind_speed":5.26,"wind_deg":244,"wind_gust":12.19,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653534000,"temp":13.31,"feels_like":12.42,"pressure":1015,"humidity":66,"dew_point":7.11,"uvi":0,"clouds":98,"visibility":10000,"wind_speed":5.16,"wind_deg":242,"wind_gust":12.39,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653537600,"temp":13.28,"feels_like":12.47,"pressure":1015,"humidity":69,"dew_point":7.49,"uvi":0.08,"clouds":99,"visibility":10000,"wind_speed":5.26,"wind_deg":246,"wind_gust":11.76,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653541200,"temp":13.65,"feels_like":13.06,"pressure":1015,"humidity":76,"dew_point":9.49,"uvi":0.25,"clouds":93,"visibility":10000,"wind_speed":5.59,"wind_deg":251,"wind_gust":11.46,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653544800,"temp":14.99,"feels_like":14.45,"pressure":1015,"humidity":73,"dew_point":10.09,"uvi":0.62,"clouds":85,"visibility":10000,"wind_speed":6.63,"wind_deg":252,"wind_gust":11.64,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653548400,"temp":14.51,"feels_like":14,"pressure":1016,"humidity":76,"dew_point":10.4,"uvi":1.61,"clouds":100,"visibility":10000,"wind_speed":6.7,"wind_deg":260,"wind_gust":11.7,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653552000,"temp":16.41,"feels_like":15.86,"pressure":1016,"humidity":67,"dew_point":10.22,"uvi":2.59,"clouds":93,"visibility":10000,"wind_speed":7.58,"wind_deg":265,"wind_gust":12.02,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653555600,"temp":16.71,"feels_like":16.19,"pressure":1016,"humidity":67,"dew_point":10.58,"uvi":3.59,"clouds":94,"visibility":10000,"wind_speed":7.51,"wind_deg":261,"wind_gust":12.05,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":0.25,"rain":{"1h":0.17},"snow":{"1h":0.17}},{"dt":1653559200,"temp":18.45,"feels_like":17.81,"pressure":1016,"humidity":56,"dew_point":9.48,"uvi":5.01,"clouds":92,"visibility":10000,"wind_speed":8.46,"wind_deg":266,"wind_gust":12.16,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":0.29,"rain":{"1h":0.12}},{"dt":1653562800,"temp":17.73,"feels_like":17.1,"pressure":1017,"humidity":59,"dew_point":9.39,"uvi":5.41,"clouds":93,"visibility":10000,"wind_speed":7.36,"wind_deg":266,"wind_gust":11.82,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":0.25,"rain":{"1h":0.11}},{"dt":1653566400,"temp":19.21,"feels_like":18.41,"pressure":1017,"humidity":47,"dew_point":7.69,"uvi":5.21,"clouds":94,"visibility":10000,"wind_speed":7.74,"wind_deg":264,"wind_gust":12.41,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0.05},{"dt":1653570000,"temp":20.38,"feels_like":19.54,"pressure":1017,"humidity":41,"dew_point":6.61,"uvi":3.24,"clouds":83,"visibility":10000,"wind_speed":8.29,"wind_deg":278,"wind_gust":12.38,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0},{"dt":1653573600,"temp":20.31,"feels_like":19.57,"pressure":1017,"humidity":45,"dew_point":7.86,"uvi":2.45,"clouds":81,"visibility":10000,"wind_speed":7.73,"wind_deg":270,"wind_gust":11.57,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0},{"dt":1653577200,"temp":19.02,"feels_like":18.34,"pressure":1017,"humidity":52,"dew_point":8.82,"uvi":1.6,"clouds":86,"visibility":10000,"wind_speed":7.25,"wind_deg":270,"wind_gust":11.05,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653580800,"temp":18.9,"feels_like":18.28,"pressure":1017,"humidity":55,"dew_point":9.73,"uvi":0.94,"clouds":79,"visibility":10000,"wind_speed":7.15,"wind_deg":274,"wind_gust":12.02,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0},{"dt":1653584400,"temp":17.54,"feels_like":16.94,"pressure":1017,"humidity":61,"dew_point":9.8,"uvi":0.42,"clouds":82,"visibility":10000,"wind_speed":6.32,"wind_deg":273,"wind_gust":11.05,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0},{"dt":1653588000,"temp":16.48,"feels_like":15.85,"pressure":1017,"humidity":64,"dew_point":9.65,"uvi":0.14,"clouds":85,"visibility":10000,"wind_speed":4.85,"wind_deg":273,"wind_gust":10.95,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653591600,"temp":16.09,"feels_like":15.43,"pressure":1017,"humidity":64,"dew_point":9.1,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":4.43,"wind_deg":264,"wind_gust":9.27,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0},{"dt":1653595200,"temp":15.97,"feels_like":15.35,"pressure":1017,"humidity":66,"dew_point":9.66,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":4.54,"wind_deg":258,"wind_gust":9.5,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653598800,"temp":15.67,"feels_like":15.17,"pressure":1017,"humidity":72,"dew_point":10.58,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":4.77,"wind_deg":249,"wind_gust":10.8,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0},{"dt":1653602400,"temp":15.78,"feels_like":15.27,"pressure":1016,"humidity":71,"dew_point":10.48,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":5.13,"wind_deg":249,"wind_gust":12.23,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0.01},{"dt":1653606000,"temp":15.48,"feels_like":15.02,"pressure":1015,"humidity":74,"dew_point":10.77,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":5.28,"wind_deg":242,"wind_gust":12.76,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0.18},{"dt":1653609600,"temp":15.52,"feels_like":15.11,"pressure":1014,"humidity":76,"dew_point":11.19,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":6.35,"wind_deg":250,"wind_gust":14.09,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04n"}],"pop":0.38},{"dt":1653613200,"temp":14.95,"feels_like":14.59,"pressure":1014,"humidity":80,"dew_point":11.54,"uvi":0,"clouds":100,"visibility":10000,"wind_speed":6.75,"wind_deg":258,"wind_gust":14.69,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10n"}],"pop":0.61,"rain":{"1h":0.47}},{"dt":1653616800,"temp":14.11,"feels_like":13.9,"pressure":1013,"humidity":89,"dew_point":12.2,"uvi":0,"clouds":100,"visibility":9974,"wind_speed":6.31,"wind_deg":264,"wind_gust":14.08,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10n"}],"pop":0.72,"rain":{"1h":0.64}},{"dt":1653620400,"temp":13.4,"feels_like":13.28,"pressure":1013,"humidity":95,"dew_point":12.46,"uvi":0,"clouds":100,"visibility":5994,"wind_speed":6.17,"wind_deg":280,"wind_gust":11.42,"weather":[{"id":501,"main":"Rain","description":"Mäßiger Regen","icon":"10d"}],"pop":0.81,"rain":{"1h":1.61}},{"dt":1653624000,"temp":12.71,"feels_like":12.49,"pressure":1013,"humidity":94,"dew_point":11.59,"uvi":0.09,"clouds":100,"visibility":10000,"wind_speed":5.36,"wind_deg":289,"wind_gust":11.48,"weather":[{"id":501,"main":"Rain","description":"Mäßiger Regen","icon":"10d"}],"pop":0.89,"rain":{"1h":1.42}},{"dt":1653627600,"temp":12.31,"feels_like":12.05,"pressure":1013,"humidity":94,"dew_point":11.3,"uvi":0.29,"clouds":100,"visibility":10000,"wind_speed":4.41,"wind_deg":280,"wind_gust":11.17,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":1,"rain":{"1h":0.63}},{"dt":1653631200,"temp":12.27,"feels_like":12.03,"pressure":1013,"humidity":95,"dew_point":11.4,"uvi":0.71,"clouds":100,"visibility":10000,"wind_speed":4.54,"wind_deg":264,"wind_gust":10.4,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":1,"rain":{"1h":0.47}},{"dt":1653634800,"temp":12.37,"feels_like":11.93,"pressure":1014,"humidity":87,"dew_point":10.24,"uvi":1.83,"clouds":100,"visibility":10000,"wind_speed":6.1,"wind_deg":282,"wind_gust":12.02,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":0.71,"rain":{"1h":0.27}},{"dt":1653638400,"temp":13.45,"feels_like":12.89,"pressure":1014,"humidity":78,"dew_point":9.55,"uvi":2.92,"clouds":100,"visibility":10000,"wind_speed":6.83,"wind_deg":277,"wind_gust":13.98,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0.59},{"dt":1653642000,"temp":15.26,"feels_like":14.46,"pressure":1014,"humidity":62,"dew_point":8.07,"uvi":4.03,"clouds":94,"visibility":10000,"wind_speed":8.85,"wind_deg":282,"wind_gust":15.49,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":0.5,"rain":{"1h":0.11}},{"dt":1653645600,"temp":16.37,"feels_like":15.21,"pressure":1014,"humidity":44,"dew_point":4.19,"uvi":3.46,"clouds":84,"visibility":10000,"wind_speed":9.7,"wind_deg":287,"wind_gust":14.68,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0.51},{"dt":1653649200,"temp":16.9,"feels_like":15.69,"pressure":1014,"humidity":40,"dew_point":3.02,"uvi":3.74,"clouds":70,"visibility":10000,"wind_speed":9.66,"wind_deg":287,"wind_gust":14.32,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0.46},{"dt":1653652800,"temp":17.3,"feels_like":16.05,"pressure":1014,"humidity":37,"dew_point":2.57,"uvi":3.59,"clouds":72,"visibility":10000,"wind_speed":9.4,"wind_deg":286,"wind_gust":13.87,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"pop":0.42},{"dt":1653656400,"temp":17.09,"feels_like":16,"pressure":1014,"humidity":44,"dew_point":4.87,"uvi":3.76,"clouds":100,"visibility":10000,"wind_speed":8.89,"wind_deg":285,"wind_gust":12.69,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0.09},{"dt":1653660000,"temp":16.59,"feels_like":15.48,"pressure":1014,"humidity":45,"dew_point":4.41,"uvi":2.85,"clouds":96,"visibility":10000,"wind_speed":9.11,"wind_deg":283,"wind_gust":14.73,"weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],"pop":0.22},{"dt":1653663600,"temp":14.26,"feels_like":13.33,"pressure":1015,"humidity":61,"dew_point":6.71,"uvi":1.88,"clouds":92,"visibility":10000,"wind_speed":8.9,"wind_deg":286,"wind_gust":14.94,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"pop":0.38,"rain":{"1h":0.24}}],"daily":[{"dt":1653476400,"sunrise":1653447527,"sunset":1653505904,"moonrise":1653442080,"moonset":1653485520,"moon_phase":0.84,"temp":{"day":18.58,"min":9.75,"max":20.37,"night":14.61,"eve":20.17,"morn":11.96},"feels_like":{"day":17.83,"night":13.9,"eve":19.81,"morn":11.33},"pressure":1014,"humidity":51,"dew_point":8.22,"wind_speed":6.25,"wind_deg":263,"wind_gust":8.37,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"clouds":66,"pop":1,"rain":1.65,"uvi":5.55},{"dt":1653562800,"sunrise":0,"sunset":1653592386,"moonrise":0,"moonset":1653576420,"moon_phase":0.87,"temp":{"day":17.73,"min":11.58,"max":20.38,"night":15.67,"eve":17.54,"morn":13.65},"feels_like":{"day":17.1,"night":15.17,"eve":16.94,"morn":13.06},"pressure":1017,"humidity":59,"dew_point":9.39,"wind_speed":8.46,"wind_deg":266,"wind_gust":12.51,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"clouds":93,"pop":0.29,"rain":0.4,"uvi":5.41},{"dt":1653649200,"sunrise":1653620192,"sunset":1653678866,"moonrise":1653616260,"moonset":1653667320,"moon_phase":0.9,"temp":{"day":16.9,"min":10,"max":17.3,"night":10,"eve":13.54,"morn":12.31},"feels_like":{"day":15.69,"night":7.13,"eve":12.57,"morn":12.05},"pressure":1014,"humidity":40,"dew_point":3.02,"wind_speed":9.7,"wind_deg":287,"wind_gust":15.49,"weather":[{"id":501,"main":"Rain","description":"Mäßiger Regen","icon":"10d"}],"clouds":70,"pop":1,"rain":5.99,"uvi":4.03},{"dt":1653735600,"sunrise":1653706529,"sunset":1653765344,"moonrise":1653703440,"moonset":1653758220,"moon_phase":0.94,"temp":{"day":14.74,"min":7.9,"max":14.74,"night":10.69,"eve":12.89,"morn":9.11},"feels_like":{"day":13.91,"night":9.67,"eve":12.09,"morn":5.49},"pressure":1014,"humidity":63,"dew_point":7.67,"wind_speed":9,"wind_deg":289,"wind_gust":14.9,"weather":[{"id":501,"main":"Rain","description":"Mäßiger Regen","icon":"10d"}],"clouds":85,"pop":0.92,"rain":3.97,"uvi":3.91},{"dt":1653822000,"sunrise":1653792868,"sunset":1653851820,"moonrise":1653790800,"moonset":1653849060,"moon_phase":0.97,"temp":{"day":11.71,"min":7.13,"max":13.21,"night":7.13,"eve":11.88,"morn":10.48},"feels_like":{"day":10.48,"night":5.14,"eve":10.79,"morn":9.36},"pressure":1014,"humidity":59,"dew_point":4,"wind_speed":5.39,"wind_deg":284,"wind_gust":9.48,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"clouds":98,"pop":0.2,"rain":0.12,"uvi":5.04},{"dt":1653908400,"sunrise":1653879210,"sunset":1653938294,"moonrise":1653878400,"moonset":1653939780,"moon_phase":0,"temp":{"day":14.15,"min":5.08,"max":14.15,"night":8.09,"eve":11.04,"morn":9.53},"feels_like":{"day":12.98,"night":6.76,"eve":10.21,"morn":7.72},"pressure":1012,"humidity":52,"dew_point":4.37,"wind_speed":4.3,"wind_deg":253,"wind_gust":5.21,"weather":[{"id":500,"main":"Rain","description":"Leichter Regen","icon":"10d"}],"clouds":75,"pop":1,"rain":1.65,"uvi":6},{"dt":1653994800,"sunrise":1653965555,"sunset":1654024767,"moonrise":1653966420,"moonset":1654030140,"moon_phase":0.03,"temp":{"day":15.6,"min":7.8,"max":15.6,"night":8.46,"eve":11.4,"morn":11.21},"feels_like":{"day":14.76,"night":7.19,"eve":11,"morn":10.48},"pressure":1010,"humidity":59,"dew_point":7.45,"wind_speed":3.32,"wind_deg":247,"wind_gust":7.17,"weather":[{"id":501,"main":"Rain","description":"Mäßiger Regen","icon":"10d"}],"clouds":98,"pop":1,"rain":6.4,"uvi":6},{"dt":1654081200,"sunrise":1654051902,"sunset":1654111237,"moonrise":1654055040,"moonset":1654120020,"moon_phase":0.06,"temp":{"day":18.76,"min":6.38,"max":18.76,"night":13.29,"eve":13.87,"morn":10.37},"feels_like":{"day":17.87,"night":12.42,"eve":12.96,"morn":9.71},"pressure":1012,"humidity":45,"dew_point":6.52,"wind_speed":2.44,"wind_deg":170,"wind_gust":3.3,"weather":[{"id":803,"main":"Clouds","description":"Überwiegend bewölkt","icon":"04d"}],"clouds":76,"pop":0.18,"uvi":6}],"alerts":[{"sender_name":"Deutscher Wetterdienst","event":"wind gusts","start":1652259600,"end":1652284800,"description":"There is a risk of wind gusts (level 1 of 4).\nMax. gusts: 50-60 km/h; Wind direction: south-west","tags":["Wind","Wind"]}]}';
    }


    private function getInvalidMockBody(): string
    {
        return '{"lat:52.5122,"lon":12.9549,"timezone":"Europe/Berlin","';
    }

    private function createOneCallApiMock(string $mockBody, int $statusCode = 200): OneCallApi
    {
        $httpClient = new Client();
        $response   = new Response($statusCode, [], $mockBody);
        $httpClient->addResponse($response);
        $httpFactory = new HttpFactory();
        $pool        = new ArrayAdapter();
        $cache       = new Psr16Cache($pool);

        return new OneCallApi('dfdfid78fd8fd', $httpClient, $httpFactory, $cache);
    }
}
