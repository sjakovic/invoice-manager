<?php

namespace App\Mappers;

use App\DTO\InvoiceDTO;
use App\Enum\InvoiceStatus;
use App\Helpers\DateTimeHelper;
use App\Interfaces\MapperInterface;
use App\Repositories\CustomerRepository;

class InvoiceMapper implements MapperInterface {
    public function __construct(
        private CustomerRepository $customerRepository,
    ) {

    }

    public function mapToModelCreate(array $data): InvoiceDTO {
        $dto = new InvoiceDTO();
        $dto->year = (int)$data['year'];
        $dto->number = (int)$data['number'];
        $dto->numberMark = (string)$data['number_mark'];
        $dto->dateOfTraffic = (string)$data['date_of_traffic'];
        $dto->paymentDeadline = (string)$data['payment_deadline'];
        $dto->paymentStatus = InvoiceStatus::UNPAID;
        $dto->customerId = (int)$data['customer_id'];
        $dto->total = 0;

        array_walk($data['items'], function ($item) use ($dto) {
            if (!empty($item['desc']) && !empty($item['quantity']) && !empty($item['amount'])) {
                $dto->total += $item['quantity'] * $item['amount'];
                $dto->items[] = $item;
            }
        });

        $customer = $this->customerRepository->find($dto->customerId);

        $dto->customerName = $customer->company_name;
        $dto->customerPib = $customer->pib;
        $dto->customerMb = $customer->mb;
        $dto->customerAddress = $customer->address;
        $dto->customerCity = $customer->city;

        return $dto;
    }

    public function mapToModelUpdate(array $data) {
        // TODO: Implement mapToUpdate() method.
    }

    public function mapToModelCreateAttributes(InvoiceDTO $dto): array {
        $data = [];
        $data['year'] = $dto->year;
        $data['number'] = $dto->number;
        $data['number_mark'] = $dto->numberMark;
        $data['date_of_traffic'] = DateTimeHelper::dbDateFormat($dto->dateOfTraffic);
        $data['payment_deadline'] = DateTimeHelper::dbDateFormat($dto->paymentDeadline);
        $data['total'] = $dto->total;
        $data['payment_status'] = $dto->paymentStatus;
        $data['customer_id'] = $dto->customerId;
        $data['customer_name'] = $dto->customerName;
        $data['customer_pib'] = $dto->customerPib;
        $data['customer_mb'] = $dto->customerMb;
        $data['customer_address'] = $dto->customerAddress;
        $data['customer_city'] = $dto->customerCity;

        return $data;
    }
}
