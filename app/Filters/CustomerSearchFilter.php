<?php

namespace App\Filters;


use App\Interfaces\SearchFilterInterface;

class CustomerSearchFilter implements SearchFilterInterface
{
    public string $companyName;

    public function loadParameters(): void
    {
        $this->companyName = request('filter_company_name', '');
    }
}
