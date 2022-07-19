<?php

namespace App\Repositories;

use App\DTO\InvoiceDTO;
use App\Filters\InvoiceSearchFilter;
use App\Mappers\InvoiceItemMapper;
use App\Mappers\InvoiceMapper;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class InvoiceRepository
{
    public function __construct(
        private InvoiceMapper     $invoiceMapper,
        private InvoiceItemMapper $invoiceItemMapper,
    )
    {
    }

    /**
     * @param int $id
     * @return Invoice|Invoice[]|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find(int $id)
    {
        return Invoice::findOrFail($id);
    }

    public function table(InvoiceSearchFilter $filter): Collection
    {
        $records = Invoice::where($this->searchFilter($filter))->orderBy('year', 'desc')
            ->orderBy('number', 'desc')
            ->get();

        return $records;
    }

    /**
     * @param InvoiceSearchFilter $filter
     * @return \Closure
     */
    private function searchFilter(InvoiceSearchFilter $filter): \Closure
    {
        return function ($query) use ($filter) {
            if (!empty($filter->customer)) {
                $query->where(
                    DB::raw('LOWER(customer_name)'), 'like', '%' . strtolower($filter->customer) . '%'
                );
            }
            if (!empty($filter->year)) {
                $query->where('year', '=', $filter->year);
            }
        };
    }

    public function create(InvoiceDTO $dto): bool
    {
        try {
            DB::transaction(function () use ($dto) {

                $invoice = Invoice::create($dto->toArray());

                /*** @var \App\DTO\InvoiceItemDTO $itemDTO ** */
                foreach ($dto->items as $itemDTO) {
                    $itemDTO->invoiceId = $invoice->id;
                    InvoiceItem::create($itemDTO->toArray());
                }
            });
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }

    public function getInvoiceNextNumber(string $year): int
    {
        $number = Invoice::where('year', '=', $year)->max('number');

        return is_null($number) ? 1 : ++$number;
    }
}
