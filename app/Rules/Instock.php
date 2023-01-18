<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\InvokableRule;

class Instock implements InvokableRule
{

protected $quantity;

public function __construct($quantity)
{
    $this->$quantity=$quantity;
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
     
    
        $product=Product::find($value);

            dd($product->inStock($this->quantity));

        if (!$product->inStock($this->quantity)) {
            
            $fail('The :attribute product is out of stock.');

        }

    }
}
