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
    <div class="card">
        <div class="card-header">
            <ul class="nav">
                <li class="nav-item p-1">
                    <a class="btn btn-dark" aria-current="page" href="#">Faktura</a>
                </li>
                <li class="nav-item p-1">
                    <a class="btn btn-outline-dark" href="#">Uplate</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-xs-12">
                    <form method="POST"
                          action="{{ route('invoice-update', ['id' => $invoice->id], false) }}"
                          class="form" id="invoices_edit_form">
                        @csrf
                        <div class="row mb-1">
                            <label class="col-sm-3 col-form-label text-end">
                                {{ __('messages.invoice_number') }}
                            </label>
                            <div class="col-sm-3 col-xs-12">
                                <input type="number"
                                       name="number"
                                       class="form-control form-control-sm"
                                       value="{{ old('number', $invoice->number) }}">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 col-form-label text-end">
                                {{ __('messages.invoice_year') }}
                            </label>
                            <div class="col-sm-3 col-xs-12">
                                <select name="year" class="form-control form-control-sm col-sm-2">
                                    @foreach(range(date('Y'), 2017) as $item)
                                        <option value="{{ $item }}" @if($item === $invoice->year) selected @endif>
                                            {{ $item }}
                                        </option>
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
                                       value="{{ old('number_mark', $invoice->number_mark) }}">
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
                                        <option
                                            value="{{ $customer->id }}"
                                            @if(old('customer_id', $invoice->customer_id) == $customer->id) selected @endif>
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
                                       value="{{ old('date_of_traffic', $invoice->date_of_traffic) }}"
                                       min="2015-01-01"
                                       max="2100-12-31"/>
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
                                       value="{{ old('payment_deadline', $invoice->payment_deadline) }}"/>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 col-form-label text-end">
                                {{ __('messages.invoice_domestic') }}
                            </label>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-check mt-2">
                                    <input
                                        name="domestic"
                                        id="domestic"
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                        @if(old('domestic', $invoice->domestic) == 1) checked @endif>
                                    <label class="form-check-label" for="domestic">
                                        {{ __('messages.invoice_domestic_yes') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 col-form-label text-end">
                                {{ __('messages.invoice_exchange_rate') }}
                            </label>
                            <div class="col-sm-2 col-xs-12">
                                <input type="text"
                                       name="exchange_rate"
                                       class="form-control form-control-sm col-sm-2"
                                       value="{{ old('exchange_rate', $invoice->exchange_rate) }}">
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
                                    @php /*** @var \App\Models\InvoiceItem $invoiceItem ***/ @endphp
                                    @foreach($invoice->items as $invoiceItem)
                                        <tr class="js_invoice_item">
                                            <td>
                                                <input name="items[{{ $loop->index }}][desc]"
                                                       type="text"
                                                       class="form-control form-control-sm"
                                                       value="{{ $invoiceItem->item_description }}">
                                            </td>
                                            <td>
                                                <input name="items[{{ $loop->index }}][quantity]"
                                                       type="number"
                                                       minl="1"
                                                       class="form-control form-control-sm js_quantity"
                                                       value="{{ $invoiceItem->quantity }}">
                                            </td>
                                            <td>
                                                <input name="items[{{ $loop->index }}][amount]"
                                                       type="text"
                                                       class="form-control form-control-sm js_amount"
                                                       value="{{ $invoiceItem->amount }}">
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
                                        <th class="text-end"><span id="total">{{ $invoiceItem->total }}</span></th>
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
                                <input type="submit" name="btn_submit" class="btn btn-success"
                                       value="{{ __('messages.btn_save') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
