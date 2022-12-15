<?php

namespace App\Traits;

trait BooleanHelper
{
    public function isTrue(string|int|bool $value): bool
    {
        return !empty($value);
    }

    public function isFalse(string|int|bool $value): bool
    {
        return empty($value);
    }
}
