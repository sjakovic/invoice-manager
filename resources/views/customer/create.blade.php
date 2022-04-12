@extends('layout.default')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ __('messages.page_title_customer_add') }}</h1>
    </div>
    @include('components.alert.errors')
    <div class="row">
        <div class="col-6 col-xs-12">
            <form method="POST" action="{{ route(name: 'customers', absolute: false) }}" class="form" id="customer_create_form">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_company_name') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="company_name"
                               class="form-control form-control-sm"
                               value="{{ old('company_name') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_pib') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="pib"
                               class="form-control form-control-sm"
                               value="{{ old('pib') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_mb') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="mb"
                               class="form-control form-control-sm"
                               value="{{ old('mb') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_email') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="email"
                               class="form-control form-control-sm"
                               value="{{ old('email') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_phone') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="phone"
                               class="form-control form-control-sm"
                               value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_address') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="address"
                               class="form-control form-control-sm"
                               value="{{ old('address') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_city') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="city"
                               class="form-control form-control-sm"
                               value="{{ old('city') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.customer_postal_code') }}
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <input type="text"
                               name="postal_code"
                               class="form-control form-control-sm"
                               value="{{ old('postal_code') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-sm-3 col-xs-12 offset-sm-3">
                        <input type="submit" name="btn_submit" class="btn btn-success" value="{{ __('messages.btn_save') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
