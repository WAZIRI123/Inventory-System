<?php

namespace App\Http\Livewire\Sales;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use App\Exceptions\OutOfStockException;

class Create extends Component
{

    public $item;

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];

    /**
     * @var array
     */
    public $products = [];

    /**
     * @var array
     */
    public $employees = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.product_id' => '',
        'item.employee_id' => '',
        'item.quantity' => '',
        'item.product_id' => 'required',
        'item.employee_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.product_id' => 'Product Id',
        'item.employee_id' => 'Employee Id',
        'item.quantity' => 'Quantity',
        'item.product_id' => 'Product',
        'item.employee_id' => 'Employee',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    /**
     * @var string | int
     */
    public $primaryKey;

    /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.sales.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Sale::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('sales-table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products = Product::orderBy('name')->get();

        $this->employees = Employee::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $product = Product::find($this->item['product_id']);

        $product ->increaseStock($this->item['quantity']);
        if (!$product->inStock($this->item['quantity'])) {
            
            throw new OutOfStockException('product is out of stock');

            return;
        }


        $product ->decreaseStock($this->item['product_id']);
 

        $item = Sale::create([
            'product_id' => $this->item['product_id'] ?? '', 
            'employee_id' => $this->item['employee_id'] ?? '', 
            'quantity' => $this->item['quantity'] ?? '', 
            'product_id' => $this->item['product_id'] ?? 0, 
            'employee_id' => $this->item['employee_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('sales-table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Sale $sale): void
    {
        $this->resetErrorBag();
        $this->item = $sale;
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('name')->get();

        $this->employees = Employee::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('sales-table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
