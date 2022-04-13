@php
    /*** @var \App\Models\Invoice $invoice ***/
    /*** @var \App\Models\InvoiceItem $item ***/
    /*** @var \App\Models\Company $varCompany ***/
@endphp
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'dejavu sans';
            font-size: 12px;
        }

        .bill-td {
            padding: 0;
            width: 120px;
        }

        .table-item-td-padding {
            padding: 5px 3px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .invoice-table {
            margin-top: 50px;
            width: 100%;
        }

        .bg-table-head {
            background-color: #ccc;
        }

        .bg-table-item {
            background-color: #f7f7f7;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <td>
            <div style="font-size: 13px;">{{ $varCompany->company_name }}</div>
            <div>{{ $varCompany->address }}, {{ $varCompany->postal_code }} {{ $varCompany->city }}</div>
            <div>{{ __('messages.invoice_pdf_pib') }} {{ $varCompany->pib }}</div>
            <div>{{ __('messages.invoice_pdf_mb') }} {{ $varCompany->mb }}</div>
            <div>{{ __('messages.invoice_pdf_account_number') }} {{ $varCompany->account_number }}</div>
        </td>
    </tr>
</table>

<table class="invoice-table">
    <tr>
        <td style="text-align: center;"><h1>{{ __('messages.invoice_pdf_bill') }}</h1></td>
    </tr>
</table>

<table class="invoice-table">
    <tr>
        <td style="width: 400px;">
            <table>
                <tr>
                    <td class="bill-td">Број:</td>
                    <td>{{ $invoice->getInvoiceNumberLabel($invoice) }}</td>
                </tr>
                <tr>
                    <td class="bill-td">Место:</td>
                    <td>Београд</td>
                </tr>
                <tr>
                    <td class="bill-td">Датум рачуна:</td>
                    <td>{{ $invoice->getDateOfTrafficLabel($invoice) }}</td>
                </tr>
                <tr>
                    <td class="bill-td">Доспеће:</td>
                    <td>{{ $invoice->getPaymentDeadline($invoice) }}</td>
                </tr>
            </table>
        </td>
        <td>
            <div>{{ $invoice->getCustomerNameLabel($invoice) }}</div>
            <div>{{ $invoice->getCustomerAddress($invoice) }}</div>
            <div>{{ $invoice->getCustomerCity($invoice) }}</div>
            <div>{{ __('messages.invoice_pdf_pib') }} {{ $invoice->getCustomerPIB($invoice)}}</div>
            <div>{{ __('messages.invoice_pdf_mb') }} {{ $invoice->getCustomerMB($invoice) }}</div>
        </td>
    </tr>
</table>

<table class="invoice-table">
    <tr class="bg-table-head">
        <th class="table-item-td-padding">{{ __('messages.invoice_pdf_col_service') }}</th>
        <th>{{ __('messages.invoice_pdf_col_service') }}</th>
        <th>{{ __('messages.invoice_pdf_col_quantity') }}</th>
        <th>{{ __('messages.invoice_pdf_col_price') }}</th>
        <th>{{ __('messages.invoice_pdf_col_discount') }}</th>
        <th>{{ __('messages.invoice_pdf_col_currency') }}</th>
    </tr>
    @foreach($invoice->items as $item)
        <tr class="bg-table-item">
            <td class="table-item-td-padding">{{ $item->getItemDescriptionLabel($item) }}</td>
            <td class="table-item-td-padding"></td>
            <td class="table-item-td-padding text-center">{{ $item->getQuantityLabel($item) }}</td>
            <td class="table-item-td-padding text-right">{{ $item->getAmountLabel($item) }}</td>
            <td class="table-item-td-padding"></td>
            <td class="table-item-td-padding text-right">{{ $item->getTotalLabel($item) }}</td>
        </tr>
    @endforeach
    <tr class="bg-table-item">
        <th colspan="5" class="table-item-td-padding text-right">{{ __('messages.invoice_pdf_total') }}</th>
        <td style="text-align: right;">{{ $invoice->getTotalLabel($invoice) }}</td>
    </tr>
    <tr>
        <th colspan="5" class="table-item-td-padding text-right">{{ __('messages.invoice_pdf_for_payment') }}</th>
        <th class="text-right">{{ $invoice->getTotalLabel($invoice) }}</th>
    </tr>
</table>

<table class="invoice-table">
    <tr>
        <td>{!! __('messages.invoice_pdf_info') !!}</td>
    </tr>
</table>
</body>
</html>
