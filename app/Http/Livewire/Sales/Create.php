<?php

namespace App\Http\Livewire\Sales;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
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
    public $customers = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.product_id' => '',
        'item.customer_id' => '',
        'item.quantity' => '',
        'item.product_id' => 'required',
        'item.customer_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.product_id' => 'Product Id',
        'item.customer_id' => 'Customer Id',
        'item.quantity' => 'Quantity',
        'item.product_id' => 'Product',
        'item.customer_id' => 'Customer',
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

        $this->customers = Customer::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $product = Product::find($this->item['product_id']);
        if (!$product->inStock($this->item['product_id'])) {
            
            throw new OutOfStockException('product is out of stock');

            return;
        }


        $product ->decreaseStock($this->item['product_id']);
 

        $item = Sale::create([
            'product_id' => $this->item['product_id'] ?? '', 
            'customer_id' => $this->item['customer_id'] ?? '', 
            'quantity' => $this->item['quantity'] ?? '', 
            'product_id' => $this->item['product_id'] ?? 0, 
            'customer_id' => $this->item['customer_id'] ?? 0, 
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

        $this->customers = Customer::orderBy('name')->get();
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
