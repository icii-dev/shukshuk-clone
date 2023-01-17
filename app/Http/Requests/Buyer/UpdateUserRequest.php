<?php

namespace App\Http\Requests\Buyer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        return [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.auth()->id(),
            'password' => 'sometimes|nullable|string|min:6in',
            'last_name' => 'max:100',
//            'phone' => 'required',
//            'province_id' => 'required',
//            'district_id' => 'required',
//            'regency_id' => 'required',
//            'addresses' => 'required',
//            'date_of_birth' => 'required',
        ];
    }
}
