<?php

namespace App\Mappers;

use App\DTO\InvoiceDTO;
use App\Enum\InvoiceStatus;
use App\Helpers\NumberHelper;
use App\Interfaces\MapperInterface;
use App\Repositories\CustomerRepository;

class InvoiceMapper implements MapperInterface
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private InvoiceItemMapper  $invoiceItemMapper,
    )
    {

    }

    public function toCreateInvoiceDTO(array $data): InvoiceDTO
    {
        $dto = new InvoiceDTO();
        $dto->year = (int)$data['year'];
        $dto->number = (int)$data['number'];
        $dto->numberMark = (string)$data['number_mark'];
        $dto->dateOfTraffic = (string)$data['date_of_traffic'];
        $dto->paymentDeadline = (string)$data['payment_deadline'];
        $dto->paymentStatus = InvoiceStatus::UNPAID;
        $dto->domestic = (bool)@$data['domestic'];
        $dto->exchangeRate = NumberHelper::dbDecimalFormat($data['exchange_rate']);
        $dto->customerId = (int)$data['customer_id'];
        $dto->total = 0;

        array_walk($data['items'], function ($item) use ($dto) {
            if (!empty($item['desc']) && !empty($item['quantity']) && !empty($item['amount'])) {
                $invoiceItemDTO = $this->invoiceItemMapper->toCreateInvoiceItemDTO($item);
                $dto->total += $invoiceItemDTO->quantity * $invoiceItemDTO->amount;
                $dto->items[] = $invoiceItemDTO;
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
}
