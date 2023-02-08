<?php

namespace App\Http\Livewire\ProductProduced;

use App\Enums\StockTransactionStatus;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\ProductProduced;
use App\Models\Product;
use App\Models\User;
use App\Models\StockTransaction;

class Create extends Component
{

    public $item;
    public $oldQuantity ;

    public $StockTransaction;

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
        'item.StockTransaction_id' => 'required|exists:stock_transactions,id',
        'item.quantity_produced' => 'required|numeric|min:1',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.quantity_produced' => 'Quantity Produced',
        'item.StockTransaction_id' => 'stock',
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

 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->StockTransaction= StockTransaction::with('product')->where('employee_id',auth()->user()->id)->where('active',StockTransactionStatus::Active->value)->get();

    }

    public function createItem(): void
    {
        $this->validate();
        $product = ProductProduced::create([
            'quantity_produced' => $this->item['quantity_produced'] , 
            'user_id' => auth()->user()->id , 
            'StockTransaction_id' => $this->item['StockTransaction_id'], 
        ]);
        $StockTransaction=StockTransaction::find($this->item['StockTransaction_id']);
        $StockTransaction->status=StockTransactionStatus::Inactive->value;
        $StockTransaction->save();
        $product->increaseStock($this->item['quantity_produced']);
        $this->confirmingItemCreation = false;
        $this->emitTo('product-produced.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(ProductProduced $productproduced): void
    {
        $this->resetErrorBag();
        $this->item = $productproduced;
        $this->confirmingItemEdit = true;
        $this->oldQuantity=$productproduced->quantity_produced;
        $this->products = Product::orderBy('name')->get();

        $this->users = User::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $newQuantity = (int)$this->item->quantity_produced;
        $difference = $newQuantity - $this->oldQuantity;
        $this->item->increaseStock($difference);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('product-produced.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
