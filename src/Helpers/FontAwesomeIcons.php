<?php


namespace Ingelby\Accuweather\Helpers;


class FontAwesomeIcons
{
    public const MODE_REGULAR = 'far fa-';
    public const MODE_SOLID = 'fas fa-';
    public const MODE_LIGHT = 'fal fa-';
    public const MODE_DUO_TONE = 'fad fa-';

    public const DEFAULT_ICON = 999;

    public const SUNNY = 1;
    public const MOSTLY_SUNNY = 2;
    public const PARTLY_SUNNY = 3;
    public const INTERMITTENT_CLOUDS = 4;
    public const HAZY_SUNSHINE = 5;
    public const MOSTLY_CLOUDY = 6;
    public const CLOUDY = 7;
    public const DREARY_OVERCAST = 8;
    public const FOG = 11;
    public const SHOWERS = 12;
    public const MOSTLY_CLOUDY_WITH_SHOWERS = 13;
    public const PARTLY_SUNNY_WITH_SHOWERS = 14;
    public const THUNDER_STORMS = 15;
    public const MOSTLY_CLOUDY_WITH_THUNDER_STORMS = 16;
    public const PARTLY_SUNNY_WITH_THUNDER_STORMS = 17;
    public const RAIN = 18;
    public const FLURRIES = 19;
    public const MOSTLY_CLOUDY_WITH_FLURRIES = 20;
    public const PARTLY_SUNNY_WITH_FLURRIES = 21;
    public const SNOW = 22;
    public const MOSTLY_CLOUDY_WITH_SNOW = 23;
    public const ICE = 24;
    public const SLEET = 25;
    public const FREEZING_RAIN = 26;
    public const RAIN_AND_SNOW = 29;
    public const HOT = 30;
    public const COLD = 31;
    public const WINDY = 32;
    public const CLEAR_NIGHT = 33;
    public const MOSTLY_CLEAR_NIGHT = 34;
    public const PARTLY_CLOUDY_NIGHT = 35;
    public const INTERMITTENT_CLOUDS_NIGHT = 36;
    public const HAZY_MOONLIGHT = 37;
    public const MOSTLY_CLOUDY_NIGHT = 38;
    public const PARTLY_CLOUDY_WITH_SHOWERS_NIGHT = 39;
    public const MOSTLY_CLOUDY_WITH_SHOWERS_NIGHT = 40;
    public const PARTLY_CLOUDY_WITH_THUNDER_STORMS_NIGHT = 41;
    public const MOSTLY_CLOUDY_WITH_THUNDER_STORMS_NIGHT = 42;
    public const MOSTLY_CLOUDY_WITH_FLURRIES_NIGHT = 43;
    public const MOSTLY_CLOUDY_WITH_SNOW_NIGHT = 44;


    /**
     * @var string[]
     */
    protected static $fontAwesomeMapping = [
        self::DEFAULT_ICON                            => 'cloud',
        self::SUNNY                                   => 'sun',
        self::MOSTLY_SUNNY                            => 'sun-cloud',
        self::PARTLY_SUNNY                            => 'cloud-sun',
        self::INTERMITTENT_CLOUDS                     => 'clouds-sun',
        self::HAZY_SUNSHINE                           => 'sun-haze',
        self::MOSTLY_CLOUDY                           => 'clouds-sun',
        self::CLOUDY                                  => 'cloud',
        self::DREARY_OVERCAST                         => 'clouds',
        self::FOG                                     => 'fog',
        self::SHOWERS                                 => 'cloud-showers',
        self::MOSTLY_CLOUDY_WITH_SHOWERS              => 'cloud-showers-heavy',
        self::PARTLY_SUNNY_WITH_SHOWERS               => 'cloud-sun-rain',
        self::THUNDER_STORMS                          => 'thunderstorm',
        self::MOSTLY_CLOUDY_WITH_THUNDER_STORMS       => 'thunderstorm',
        self::PARTLY_SUNNY_WITH_THUNDER_STORMS        => 'thunderstorm-sun',
        self::RAIN                                    => 'cloud-rain',
        self::FLURRIES                                => 'cloud-hail',
        self::MOSTLY_CLOUDY_WITH_FLURRIES             => 'cloud-hail',
        self::PARTLY_SUNNY_WITH_FLURRIES              => 'sun-dust',
        self::SNOW                                    => 'cloud-snow',
        self::MOSTLY_CLOUDY_WITH_SNOW                 => 'cloud-snow',
        self::ICE                                     => 'snowflakes',
        self::SLEET                                   => 'cloud-sleet',
        self::FREEZING_RAIN                           => 'snowflake',
        self::RAIN_AND_SNOW                           => 'cloud-hail-mixed',
        self::HOT                                     => 'temperature-hot',
        self::COLD                                    => 'temperature-low',
        self::WINDY                                   => 'wind',
        self::CLEAR_NIGHT                             => 'moon-stars',
        self::MOSTLY_CLEAR_NIGHT                      => 'moon',
        self::PARTLY_CLOUDY_NIGHT                     => 'moon-cloud',
        self::INTERMITTENT_CLOUDS_NIGHT               => 'moon-cloud',
        self::HAZY_MOONLIGHT                          => 'smog',
        self::MOSTLY_CLOUDY_NIGHT                     => 'clouds-moon',
        self::PARTLY_CLOUDY_WITH_SHOWERS_NIGHT        => 'cloud-moon-rain',
        self::MOSTLY_CLOUDY_WITH_SHOWERS_NIGHT        => 'cloud-moon-rain',
        self::PARTLY_CLOUDY_WITH_THUNDER_STORMS_NIGHT => 'thunderstorm-moon',
        self::MOSTLY_CLOUDY_WITH_THUNDER_STORMS_NIGHT => 'thunderstorm-moon',
        self::MOSTLY_CLOUDY_WITH_FLURRIES_NIGHT       => 'cloud-moon-rain',
        self::MOSTLY_CLOUDY_WITH_SNOW_NIGHT           => 'cloud-snow',
    ];

    /**
     * @param int    $iconNumber
     * @param string $mode
     * @return string
     */
    public static function mapFromIconNumber(int $iconNumber, string $mode = self::MODE_REGULAR): string
    {
        if (!array_key_exists($iconNumber, static::$fontAwesomeMapping)) {
            $iconNumber = static::DEFAULT_ICON;
        }

        $icon = static::$fontAwesomeMapping[$iconNumber];

        return $mode . $icon;
    }
}
