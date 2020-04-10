<?php

namespace Ingelby\Accuweather\Models;

use yii\base\Model;

class AutoCompleteCity extends Model
{
    public $key;
    public $rank;
    public $localisedName;
    public $country;
    public $countryCode;

    public function rules()
    {
        return [
            [
                [
                    'key',
                    'rank',
                    'localisedName',
                    'country',
                    'countryCode',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getFullFriendlyName()
    {
        return $this->localisedName . ' ' . $this->country . ' (' . $this->countryCode . ')';
    }
}
