<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\Stock\checkInStock;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
   
        $rules = [];

        $productId = $this->input('product_id');
        $rules["product_id"] = ['required', 'exists:products,id'];
            $rules["quantity"] = ['required', 'numeric', 'min:1',new checkInStock($productId)];
        
        return $rules;
    }

  

}
