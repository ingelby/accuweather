<?php

namespace Ingelby\Accuweather\Models;

use Ingelby\Accuweather\Helpers\Constants;
use yii\base\Model;

class CurrentConditions extends Model
{
    /**
     * @var string
     */
    public $weatherText;
    /**
     * @var string
     */
    public $weatherIconNumber;
    /**
     * @var string
     */
    public $localObservationDateTime;
    /**
     * @var string
     */
    public $temperatureDegrees;
    /**
     * @var string
     */
    public $temperatureHighDegrees;
    /**
     * @var string
     */
    public $temperatureLowDegrees;
    /**
     * @var string
     */
    public $temperatureFahrenheit;
    /**
     * @var string
     */
    public $temperatureHighFahrenheit;
    /**
     * @var string
     */
    public $temperatureLowFahrenheit;
    /**
     * @var string
     */
    public $mobileUrl;
    /**
     * @var string
     */
    public $url;

    public $fullResponseObject;

    /**
     * @return string
     */
    public function getSmallIcon()
    {
        $iconNumber = str_pad($this->weatherIconNumber, 2, '0', STR_PAD_LEFT);

        //Todo, maybe there is a better way of doing this?
        return 'https://developer.accuweather.com/sites/default/files/' . $iconNumber . '-s.png';
    }


    /**
     * @param string $units
     * @return string
     */
    public function getTemperature($units)
    {
        if (Constants::IMPERIAL === $units) {
            return $this->temperatureFahrenheit . '°F';
        }

        return $this->temperatureDegrees . '°C';
    }

    /**
     * @param string $units
     * @return string
     */
    public function getHighTemperature($units)
    {
        if (Constants::IMPERIAL === $units) {
            return $this->temperatureHighFahrenheit . '°F';
        }

        return $this->temperatureHighDegrees . '°C';
    }

    /**
     * @param string $units
     * @return string
     */
    public function getLowTemperature($units)
    {
        if (Constants::IMPERIAL === $units) {
            return $this->temperatureLowFahrenheit . '°F';
        }

        return $this->temperatureLowDegrees . '°C';
    }


    public function rules()
    {
        return [
            [
                [
                    'weatherText',
                    'weatherIconNumber',
                    'localObservationDateTime',
                    'temperatureDegrees',
                    'temperatureFahrenheit',
                    'mobileUrl',
                    'url',
                    'fullResponseObject',
                    'temperatureHighDegrees',
                    'temperatureLowDegrees',
                    'temperatureHighFahrenheit',
                    'temperatureLowFahrenheit',
                ],
                'safe',
            ],
        ];
    }
}
