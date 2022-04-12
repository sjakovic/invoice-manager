<?php

namespace App\DTO;

class InvoiceItemDTO
{
    public int $invoiceId;
    public string $itemDescription;
    public int $quantity;
    public float $amount;
}
