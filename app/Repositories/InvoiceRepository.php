<?php

namespace App\Repositories;

use App\Enum\InvoiceStatus;
use App\Filters\InvoiceSearchFilter;
use App\Helpers\NumberHelper;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class InvoiceRepository extends BaseRepository
{
    public function __construct(
        protected Invoice          $invoice,
        private CustomerRepository $customerRepository,
    )
    {
        parent::__construct($this->invoice);
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

    public function create(array $data): Invoice|bool
    {
        try {
            $this->model = new Invoice();
            DB::transaction(function () use ($data) {
                $customer = $this->customerRepository->find($data['customer_id']);

                $this->model->year = (int)$data['year'];
                $this->model->number = (int)$data['number'];
                $this->model->number_mark = (string)$data['number_mark'];
                $this->model->date_of_traffic = (string)$data['date_of_traffic'];
                $this->model->payment_deadline = (string)$data['payment_deadline'];
                $this->model->payment_status = InvoiceStatus::UNPAID;
                $this->model->domestic = (bool)@$data['domestic'];
                $this->model->exchange_rate = NumberHelper::dbDecimalFormat($data['exchange_rate']);
                $this->model->customer_id = (int)$data['customer_id'];
                $this->model->total = array_sum(array_column($data['items'], 'amount'));
                $this->model->customer_name = $customer->company_name;
                $this->model->customer_pib = $customer->pib;
                $this->model->customer_mb = $customer->mb;
                $this->model->customer_address = $customer->address;
                $this->model->customer_city = $customer->city;
                $this->model->save();

                array_walk($data['items'], function ($item) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $this->model->id;
                    $invoiceItem->quantity = (int)$item['quantity'];
                    $invoiceItem->item_description = (string)$item['desc'];
                    $invoiceItem->amount = (float)$item['amount'];
                    $invoiceItem->save();
                });
            });
            return $this->model;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update(int|string $id, array $data): bool
    {
        try {
            DB::transaction(function () use ($data, $id) {

                /*** @var Invoice $invoice ** */
                $this->model = $this->findById($id);

                $this->model->year = (int)$data['year'];
                $this->model->number = (int)$data['number'];
                $this->model->number_mark = (string)$data['number_mark'];
                $this->model->date_of_traffic = (string)$data['date_of_traffic'];
                $this->model->payment_deadline = (string)$data['payment_deadline'];
                $this->model->payment_status = InvoiceStatus::UNPAID;
                $this->model->domestic = (bool)@$data['domestic'];
                $this->model->exchange_rate = NumberHelper::dbDecimalFormat($data['exchange_rate']);
                $this->model->customer_id = (int)$data['customer_id'];
                $this->model->total = array_sum(array_column($data['items'], 'amount'));
                $this->model->save();

                $this->model->items->each(function (InvoiceItem $item) {
                    $item->delete();
                });
                array_walk($data['items'], function ($item) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $this->model->id;
                    $invoiceItem->quantity = (int)$item['quantity'];
                    $invoiceItem->item_description = (string)$item['desc'];
                    $invoiceItem->amount = (float)$item['amount'];
                    $invoiceItem->save();
                });
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
