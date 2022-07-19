<?php

namespace App\DTO;

class InvoiceItemDTO extends BaseDTO
{
    public int $invoiceId;
    public string $itemDescription;
    public int $quantity;
    public float $amount;

    public function toArray()
    {
        return [
          'invoice_id' => $this->invoiceId,
          'item_description' => $this->itemDescription,
          'quantity' => $this->quantity,
          'amount' => $this->amount
        ];
    }
}
