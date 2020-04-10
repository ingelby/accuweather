<?php

namespace Ingelby\Accuweather\Models;

use Carbon\Carbon;
use Ingelby\Accuweather\Helpers\Constants;
use yii\base\Model;

class DailyForecast extends Model
{
    public $dateTime;
    public $weatherIconNumber;
    public $temperatureHighFahrenheit;
    public $temperatureLowFahrenheit;
    public $mobileUrl;
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

    public function rules()
    {
        return [
            [
                [
                    'dateTime',
                    'weatherIconNumber',
                    'temperatureHighFahrenheit',
                    'temperatureLowFahrenheit',
                    'mobileUrl',
                    'url',
                    'fullResponseObject',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getDayInShortForm(): ?string
    {
        if (null === $this->dateTime) {
            return 'Unk';
        }

        try {
            return Carbon::parse($this->dateTime)->shortEnglishDayOfWeek;
        } catch (\Throwable $throwable) {
            \Yii::error('Error parsing date: ' . $this->dateTime);
            return 'Err';
        }
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

        return Constants::convertToMetric($this->temperatureHighFahrenheit) . '°C';
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

        return Constants::convertToMetric($this->temperatureLowFahrenheit) . '°C';
    }

}
