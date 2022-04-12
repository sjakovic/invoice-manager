<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [1000, 2000, 3000];
        foreach ($customers as $customerId) {
            $customer = new Customer();
            $customer->id = $customerId;
            $customer->company_name = "Firma " . $customerId;
            $customer->pib = rand(100000000, 999999999);
            $customer->mb = rand(10000000, 99999999);
            $customer->email = $customerId . '@email.com';
            $customer->address = 'Adresa ' . $customerId;
            $customer->city = 'Grad ' . $customerId;
            $customer->postal_code = $customerId;
            $customer->save();
        }

        $years = [2017, 2018, 2019, 2020, 2021];
        $months = range(1,12);

        foreach ($years as $year) {
            foreach($months as $month) {
                $monthDB = str_pad($month, 2, 0, STR_PAD_LEFT);

                try {
                    DB::transaction(function () use($year, $month, $customers, $monthDB) {
                        $customer = Customer::findOrFail($customers[rand(0,2)]);

                        $invoice = new Invoice();
                        $invoice->year = $year;
                        $invoice->number = $month;
                        $invoice->customer_id = $customer->id;
                        $invoice->customer_name = $customer->company_name;
                        $invoice->customer_address = $customer->address;
                        $invoice->customer_city = $customer->city;
                        $invoice->customer_pib = $customer->pib;
                        $invoice->customer_mb = $customer->mb;
                        $invoice->date_of_traffic = date('Y-m-t', strtotime($year . '-' . $monthDB . '-01'));
                        $invoice->payment_deadline = date('Y-m-d', strtotime($invoice->date_of_issue . ' + 10 days'));
                        $invoice->total = rand(50000, 350000);
                        $invoice->save();

                        $invoiceItem = new InvoiceItem();
                        $invoiceItem->invoice_id = $invoice->id;
                        $invoiceItem->item_description = 'Racunarsko programiranje';
                        $invoiceItem->amount = $invoice->total;
                        $invoiceItem->save();
                    });
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }
    }
}
