<?php

namespace App\Filters;


use App\Interfaces\SearchFilterInterface;

class InvoiceSearchFilter implements SearchFilterInterface
{
    public string $customer;

    public function loadParameters(): void
    {
        $this->customer = request('filter_customer', '');
    }
}
