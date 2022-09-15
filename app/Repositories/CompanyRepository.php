<?php

namespace App\Repositories;


use App\Models\Company;

final class CompanyRepository extends BaseRepository
{
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }

    public function getCompanyData(): Company
    {
        $company = Company::all()->first();

        if (!$company) {
            $company = $this->model;
        }

        return $company;
    }

    public function update(int|string $id, array $data): bool
    {
        try {
            /*** @var Company $company ** */
            $company = $this->findById($id);
            $company->company_name = $data['company_name'];
            $company->pib = $data['pib'];
            $company->mb = $data['mb'];
            $company->address = $data['address'];
            $company->city = $data['city'];
            $company->postal_code = $data['postal_code'];
            $company->account_number = $data['account_number'];
            $company->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
