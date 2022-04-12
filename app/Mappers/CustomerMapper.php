<?php

namespace App\Mappers;

use App\DTO\InvoiceDTO;
use App\Interfaces\MapperInterface;
use App\Repositories\CustomerRepository;

class CustomerMapper implements MapperInterface
{
    public function __construct(
        private CustomerRepository $customerRepository,
    )
    {

    }

    public function mapToModelCreate(array $data): InvoiceDTO
    {
        // TODO: Implement mapToUpdate() method.
    }

    public function mapToModelUpdate(array $data)
    {
        // TODO: Implement mapToUpdate() method.
    }

}
