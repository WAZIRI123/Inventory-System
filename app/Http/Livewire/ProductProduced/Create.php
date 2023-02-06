<?php

namespace App\Http\Livewire\ProductProduced;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\ProductProduced;
use App\Models\Product;
use App\Models\User;
use App\Models\StockTransaction;

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
    public $users = [];

    /**
     * @var array
     */
    public $stockTransactions = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.quantity_produced' => '',
        'item.user_id' => '',
        'item.product_id' => '',
        'item.stock_transaction_id' => '',
        'item.product_id' => 'required',
        'item.user_id' => 'required',
        'item.stock_transaction_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.quantity_produced' => 'Quantity Produced',
        'item.user_id' => 'User Id',
        'item.product_id' => 'Product Id',
        'item.stock_transaction_id' => 'Stock Transaction Id',
        'item.product_id' => 'Product',
        'item.user_id' => 'User',
        'item.stock_transaction_id' => 'StockTransaction',
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
        return view('livewire.product-produced.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        ProductProduced::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('product-produced.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products = Product::orderBy('name')->get();

        $this->users = User::orderBy('name')->get();

        $this->stockTransactions = StockTransaction::orderBy('id')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = ProductProduced::create([
            'quantity_produced' => $this->item['quantity_produced'] ?? '', 
            'user_id' => $this->item['user_id'] ?? '', 
            'product_id' => $this->item['product_id'] ?? '', 
            'stock_transaction_id' => $this->item['stock_transaction_id'] ?? '', 
            'product_id' => $this->item['product_id'] ?? 0, 
            'user_id' => $this->item['user_id'] ?? 0, 
            'stock_transaction_id' => $this->item['stock_transaction_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('product-produced.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(ProductProduced $productproduced): void
    {
        $this->resetErrorBag();
        $this->item = $productproduced;
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('name')->get();

        $this->users = User::orderBy('name')->get();

        $this->stockTransactions = StockTransaction::orderBy('id')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('product-produced.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
