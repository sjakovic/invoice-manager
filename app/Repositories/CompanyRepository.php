<?php

namespace App\Repositories;


use App\Enum\CacheKey;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;

final class CompanyRepository
{
    public function getCompanyData(): Company
    {
        $data = Cache::get(CacheKey::COMPANY_DATA);

        if (!$data) {
            $data = Company::all()->first();
            Cache::put(CacheKey::COMPANY_DATA, $data, now()->addHours(8));
        }

        return $data;
    }
}
