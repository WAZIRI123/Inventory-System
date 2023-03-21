<?php

namespace App\Http\Requests;

use App\Rules\Stock\checkInStock;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $productId = $this->input('product_id');
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                new checkInStock($productId)
            ],
            'product_id' => 'required|exists:products,id',
            'employee_id' => 'required|exists:employees,id',
        ];
    }
}
