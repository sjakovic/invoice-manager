<?php


namespace App\Helpers;


class NumberHelper
{
    public static function webFormatFloat(string $str): string
    {
        return number_format($str, 2, ',', '.');
    }

    public static function dbDecimalFormat(float|null $value): float|null
    {
        if(is_null($value)) {
            return null;
        }

        return (float) number_format($value, 2, '.');
    }
}
