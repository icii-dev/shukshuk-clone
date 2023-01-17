<?php

namespace App\Http\Requests\ProductVariant;

use App\Model\ProductVariant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CreateProductVariantsRequest extends FormRequest
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
            'variants.*.quantity'      => 'nullable|integer',
            'variants.*.price'  => 'required|numeric',
            'variants.*.discount_value'  => 'nullable|numeric',
            'variants.*.discount_type' => [
                'nullable',
                Rule::in([
                    ProductVariant::DISCOUNT_TYPE_PERCENT,
                    ProductVariant::DISCOUNT_TYPE_MONEY
                ]),
            ],
            'images.*'      => 'max:8000',
        ];
    }

    protected function prepareForValidation()
    {
        //
    }

    /**
     * @param Validator $validator
     */
    public function withValidator($validator)
    {
//        if (!$this->get('discount_value')) {
//            return;
//        }
//
//
//        if ($this->get('is_discount_percent')) {
//            $validator->addRules([
//                'discount_value' => 'min:0|max:100'
//            ]);
//        } else {
//            $validator->addRules([
//                'discount' => 'min:0|max:' . $this->get('price')
//            ]);
//        }
    }
}
