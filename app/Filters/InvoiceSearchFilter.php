<?php

namespace App\Filters;


use App\Interfaces\SearchFilterInterface;

class InvoiceSearchFilter implements SearchFilterInterface
{
    public string $customer;
    public string $year;

    public function loadParameters(): void
    {
        $this->customer = request('filter_customer', '');
        $this->year = request('filter_year', date('Y'));
    }
}
