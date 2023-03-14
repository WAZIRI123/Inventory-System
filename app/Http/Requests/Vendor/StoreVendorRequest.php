<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVendorRequest extends FormRequest
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
            'name' => 'required|string',
            'contact_email' => ['required', 'email', Rule::unique('vendors', 'contact_email')->whereNull('deleted_at')],
            'contact_phone' => ['required', 'regex:/^[0-9]{10}$/'],

        ];
    }
}
