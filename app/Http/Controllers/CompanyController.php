<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyUpdatePostRequest;
use App\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyRepository $companyRepository,
    )
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('company.edit', [
            'company' => $this->companyRepository->getCompanyData(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyUpdatePostRequest $request
     * @param $id
     * @return void
     */
    public function update(CompanyUpdatePostRequest $request, string|int $id)
    {
        if ($this->companyRepository->update($id, $request->all())) {
            return redirect()->back()->with('success', __('messages.data_saved'));
        } else {
            return redirect()->back()->with('error', __('messages.data_error'));
        }
    }
}
