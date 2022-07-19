<?php

namespace App\DTO;

use App\Helpers\DateTimeHelper;
use App\Helpers\NumberHelper;

class InvoiceDTO extends BaseDTO
{
    public int $customerId;
    public int $year;
    public int $number;
    public string $numberMark;
    public string $dateOfTraffic;
    public string $paymentDeadline;
    public float $total;
    public int $paymentStatus;
    public string $customerName;
    public string $customerPib;
    public string $customerMb;
    public string $customerAddress;
    public string $customerCity;
    public float|null $exchangeRate;
    public bool $domestic;
    public array $items;

    public function toArray(): array
    {
        $data = [];
        $data['year'] = $this->year;
        $data['number'] = $this->number;
        $data['number_mark'] = $this->numberMark;
        $data['date_of_traffic'] = DateTimeHelper::dbDateFormat($this->dateOfTraffic);
        $data['payment_deadline'] = DateTimeHelper::dbDateFormat($this->paymentDeadline);
        $data['total'] = $this->total;
        $data['payment_status'] = $this->paymentStatus;
        $data['customer_id'] = $this->customerId;
        $data['customer_name'] = $this->customerName;
        $data['customer_pib'] = $this->customerPib;
        $data['customer_mb'] = $this->customerMb;
        $data['customer_address'] = $this->customerAddress;
        $data['customer_city'] = $this->customerCity;
        $data['exchange_rate'] = $this->exchangeRate;
        $data['domestic'] = $this->domestic;

        return $data;
    }
}
