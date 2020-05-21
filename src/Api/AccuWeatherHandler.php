<?php


namespace Ingelby\Accuweather\Api;


use Carbon\Carbon;
use Ingelby\Accuweather\Exceptions\AccuWeatherApiException;
use Ingelby\Accuweather\Models\AutoCompleteCity;
use Ingelby\Accuweather\Models\CurrentConditions;
use Ingelby\Accuweather\Models\DailyForecast;
use Ingelby\Accuweather\Models\HourlyForecast;
use Ingelby\Accuweather\Models\Location;
use ingelby\toolbox\helpers\LoggingHelper;
use ingelby\toolbox\constants\HttpStatus;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleClientException;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleInternalServerException;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleServerException;
use ingelby\toolbox\services\inguzzle\InguzzleHandler;

class AccuWeatherHandler extends InguzzleHandler
{
    protected const CACHE_KEY = 'ACCU_WEATHER_CACHE_';
    protected const DEFAULT_CACHE_DURATION = 60 * 60;

    /**
     * @var string
     */
    protected $apiKey;

    public function __construct(
        $baseUrl = null,
        $uriPrefix = '',
        callable $clientErrorResponseCallback = null,
        callable $serverErrorResponseCallback = null
    )
    {
        if (null === $baseUrl) {
            $baseUrl = \Yii::$app->params['accuWeather']['api']['baseUrl'];
        }
        parent::__construct($baseUrl, $uriPrefix, $clientErrorResponseCallback, $serverErrorResponseCallback);
        $this->apiKey = \Yii::$app->params['accuWeather']['api']['key'];
    }

    /**
     * @param string $locationQuery
     * @return AutoCompleteCity[]
     */
    public function getAutoCompleteLocations(string $locationQuery): array
    {
        $autoCompleteCities = [];

        try {
            $response = $this->get(
                '/locations/v1/cities/autocomplete',
                [
                    'apikey'   => $this->apiKey,
                    'q'        => $locationQuery,
                    'language' => 'en-gb',
                ],
            );

            foreach ($response as $city) {
                $autoCompleteCities[] = new AutoCompleteCity(
                    [
                        'key'                    => $city['Key'] ?? 1,
                        'rank'                   => $city['Rank'] ?? 10,
                        'localisedName'          => $city['LocalizedName'] ?? 'Unknown',
                        'countryName'            => $city['Country']['LocalizedName'] ?? 'Unknown',
                        'countryId'              => $city['Country']['ID'] ?? 'Unknown',
                        'administrativeAreaName' => $city['AdministrativeArea']['LocalizedName'] ?? 'Unknown',
                        'administrativeAreaId'   => $city['AdministrativeArea']['ID'] ?? 'Unknown',
                    ]
                );
            }
        } catch (InguzzleClientException | InguzzleInternalServerException | InguzzleServerException $e) {
            LoggingHelper::logException($e);
        }

        return $autoCompleteCities;
    }


    /**
     * @param string $locationKey
     * @return Location
     * @throws AccuWeatherApiException
     */
    public function getLocation(string $locationKey): Location
    {

        $cacheKey = static::CACHE_KEY . __FUNCTION__ . $locationKey;

        return \Yii::$app->cache->getOrSet(
            $cacheKey,
            function () use ($locationKey, $cacheKey) {
                \Yii::info('Caching key: ' . $cacheKey);
                try {
                    $response = $this->get(
                        '/locations/v1/' . $locationKey,
                        [
                            'apikey'   => $this->apiKey,
                            'language' => 'en-gb',
                        ],
                    );

                    return new Location(
                        [
                            'key'                    => $response['Key'] ?? 1,
                            'type'                   => $response['Type'] ?? 'Unknown',
                            'rank'                   => $response['Rank'] ?? 10,
                            'localisedName'          => $response['LocalizedName'] ?? 'Unknown',
                            'countryName'            => $response['Country']['LocalizedName'] ?? 'Unknown',
                            'countryId'              => $response['Country']['ID'] ?? 'Unknown',
                            'administrativeAreaName' => $response['AdministrativeArea']['LocalizedName'] ?? 'Unknown',
                            'administrativeAreaId'   => $response['AdministrativeArea']['ID'] ?? 'Unknown',
                        ]
                    );

                } catch (InguzzleClientException | InguzzleInternalServerException | InguzzleServerException $e) {
                    LoggingHelper::logException($e);
                    throw new AccuWeatherApiException(HttpStatus::BAD_REQUEST, 'Error calling acuweather', 0, $e);
                }
            },
            static::DEFAULT_CACHE_DURATION
        );
    }


    /**
     * @param string $locationKey
     * @return Location
     * @throws AccuWeatherApiException
     */
    public function getGeoposition(float $latitude, float $longitude): Location
    {

        $cacheKey = static::CACHE_KEY . __FUNCTION__ . $latitude . $longitude;

        return \Yii::$app->cache->getOrSet(
            $cacheKey,
            function () use ($latitude, $longitude, $cacheKey) {
                \Yii::info('Caching key: ' . $cacheKey);
                try {
                    $response = $this->get(
                        '/locations/v1/cities/geoposition/search',
                        [
                            'apikey'   => $this->apiKey,
                            'q'        => $latitude . ',' . $longitude,
                            'language' => 'en-gb',
                        ],
                    );

                    return new Location(
                        [
                            'key'                    => $response['Key'] ?? 1,
                            'type'                   => $response['Type'] ?? 'Unknown',
                            'rank'                   => $response['Rank'] ?? 10,
                            'localisedName'          => $response['LocalizedName'] ?? 'Unknown',
                            'countryName'            => $response['Country']['LocalizedName'] ?? 'Unknown',
                            'countryId'              => $response['Country']['ID'] ?? 'Unknown',
                            'administrativeAreaName' => $response['AdministrativeArea']['LocalizedName'] ?? 'Unknown',
                            'administrativeAreaId'   => $response['AdministrativeArea']['ID'] ?? 'Unknown',
                        ]
                    );

                } catch (InguzzleClientException | InguzzleInternalServerException | InguzzleServerException $e) {
                    LoggingHelper::logException($e);
                    throw new AccuWeatherApiException(HttpStatus::BAD_REQUEST, 'Error calling acuweather', 0, $e);
                }
            },
            static::DEFAULT_CACHE_DURATION
        );
    }

    /**
     * @param string $locationKey
     * @return CurrentConditions
     * @throws AccuWeatherApiException
     */
    public function getCurrentConditions(string $locationKey): CurrentConditions
    {

        $cacheKey = static::CACHE_KEY . __FUNCTION__ . $locationKey;

        return \Yii::$app->cache->getOrSet(
            $cacheKey,
            function () use ($locationKey, $cacheKey) {
                \Yii::info('Caching key: ' . $cacheKey);
                try {
                    $response = $this->get(
                        '/currentconditions/v1/' . $locationKey,
                        [
                            'apikey'   => $this->apiKey,
                            'language' => 'en-gb',
                            'details'  => 'true',
                        ],
                    );


                    return new CurrentConditions(
                        [
                            'weatherText'               => $response[0]['WeatherText'] ?? 'Unknown',
                            'weatherIconNumber'         => $response[0]['WeatherIcon'] ?? 1,
                            'localObservationDateTime'  => $response[0]['LocalObservationDateTime'] ?? Carbon::now()->toDateTimeString(),
                            'temperatureDegrees'        => $response[0]['Temperature']['Metric']['Value'] ?? 'Unknown',
                            'temperatureFahrenheit'     => $response[0]['Temperature']['Imperial']['Value'] ?? 'Unknown',
                            'mobileUrl'                 => $response[0]['MobileLink'] ?? 'Unknown',
                            'url'                       => $response[0]['MobileLink'] ?? 'Unknown',
                            'temperatureHighDegrees'    => $response[0]['TemperatureSummary']['Past24HourRange']['Maximum']['Metric']['Value'] ?? 'Unknown',
                            'temperatureLowDegrees'     => $response[0]['TemperatureSummary']['Past24HourRange']['Minimum']['Metric']['Value'] ?? 'Unknown',
                            'temperatureHighFahrenheit' => $response[0]['TemperatureSummary']['Past24HourRange']['Maximum']['Imperial']['Value'] ?? 'Unknown',
                            'temperatureLowFahrenheit'  => $response[0]['TemperatureSummary']['Past24HourRange']['Minimum']['Imperial']['Value'] ?? 'Unknown',
                            'fullResponseObject'        => $response[0],
                        ]
                    );

                } catch (InguzzleClientException | InguzzleInternalServerException | InguzzleServerException $e) {
                    LoggingHelper::logException($e);
                    throw new AccuWeatherApiException(HttpStatus::BAD_REQUEST, 'Error calling acuweather', 0, $e);
                }
            },
            60 * 10
        );
    }


    /**
     * @param string $locationKey
     * @param int    $days
     * @return DailyForecast[]
     */
    public function getDailyForecast(string $locationKey, int $days = 1): array
    {

        $cacheKey = static::CACHE_KEY . __FUNCTION__ . $locationKey . $days;

        return \Yii::$app->cache->getOrSet(
            $cacheKey,
            function () use ($locationKey, $days, $cacheKey) {
                \Yii::info('Caching key: ' . $cacheKey);

                $forecast = [];

                try {
                    $response = $this->get(
                        '/forecasts/v1/daily/' . $days . 'day' . '/' . $locationKey,
                        [
                            'apikey'   => $this->apiKey,
                            'language' => 'en-gb',
                            'details'  => 'true',
                        ],
                    );

                    foreach ($response['DailyForecasts'] as $dailyForecast) {
                        $forecast[] = new DailyForecast(
                            [
                                'dateTime'                  => $dailyForecast['Date'] ?? Carbon::now()->toDateTimeString(),
                                'weatherIconNumber'         => $dailyForecast['Day']['Icon'] ?? 1,
                                'temperatureHighFahrenheit' => $dailyForecast['Temperature']['Maximum']['Value'] ?? 32,
                                'temperatureLowFahrenheit'  => $dailyForecast['Temperature']['Minimum']['Value'] ?? 32,
                                'mobileUrl'                 => $dailyForecast['MobileLink'] ?? 'Unknown',
                                'url'                       => $dailyForecast['Link'] ?? 'Unknown',
                                'fullResponseObject'        => $dailyForecast,
                            ]
                        );
                    }
                    return $forecast;
                } catch (InguzzleClientException | InguzzleInternalServerException | InguzzleServerException $e) {
                    LoggingHelper::logException($e);
                    throw new AccuWeatherApiException(HttpStatus::BAD_REQUEST, 'Error calling acuweather', 0, $e);
                }
            },
            60 * 10
        );
    }


    /**
     * @param string $locationKey
     * @param int    $hours
     * @return HourlyForecast[]
     */
    public function getHourlyForecast(string $locationKey, int $hours = 1): array
    {

        $cacheKey = static::CACHE_KEY . __FUNCTION__ . $locationKey . $hours;

        return \Yii::$app->cache->getOrSet(
            $cacheKey,
            function () use ($locationKey, $hours, $cacheKey) {
                \Yii::info('Caching key: ' . $cacheKey);

                $forecast = [];

                try {
                    $response = $this->get(
                        '/forecasts/v1/hourly/' . $hours . 'hour' . '/' . $locationKey,
                        [
                            'apikey'   => $this->apiKey,
                            'language' => 'en-gb',
                        ],
                    );

                    foreach ($response as $hourlyForecast) {
                        $forecast[] = new HourlyForecast(
                            [
                                'dateTime'              => $hourlyForecast['DateTime'] ?? Carbon::now()->toDateTimeString(),
                                'weatherIconNumber'     => $hourlyForecast['WeatherIcon'] ?? 1,
                                'temperatureFahrenheit' => $hourlyForecast['Temperature']['Value'] ?? 32,
                                'mobileUrl'             => $hourlyForecast['MobileLink'] ?? 'Unknown',
                                'url'                   => $hourlyForecast['Link'] ?? 'Unknown',
                                'fullResponseObject'    => $hourlyForecast,
                            ]
                        );
                    }
                    return $forecast;
                } catch (InguzzleClientException | InguzzleInternalServerException | InguzzleServerException $e) {
                    LoggingHelper::logException($e);
                    throw new AccuWeatherApiException(HttpStatus::BAD_REQUEST, 'Error calling acuweather', 0, $e);
                }
            },
            60 * 10
        );
    }

}
