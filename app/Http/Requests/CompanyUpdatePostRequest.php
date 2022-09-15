<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdatePostRequest extends FormRequest
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
            'company_name' => ['required'],
            'pib' => ['required', 'digits:9'],
            'mb' => ['required', 'digits:8'],
            'address' => ['required'],
            'city' => ['required'],
            'postal_code' => ['required'],
            'account_number' => ['required'],
        ];
    }
}
