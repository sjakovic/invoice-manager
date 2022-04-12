@extends('layout.default')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ __('messages.page_title_invoice_add') }}</h1>
    </div>
    @include('components.alert.errors')
    <div class="row">
        <div class="col-6 col-xs-12">
            <form method="POST" action="{{ route(name: 'invoices', absolute: false) }}" class="form" id="invoices_create_form">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_number') }}
                    </label>
                    <div class="col-sm-3 col-xs-12">
                        <input type="number"
                               name="number"
                               class="form-control form-control-sm"
                               value="{{ old('number', $nextInvoiceNumber) }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_year') }}
                    </label>
                    <div class="col-sm-3 col-xs-12">
                        <select name="year" class="form-control form-control-sm col-sm-2">
                            <option value="2022">2022</option>
                            <option value="2022">2021</option>
                            <option value="2022">2020</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_number_mark') }}
                    </label>
                    <div class="col-sm-3 col-xs-12">
                        <input type="text"
                               name="number_mark"
                               class="form-control form-control-sm col-sm-2"
                               value="{{ old('number_mark') }}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_customer') }}
                    </label>
                    <div class="col-sm-7">
                        @php /*** @var \App\Models\Customer $customer ***/ @endphp
                        <select name="customer_id" class="form-control form-control-sm">
                            <option value=""></option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_date_of_traffic') }}
                    </label>
                    <div class="col-sm-3 col-xs-12">
                        <input type="date"
                               name="date_of_traffic"
                               class="form-control form-control-sm"
                               value="{{ date('Y-m-d') }}"
                               min="2015-01-01"
                               max="2100-12-31" />
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_payment_deadline') }}
                    </label>
                    <div class="col-sm-3 col-xs-12">
                        <input type="date"
                               name="payment_deadline"
                               class="form-control form-control-sm" placeholder="" />
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_items') }}
                    </label>
                    <div class="col-sm-9">
                        <table class="table table-responsive-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th class="col-6 text-center">{{ __('messages.invoice_item_desc') }}</th>
                                    <th class="col-2 text-center">{{ __('messages.invoice_item_quantity') }}</th>
                                    <th class="col-3 text-center">{{ __('messages.invoice_item_amount') }}</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>
                                    <input name="items[0][desc]"
                                           type="text"
                                           class="form-control form-control-sm"
                                           value="{{ old('items[0][desc]') }}">
                                </td>
                                <td>
                                    <input name="items[0][quantity]"
                                           type="number"
                                           minl="1"
                                           class="form-control form-control-sm js_quantity"
                                           value="{{ old('items[0][quantity]', 1) }}">
                                </td>
                                <td>
                                    <input name="items[0][amount]"
                                           type="text"
                                           class="form-control form-control-sm js_amount"
                                           value="{{ old('items[0][amount]', 0) }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="items[1][desc]"
                                           type="text"
                                           class="form-control form-control-sm"
                                           value="{{ old('items[1][desc]') }}">
                                </td>
                                <td>
                                    <input name="items[1][quantity]"
                                           type="number"
                                           minl="1"
                                           class="form-control form-control-sm js_quantity"
                                           value="{{ old('items[1][quantity]', 1) }}">
                                </td>
                                <td>
                                    <input name="items[1][amount]"
                                           type="text"
                                           class="form-control form-control-sm js_amount"
                                           value="{{ old('items[1][amount]', 0) }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="items[2][desc]"
                                           type="text"
                                           class="form-control form-control-sm"
                                           value="{{ old('items[2][desc]') }}">
                                </td>
                                <td>
                                    <input name="items[2][quantity]"
                                           type="number"
                                           minl="1"
                                           class="form-control form-control-sm js_quantity"
                                           value="{{ old('items[2][quantity]', 1) }}">
                                </td>
                                <td>
                                    <input name="items[2][amount]"
                                           type="text"
                                           class="form-control form-control-sm js_amount"
                                           value="{{ old('items[2][amount]', 0) }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end">
                                    Ukupno:
                                </td>
                                <th class="text-center"><span id="total"></span></th>
                            </tr>
                        </table>
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
