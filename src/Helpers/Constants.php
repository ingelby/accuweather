<?php


namespace Ingelby\Accuweather\Helpers;


class Constants
{
    public const METRIC = 'metric';
    public const IMPERIAL = 'imperial';

    /**
     * @param float $imperial
     * @return float
     */
    public static function convertToMetric($imperial): float
    {
        return round(($imperial - 32) / 1.8, 1);
    }

    /**
     * @param float $metric
     * @return float
     */
    public static function convertToImperial($metric): float
    {
        return round(($metric * (9/5)) + 32, 1);
    }
}
