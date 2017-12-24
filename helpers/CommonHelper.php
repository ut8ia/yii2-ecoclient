<?php

namespace ut8ia\ecoclient\helpers;

/**
 * Class CommonHelper
 * @package ut8ia\ecoclient\helpers
 */
class CommonHelper
{

    /**
     * @param $array
     * @param $multiplier
     * @return array
     */
    public static function arrayMult($array, $multiplier)
    {
        return array_map(function($n) use ($multiplier) {
            return $n === null ? null : $n * $multiplier;
        }, $array);
    }

}