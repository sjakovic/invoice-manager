<?php

namespace App\Mappers;

use App\DTO\InvoiceItemDTO;
use App\Interfaces\MapperInterface;

class InvoiceItemMapper implements MapperInterface
{
    public function toCreateInvoiceItemDTO(array $data): InvoiceItemDTO
    {
        $dto = new InvoiceItemDTO();
        $dto->quantity = (int)$data['quantity'];
        $dto->itemDescription = (string)$data['desc'];
        $dto->amount = (float)$data['amount'];

        return $dto;
    }
}
