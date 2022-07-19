<?php

namespace App\Http\Controllers;

use App\Filters\InvoiceSearchFilter;
use App\Helpers\DateTimeHelper;
use App\Mappers\InvoiceMapper;
use App\Models\Invoice;
use App\Repositories\CustomerRepository;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceRepository  $invoiceRepository,
        private CustomerRepository $customerRepository,
        private InvoiceMapper      $invoiceMapper,
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

        return view('invoice.index', [
            'filter' => $filter,
            'records' => $records,
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
    public function store(Request $request)
    {

        $this->getValidator()->validate();

        $invoiceDTO = $this->invoiceMapper->toCreateInvoiceDTO($request->all());

        if ($this->invoiceRepository->create($invoiceDTO)) {
            return redirect()->back()->with('success', __('messages.data_saved'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    private function getValidator()
    {
        return Validator::make(request()->all(), [
            'number' => ['required'],
            'year' => ['required'],
            'customer_id' => ['required'],
            'date_of_traffic' => ['required'],
            'payment_deadline' => ['required'],
            'items' => ['required'],
        ], [
            'number.required' => __('messages.validation_invoice_number_validation'),
        ]);
    }
}
