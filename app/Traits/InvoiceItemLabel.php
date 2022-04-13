<?php

namespace App\Traits;

use App\Helpers\NumberHelper;
use App\Models\InvoiceItem;

trait InvoiceItemLabel
{
    public function getTotalLabel(InvoiceItem $invoiceItem): string
    {
        return NumberHelper::webFormatFloat($invoiceItem->quantity * $invoiceItem->amount);
    }

    public function getAmountLabel(InvoiceItem $invoiceItem): string
    {
        return NumberHelper::webFormatFloat($invoiceItem->amount);
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
