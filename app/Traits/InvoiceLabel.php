<?php

namespace App\Traits;

use App\Enum\InvoiceStatus;
use App\Helpers\DateTimeHelper;
use App\Helpers\NumberHelper;
use App\Models\Invoice;

trait InvoiceLabel
{
    public function getInvoiceNumberLabel(Invoice $invoice): string
    {
        return $invoice->year . '-' . $invoice->number . $invoice->number_mark;
    }

    public function getDateOfTrafficLabel(Invoice $invoice): string
    {
        return DateTimeHelper::webDateFormat($invoice->date_of_traffic);
    }

    public function getStatusLabel(Invoice $invoice): string
    {
        $tpl = match ($invoice->payment_status) {
            InvoiceStatus::UNPAID => '<span class="text-danger">%s</span>',
            InvoiceStatus::PAID => '<span class="text-success">%s</span>',
        };

        return sprintf($tpl, InvoiceStatus::getLabel($invoice->payment_status));
    }

    public function getCustomerNameLabel(Invoice $invoice): string
    {
        return $invoice->customer_name;
    }

    public function getTotalLabel(Invoice $invoice): string
    {
        return NumberHelper::webFormatFloat($invoice->total);
    }

}
