<?php

namespace App\Enum;

class InvoiceStatus
{
    public const UNPAID = 1;
    public const PAID = 2;

    public static function getLabel(int $state): string
    {
        return match ($state) {
            self::UNPAID => __('messages.enum_UNPAID'),
            self::PAID => __('messages.enum_PAID'),
        };
    }

    public static function all(): array
    {
        return [
            self::UNPAID => self::getLabel(self::UNPAID),
            self::PAID => self::getLabel(self::PAID),
        ];
    }
}
