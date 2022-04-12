<?php

namespace App\DTO;

class InvoiceDTO
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
    public array $items;
}
