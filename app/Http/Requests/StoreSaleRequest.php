<?php

namespace App\Http\Requests;

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
        $itemCount = $this->input('itemCount', 1);
        $rules = [];

        for ($i = 1; $i <= $itemCount; $i++) {
            $rules["item.{$i}.quantity"] = ['required', 'numeric', 'min:1'];
            $rules["item.{$i}.product_id"] = ['required', 'exists:products,id'];
        }

        return $rules;
    }
}
