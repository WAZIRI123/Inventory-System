<?php

namespace App\Http\Livewire\Purchase;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use AuthorizesRequests;


    public $item;
    public $quantity;

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];
    public $purchase;

    /**
     * @var array
     */
    public $products = [];


    /**
     * @var array
     */
    protected $rules = [
        'item.purchase_price' => 'required|numeric',
        'item.product_id' => 'required|integer|exists:products,id',
        'item.quantity' => 'required|integer|min:1',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.purchase_price' => 'Purchase Price',
        'item.product_id' => 'Product Id',
        'item.quantity' => 'Quantity',
        'item.product_id' => 'Product',

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
        return view('livewire.purchase.create');
    }

    public function showDeleteForm(Purchase $purchase): void
    {
        $this->confirmingItemDeletion = true;
        $this->purchase = $purchase;
    }

    public function deleteItem(): void
    {
        $product=Product::find($this->purchase->product_id);
        $quantity=$this->purchase->quantity;
        $this->purchase->delete();
        $product->decreaseStock($quantity);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('purchase.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products = Product::orderBy('name')->get();

    }

    public function createItem(): void
    {
        $this->validate();

        $item = Purchase::create([
            'purchase_price' => $this->item['purchase_price'] , 
            'product_id' => $this->item['product_id'] , 
            'quantity' => $this->item['quantity'] , 
        ]);

        if($item){
            $product=Product::find($this->item['product_id']);

            $product->increaseStock($this->item['quantity']);
        }


        $this->confirmingItemCreation = false;
        $this->emitTo('purchase.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Purchase $purchase): void
    {
        $this->resetErrorBag();
        $this->item = $purchase;
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $oldQuantity = $this->item->quantity;

        $this->item->save();
        $product=Product::find($this->item->product_id);
        $newQuantity = &$this->item->quantity;
        $difference = $newQuantity - $oldQuantity;
        dd($difference);
        $product->increaseStock($this->item->quantity - $oldQuantity);
        
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('purchase.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
