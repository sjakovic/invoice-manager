<?php

namespace App\Http\Controllers;

use App\Filters\InvoiceSearchFilter;
use App\Helpers\DateTimeHelper;
use App\Helpers\NumberHelper;
use App\Http\Requests\InvoiceStorePutRequest;
use App\Http\Requests\InvoiceUpdatePostRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceRepository  $invoiceRepository,
        private CustomerRepository $customerRepository,
    )
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $filter = new InvoiceSearchFilter();
        $filter->loadParameters();

        $records = $this->invoiceRepository->table($filter);

        $currentDate = date('Y-m-d');

        return view('invoice.index', [
            'filter' => $filter,
            'records' => $records,
            'currentDate' => sprintf(
                '<span class="fw-bold">%s</span>',
                DateTimeHelper::webDateFormat($currentDate)
            ),
            'trafficAmount' => sprintf(
                '<span class="fw-bold">%s</span>',
                NumberHelper::webFormatFloat($this->invoiceRepository->getTrafficLast12Months($currentDate))
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('invoice.create', [
            'customers' => $this->customerRepository->all(),
            'nextInvoiceNumber' => $this->invoiceRepository->getInvoiceNextNumber(DateTimeHelper::currentYear()),
            'invoiceItems' => old('items', [['desc' => '', 'quantity' => 1, 'amount' => '']]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceStorePutRequest $request)
    {
        if ($this->invoiceRepository->create($request->all())) {
            return redirect()->route('invoices')->with('success', __('messages.data_saved'));
        } else {
            return redirect()->back()->with('error', __('messages.data_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = $this->invoiceRepository->findById($id);
        $invoice->load('items');

        return view('invoice.edit', [
            'customers' => $this->customerRepository->all(),
            'invoice' => $invoice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InvoiceUpdatePostRequest $request
     * @param $id
     * @return void
     */
    public function update(InvoiceUpdatePostRequest $request, string|int $id)
    {
        if ($this->invoiceRepository->update($id, $request->all())) {
            return redirect()->back()->with('success', __('messages.data_saved'));
        } else {
            return redirect()->back()->with('error', __('messages.data_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pdf($id)
    {
        $invoice = $this->invoiceRepository->find($id);

        $pdf = Pdf::loadView('invoice.invoice-pdf', compact('invoice'));

        return $pdf->stream('invoice.pdf');
    }
}
