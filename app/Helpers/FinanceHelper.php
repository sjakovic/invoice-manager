<?php


namespace App\Helpers;


class FinanceHelper
{
    /**
     * @param float $amount
     * @param float $tax
     * @return string
     */
    public static function calculateMaxTax(float $amount, float $tax): string
    {
        return ($amount * $tax) / 100;
    }
}
