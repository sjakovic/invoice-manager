<?php

namespace App\Repositories;

use App\Enum\InvoiceStatus;
use App\Filters\InvoiceSearchFilter;
use App\Helpers\NumberHelper;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class InvoiceRepository extends BaseRepository
{
    public function __construct(
        protected Invoice          $invoice,
        private CustomerRepository $customerRepository,
        private CompanyRepository  $companyRepository,
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
            $invoice = new Invoice();

            DB::transaction(function () use ($data, $invoice) {
                $customer = $this->customerRepository->find($data['customer_id']);
                $company = $this->companyRepository->getCompanyData();

                $invoice->year = (int)$data['year'];
                $invoice->number = (int)$data['number'];
                $invoice->number_mark = (string)$data['number_mark'];
                $invoice->date_of_traffic = (string)$data['date_of_traffic'];
                $invoice->payment_deadline = (string)$data['payment_deadline'];
                $invoice->payment_status = InvoiceStatus::UNPAID;
                $invoice->domestic = (bool)@$data['domestic'];
                $invoice->exchange_rate = NumberHelper::dbDecimalFormat($data['exchange_rate']);
                $invoice->customer_id = (int)$data['customer_id'];
                $invoice->total = array_sum(array_column($data['items'], 'amount'));
                $invoice->customer_name = $customer->company_name;
                $invoice->customer_pib = $customer->pib;
                $invoice->customer_mb = $customer->mb;
                $invoice->customer_address = $customer->address;
                $invoice->customer_city = $customer->city;
                $invoice->company_name = $company->company_name;
                $invoice->company_pib = $company->pib;
                $invoice->company_mb = $company->mb;
                $invoice->company_address = $company->address;
                $invoice->company_city = $company->city;
                $invoice->company_postal_code = $company->postal_code;
                $invoice->company_invoice_text = '';
                $invoice->save();

                array_walk($data['items'], function ($item) use ($invoice) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->quantity = (int)$item['quantity'];
                    $invoiceItem->item_description = (string)$item['desc'];
                    $invoiceItem->amount = (float)$item['amount'];
                    $invoiceItem->save();
                });
            });
            return $invoice;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
            return false;
        }
    }

    public function getInvoiceNextNumber(string $year): int
    {
        $number = Invoice::where('year', '=', $year)->max('number');
        return is_null($number) ? 1 : ++$number;
    }

    public function getTrafficLast12Months(string $date): float
    {
        $dateFrom = date('Y-m-d 00:00:00', strtotime($date . ' -12 months'));
        $dateTo = date('Y-m-d 23:59:59', strtotime($date));

        return Invoice::whereBetween('date_of_traffic', [$dateFrom, $dateTo])
            ->where('domestic', true)
            ->sum('total');
    }
}
