<?php

namespace App\Repositories;

use App\DTO\CustomerDTO;
use App\Filters\CustomerSearchFilter;
use App\Mappers\CustomerMapper;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class CustomerRepository
{
    public function __construct(
        private CustomerMapper $customerMapper,
    )
    {
    }

    public function table(CustomerSearchFilter $filter): Collection
    {
        $records = Customer::where($this->searchFilter($filter))->orderBy('company_name', 'asc')->get();

        return $records;
    }

    /**
     * @param CustomerSearchFilter $filter
     * @return \Closure
     */
    private function searchFilter(CustomerSearchFilter $filter): \Closure
    {
        return function ($query) use ($filter) {
            if (!empty($filter->companyName)) {
                $query->where(
                    DB::raw('LOWER(company_name)'), 'like', '%' . strtolower($filter->companyName) . '%'
                );
            }
        };
    }

    public function find(int $id): Customer|null
    {
        return Customer::findOrFail($id);
    }

    public function all(): Collection
    {
        return Customer::all();
    }

    public function create(CustomerDTO $customerDTO): bool
    {
        try {
            $data = $this->customerMapper->mapToModelUpdateAttributes($customerDTO);
            Customer::create($data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
