<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'vendor_id' => $this->vendor_id,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'description' => $this->description,
            'quantity'    => $this->stock()
           
        ];
    }
}
