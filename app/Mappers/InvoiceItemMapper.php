<?php

namespace App\Mappers;

use App\DTO\InvoiceItemDTO;
use App\Interfaces\MapperInterface;

class InvoiceItemMapper implements MapperInterface
{
    public function mapToModelCreate(array $data): InvoiceItemDTO
    {
        $dto = new InvoiceItemDTO();
        $dto->invoiceId = (int) $data['invoice_id'];
        $dto->quantity = (int) $data['quantity'];
        $dto->itemDescription = (string) $data['desc'];
        $dto->amount = (float) $data['amount'];

        return $dto;
    }

    public function mapToModelUpdate(array $data)
    {
        // TODO: Implement mapToUpdate() method.
    }

    public function mapToModelCreateAttributes(InvoiceItemDTO $dto): array
    {
        $data = [];
        $data['invoice_id'] = $dto->invoiceId;
        $data['quantity'] = $dto->quantity;
        $data['item_description'] = $dto->itemDescription;
        $data['amount'] = $dto->amount;

        return $data;
    }
}
