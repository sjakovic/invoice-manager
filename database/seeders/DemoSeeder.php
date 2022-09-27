<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function __construct(
        private CompanyRepository $companyRepository,
    )
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->count(10)->create()->each(function ($customer) {
            $years = [2017, 2018, 2019, 2020, 2021, 2022];
            $months = range(1, 12);
            $company = $this->companyRepository->getCompanyData();

            foreach ($years as $year) {
                foreach ($months as $month) {
                    $monthDB = str_pad($month, 2, 0, STR_PAD_LEFT);
                    $dateOfTraffic = date('Y-m-t', strtotime($year . '-' . $monthDB . '-01'));
                    DB::beginTransaction();

                    $inv = Invoice::factory()->create([
                        'year' => $year,
                        'number' => $month,
                        'customer_id' => $customer->id,
                        'customer_name' => $customer->company_name,
                        'customer_address' => $customer->address,
                        'customer_city' => $customer->city,
                        'customer_pib' => $customer->pib,
                        'customer_mb' => $customer->mb,
                        'date_of_traffic' => $dateOfTraffic,
                        'payment_deadline' => date('Y-m-d', strtotime($dateOfTraffic . ' + 10 days')),
                        'total' => rand(50000, 1500000),
                        'company_name' => $company->company_name,
                        'company_pib' => $company->pib,
                        'company_mb' => $company->mb,
                        'company_address' => $company->address,
                        'company_city' => $company->city,
                        'company_postal_code' => $company->postal_code,
                        'company_invoice_text' => __('messages.invoice_pdf_info'),
                    ]);

                    $count = rand(1, 3);
                    $amount = $inv->total / $count;
                    InvoiceItem::factory()->count($count)->create([
                        'invoice_id' => $inv->id,
                        'amount' => $amount,
                    ]);

                    DB::commit();
                }
            }
        });
    }
}
