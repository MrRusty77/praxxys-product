<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionsRequest extends FormRequest
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
            'total_amount' => 'required|min:1',
            'total_items' => 'required|min:1',
            'products.*.product_id' => 'required|numeric|min:1',
            'products.*.cart_id' => 'required|numeric|min:1',
            'products.*.qty' => 'required|numeric|min:1',
        ];
    }
}
