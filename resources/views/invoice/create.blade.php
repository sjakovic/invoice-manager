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
                            @foreach(range(date('Y'), 2017) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
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
                                <option value="{{ $customer->id }}" @if(old('customer_id') == $customer->id) selected @endif>
                                    {{ $customer->company_name }}
                                </option>
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
                               value="{{ old('date_of_traffic', date('Y-m-d')) }}"
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
                               class="form-control form-control-sm"
                               value="{{ old('payment_deadline', date('Y-m-d')) }}" />
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label text-end">
                        {{ __('messages.invoice_items') }}
                    </label>
                    <div class="col-sm-9">
                        <table class="table table-responsive-sm" id="table_invoice_items">
                            <thead class="bg-light">
                                <tr>
                                    <th class="col-6 text-center">{{ __('messages.invoice_item_desc') }}</th>
                                    <th class="col-2 text-center">{{ __('messages.invoice_item_quantity') }}</th>
                                    <th class="col-3 text-center">{{ __('messages.invoice_item_amount') }}</th>
                                    <th class="col-3 text-center"></th>
                                </tr>
                            </thead>
                            @foreach($invoiceItems as $item)
                                <tr class="js_invoice_item">
                                    <td>
                                        <input name="items[{{ $loop->index }}][desc]"
                                               type="text"
                                               class="form-control form-control-sm"
                                               value="{{ $item['desc'] }}">
                                    </td>
                                    <td>
                                        <input name="items[{{ $loop->index }}][quantity]"
                                               type="number"
                                               minl="1"
                                               class="form-control form-control-sm js_quantity"
                                               value="{{ $item['quantity'] }}">
                                    </td>
                                    <td>
                                        <input name="items[{{ $loop->index }}][amount]"
                                               type="text"
                                               class="form-control form-control-sm js_amount"
                                               value="{{ $item['amount'] }}">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger js_btn_item_remove">
                                            {{ __('messages.btn_delete') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-end">
                                    {{ __('messages.invoice_item_total') }}
                                </td>
                                <th class="text-center"><span id="total"></span></th>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="bg-light">
                                    <button id="btn_item_add" class="btn btn-sm btn-outline-dark float-end">
                                        {{ __('messages.invoice_item_btn_add') }}
                                    </button>
                                </td>
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
