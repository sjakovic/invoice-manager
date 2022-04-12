<?php

namespace App\Http\Controllers;

use App\Filters\CustomerSearchFilter;
use App\Mappers\CustomerMapper;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private CustomerMapper     $customerMapper,
    )
    {
    }

    public function index()
    {
        $filter = new CustomerSearchFilter();
        $filter->loadParameters();

        $records = $this->customerRepository->table($filter);

        return view('customer.index', [
            'filter' => $filter,
            'records' => $records,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $this->getValidator()->validate();

        $customerDTO = $this->customerMapper->mapToModelCreateDTO($request->all());

        if ($this->customerRepository->create($customerDTO)) {
            return redirect()->route('customers')->with('success', __('messages.data_saved'));
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

    private function getValidator()
    {
        return Validator::make(request()->all(), [
            'company_name' => ['required'],
            'pib' => ['required'],
            'mb' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'postal_code' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
        ]);
    }
}
