<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\InvokableRule;

class Instock implements InvokableRule
{

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
     
        $product_id = $this->data['item']['product_id'];
        $product = Product::find($product_id);
    

        if (!$product->inStock($value)) {
            
            $fail('The :attribute product is out of stock.');

        }

    }
}
