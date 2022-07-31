<?php

namespace App\Http\Requests;

use App\Rules\InvoiceItemsRequired;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceStorePutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'number' => ['required'],
            'year' => ['required'],
            'customer_id' => ['required'],
            'date_of_traffic' => ['required'],
            'payment_deadline' => ['required'],
            'items' => [new InvoiceItemsRequired()],
        ];
    }

    public function messages()
    {
        return [
            'number.required' => __('messages.validation_invoice_number_validation'),
        ];
    }
}
