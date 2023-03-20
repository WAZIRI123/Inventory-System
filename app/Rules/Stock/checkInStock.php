<?php

namespace App\Rules\Stock;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class checkInStock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $productId;
    public function __construct($productId)
    {
        $this->productId=$productId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product = Product::find($this->productId);

        if (!$product->inStock($value)) {
        return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The provided quantity exceeds the stock quantity.';
    }
}
