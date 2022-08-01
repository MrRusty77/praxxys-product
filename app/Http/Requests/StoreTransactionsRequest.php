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
            'total_purchase' => 'required|min:1',
            'total_paid' => 'required|min:1',
            'product_list.*.product_id' => 'required|numeric|min:0',
            'product_list.*.qty' => 'required|numeric|min:0',
        ];
    }
}
