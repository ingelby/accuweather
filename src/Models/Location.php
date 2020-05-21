<?php

namespace Ingelby\Accuweather\Models;

use yii\base\Model;

class Location extends Model
{
    public $key;
    public $rank;
    public $localisedName;
    public $countryName;
    public $countryId;
    public $administrativeAreaId;
    public $administrativeAreaName;
    public $type;

    public function rules()
    {
        return [
            [
                [
                    'type',
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
