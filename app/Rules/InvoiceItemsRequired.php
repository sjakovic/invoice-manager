<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InvoiceItemsRequired implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return false;
        }

        if (!empty($value) && !is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if (empty($item['desc']) || empty($item['amount'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('messages.validation_items_required');
    }
}
