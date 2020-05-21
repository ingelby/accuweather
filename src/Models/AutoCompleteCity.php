<?php

namespace Ingelby\Accuweather\Models;

use yii\base\Model;

class AutoCompleteCity extends Model
{
    public $key;
    public $rank;
    public $localisedName;
    public $countryName;
    public $countryId;
    public $administrativeAreaId;
    public $administrativeAreaName;

    public function rules()
    {
        return [
            [
                [
                    'key',
                    'rank',
                    'localisedName',
                    'countryName',
                    'countryId',
                    'administrativeAreaName',
                    'administrativeAreaId',
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
        return $this->localisedName . ', ' . $this->administrativeAreaName . ' (' . $this->countryName . ')';
    }
}
