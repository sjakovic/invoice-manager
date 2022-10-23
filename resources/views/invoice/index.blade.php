@extends('layout.default')
@php
    /*** @var \App\Models\Invoice $record ***/
@endphp
@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ __('messages.page_title_invoices') }}</h1>
    </div>
    <form method="GET" action="{{ route(name: 'invoices', absolute: false) }}" class="form" id="invoices_filter_form">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    @foreach(range(date('Y-m-d'), 2017) as $item)
                        <input type="radio"
                               class="btn-check"
                               name="filter_year"
                               id="filter_year_{{ $item }}"
                               value="{{ $item }}"
                               @if($item == $filter->year) checked @endif >
                        <label class="btn btn-outline-info" for="filter_year_{{ $item }}">{{ $item }}</label>
                    @endforeach
                </div>
            </div>
        </div>
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <input type="text"
                           name="filter_customer"
                           value="{{ $filter->customer }}"
                           class="form-control form-control-sm"
                           placeholder="{{ __('messages.invoice_customer') }}"/>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-success">
                    {{ __('messages.btn_search') }}
                </button>
            </div>
            <a href="{{ route(name: 'invoice-create', absolute: false) }}" class="btn btn-sm btn-outline-dark">
                {{ __('messages.btn_add') }}
            </a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr class="bg-warning">
                    <td class="text-end" colspan="7">
                        {!! __('messages.invoice_traffic_12_months', compact('currentDate', 'trafficAmount')) !!}
                    </td>
                </tr>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">{{ __('messages.invoice_number') }}</th>
                    <th scope="col" class="text-center">{{ __('messages.invoice_date_of_traffic') }}</th>
                    <th scope="col" class="text-center">{{ __('messages.invoice_customer') }}</th>
                    <th scope="col" class="text-center">{{ __('messages.invoice_total') }}</th>
                    <th scope="col" class="text-center">{{ __('messages.invoice_payment_status') }}</th>
                    <th scope="col" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            @foreach($records as $record)
                <tr>
                    <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                    <td class="text-center align-middle">{{ $record->getInvoiceNumberLabel($record) }}</td>
                    <td class="text-center align-middle">{{ $record->getDateOfTrafficLabel($record) }}</td>
                    <td class="text-start align-middle">{{ $record->getCustomerNameLabel($record) }}</td>
                    <td class="text-end align-middle">{{ $record->getTotalLabel($record) }}</td>
                    <td class="text-center align-middle">{!! $record->getStatusLabel($record) !!}</td>
                    <td class="fit-cell-width">
                        <a href="{{ route('invoice-pdf', ['id' => $record->id], false) }}"
                           class="btn btn-sm btn-danger"
                           target="_blank">{{ __('messages.btn_pdf') }}
                        </a>
                        <a href="{{ route('invoice-edit', ['id' => $record->id], false) }}"
                           class="btn btn-sm btn-warning">
                            {{ __('messages.btn_edit') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
