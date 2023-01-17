<?php

namespace App\Http\Requests\Seller;

use App\Service\ProductService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ProductCreateRequest extends FormRequest
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
            'name' => 'required',
            'category_id' => 'required|integer',
            'description' => 'required',
            'weight' => 'required|numeric',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
//            'price' => stringNumberFormattedToInt($this->price),
//            'discount' => stringNumberFormattedToInt($this->discount),
//            'quantity' => stringNumberFormattedToInt($this->quantity),
        ]);
    }

    /**
     * @param Validator $validator
     */
    public function withValidator($validator)
    {
//        if (!$this->get('discount')) {
//            return;
//        }
//
//
//        if ($this->get('is_discount_percent')) {
//            $validator->addRules([
//                'discount' => 'min:0|max:100'
//            ]);
//        } else {
//            $validator->addRules([
//                'discount' => 'min:0|max:' . $this->get('price')
//            ]);
//        }
    }
}
