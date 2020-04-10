<?php

namespace Ingelby\Accuweather\Models;

use Carbon\Carbon;
use Ingelby\Accuweather\Helpers\Constants;
use yii\base\Model;

class HourlyForecast extends Model
{
    public $dateTime;
    public $weatherIconNumber;
    public $temperatureFahrenheit;
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
                    'temperatureFahrenheit',
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
    public function getTimeInShortForm(): ?string
    {
        if (null === $this->dateTime) {
            return 'Unk';
        }

        try {
            $carbon = Carbon::parse($this->dateTime);
            return $carbon->format('g') . $carbon->latinMeridiem;
        } catch (\Throwable $throwable) {
            \Yii::error('Error parsing date: ' . $this->dateTime);
            return 'Err';
        }
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

        return Constants::convertToMetric($this->temperatureFahrenheit) . '°C';
    }
}
