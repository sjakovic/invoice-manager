<?php


namespace App\Helpers;


class DateTimeHelper
{
    public static function webDateTimeFormat(string $dateTime): string
    {
        return date('d.m.Y H:i:s', strtotime($dateTime));
    }

    public static function webDateFormat(string $dateTime): string
    {
        return date('d.m.Y', strtotime($dateTime));
    }

    public static function webDateHourFormat(string $dateTime): string
    {
        return date('d.m.Y H:i', strtotime($dateTime));
    }

    public static function dbDateTimeFormat(string $dateTime): string
    {
        return date('Y-m-d H:i:s', strtotime($dateTime));
    }

    public static function dbDateFormat(string $date): string
    {
        return date('Y-m-d', strtotime($date));
    }

    public static function currentYear(): string
    {
        return date('Y');
    }
}
