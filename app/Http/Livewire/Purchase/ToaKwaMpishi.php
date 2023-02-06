<?php

namespace App\Http\Livewire\Purchase;

use App\Models\Employee;
use App\Models\Product;
use Livewire\Component;

class ToaKwaMpishi extends Component
{
    public $products;
    public $employees;
    public $item;


        /**
     * @var array
     */
    protected $rules = [
        'item.product_id' => 'required|integer|exists:products,id',
        'item.employee_id' => 'required|integer|exists:employees,id',
        'item.quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->products =Product::pluck('name', 'id');
        $this->employees = Employee::pluck('name','id');
    }

    public function render()
    {
        return view('livewire.purchase.toa-kwa-mpishi');
    }
}
