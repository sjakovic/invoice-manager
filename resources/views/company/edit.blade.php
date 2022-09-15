@extends('layout.default')
@php
    /*** @var \App\Models\Invoice $invoice ***/
@endphp
@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ __('messages.page_title_invoice_edit') }}</h1>
    </div>
    @include('components.alert.errors')
    <div class="row">
        <div class="col-6 col-xs-12">
            <form method="POST"
                  action="{{ route('company-update', ['id' => $company->id], false) }}"
                  class="form" id="company_edit_form">
                @csrf
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_name') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="company_name"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('company_name', $company->company_name) }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_pib') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="pib"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('pib', $company->pib) }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_mb') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="mb"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('mb', $company->mb) }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_address') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="address"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('address', $company->address) }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_city') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="city"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('city', $company->city) }}">
                    </div>
                </div>

                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_postal_code') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="postal_code"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('postal_code', $company->postal_code) }}">
                    </div>
                </div>

                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.company_account_number') }}
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text"
                               name="account_number"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('account_number', $company->account_number) }}">
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-sm-3 col-xs-12 offset-sm-3">
                        <input type="submit" name="btn_submit" class="btn btn-success"
                               value="{{ __('messages.btn_save') }}">
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
