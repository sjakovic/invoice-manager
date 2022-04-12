<?php

namespace App\Mappers;

use App\DTO\CustomerDTO;
use App\Interfaces\MapperInterface;

class CustomerMapper implements MapperInterface
{
    public function mapToModelCreateDTO(array $data): CustomerDTO
    {
        $dto = new CustomerDTO();
        $dto->companyName = (string)$data['company_name'];
        $dto->pib = (string)$data['pib'];
        $dto->mb = (string)$data['mb'];
        $dto->address = (string)$data['address'];
        $dto->city = (string)$data['city'];
        $dto->postalCode = (string)$data['postal_code'];
        $dto->email = (string)$data['email'];
        $dto->phone = (string)$data['phone'];

        return $dto;
    }

    public function mapToModelUpdateAttributes(CustomerDTO $dto): array
    {
        $data = [];
        $data['company_name'] = $dto->companyName;
        $data['pib'] = $dto->pib;
        $data['mb'] = $dto->mb;
        $data['address'] = $dto->address;
        $data['city'] = $dto->city;
        $data['postal_code'] = $dto->postalCode;
        $data['email'] = $dto->email;
        $data['phone'] = $dto->phone;

        return $data;
    }

}
