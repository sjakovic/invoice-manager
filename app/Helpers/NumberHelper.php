<?php


namespace App\Helpers;


class NumberHelper
{
    public static function webFormatFloat(string $str): string
    {
        return number_format($str, 2, ',', '.');
    }
}
