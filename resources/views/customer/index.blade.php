@extends('layout.default')
@php
/*** @var \App\Models\Customer $record ***/
/*** @var \App\Filters\CustomerSearchFilter $filter ***/
@endphp
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ __('messages.page_title_customers') }}</h1>
    </div>
    <form method="GET" action="{{ route(name: 'customers', absolute: false) }}" class="form" id="customers_filter_form">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <input type="text"
                           name="filter_company_name"
                           value="{{ $filter->companyName }}"
                           class="form-control form-control-sm"
                           placeholder="{{ __('messages.customer_company_name') }}" />
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
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">{{ __('messages.customer_company_name') }}</th>
                <th scope="col" class="text-center">{{ __('messages.customer_pib') }}</th>
                <th scope="col" class="text-center">{{ __('messages.customer_mb') }}</th>
                <th scope="col" class="text-center">{{ __('messages.customer_address') }}</th>
                <th scope="col" class="text-center">{{ __('messages.customer_city') }}</th>
                <th scope="col" class="text-center">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($records as $record)
                <tr>
                    <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                    <td class="text-center align-middle">{{ $record->company_name }}</td>
                    <td class="text-center align-middle">{{ $record->pib }}</td>
                    <td class="text-center align-middle">{{ $record->mb }}</td>
                    <td class="text-start align-middle">{{ $record->address }}</td>
                    <td class="text-center align-middle">{!! $record->city !!}</td>
                    <td class="fit-cell-width">
                        <a href="#" class="btn btn-sm btn-warning">{{ __('messages.btn_edit') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
