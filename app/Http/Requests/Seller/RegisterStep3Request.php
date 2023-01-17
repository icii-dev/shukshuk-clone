<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStep3Request extends FormRequest
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
     * @return array
     */
    public function rules()
    {
//        return [
//            'payment_method_ids' => 'required|array',
//            'payment_method_ids.*' => 'exists:payment_methods,id',
//            'delivery_unit_id' => 'required|exists:delivery_units,id',
//        ];

        return [
            'bank_code' => 'required',
            'account_number' => 'required|numeric',
            'account_holder_name' => 'required'
        ];
    }
}
