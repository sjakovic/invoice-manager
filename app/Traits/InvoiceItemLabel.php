<?php

namespace App\Traits;

use App\Helpers\NumberHelper;
use App\Models\InvoiceItem;

trait InvoiceItemLabel
{
    public function getTotalLabel(InvoiceItem $invoiceItem, bool $domestic = false, float $exchangeRate = null): string
    {
        return $domestic
            ? NumberHelper::webFormatFloat($invoiceItem->quantity * $invoiceItem->amount)
            : NumberHelper::webFormatFloat(($invoiceItem->quantity * $invoiceItem->amount) / $exchangeRate);
    }

    public function getAmountLabel(
        InvoiceItem $invoiceItem, bool $domestic = false, float $exchangeRate = null
    ): string
    {
        return $domestic
            ? NumberHelper::webFormatFloat($invoiceItem->amount)
            : NumberHelper::webFormatFloat($invoiceItem->amount / $exchangeRate);
    }

    public function getItemDescriptionLabel(InvoiceItem $invoiceItem): string
    {
        return $invoiceItem->item_description;
    }

    public function getQuantityLabel(InvoiceItem $invoiceItem): string
    {
        return $invoiceItem->quantity;
    }
}
