<?php

namespace App\Http\Livewire\Purchases;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Vendor;
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
    public $vendors = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.quantity' => 'required|numeric',
        'item.product_id' => 'required|exists:products,id',
        'item.vendor_id' => 'required|exists:vendors,id',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.quantity' => 'Quantity',
        'item.product_id' => 'Product',
        'item.vendor_id' => 'Vendor',
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
        return view('livewire.purchases.create');
    }

    public function showDeleteForm(Purchase $purchase): void
    {
  
        $this->authorize('delete',$purchase);
        $this->confirmingItemDeletion = true;
        $this->purchase= $purchase;
    }

    public function deleteItem(Purchase $purchase): void
    {
        $this->quantity=$this->purchase->quantity;
        $Product=Product::find($this->purchase->id);

        $this->authorize('delete',$purchase);
       
        $this->purchase->delete();
        $Product->decreaseStock($this->quantity);
        $this->confirmingItemDeletion = false;
        $this->purchase= '';
        $this->reset(['item']);
        $this->emitTo('purchases.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->authorize('create',[Purchase::class]);
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products = Product::orderBy('name')->get();

        $this->vendors = Vendor::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->authorize('create',[Purchase::class]);
        $this->validate();
        $purchase = Purchase::create([  
            'quantity' => $this->item['quantity'], 
            'product_id' => $this->item['product_id'], 
            'vendor_id' => $this->item['vendor_id'], 
        ]);

     $product=Product::find($purchase->product_id);

        $product->increaseStock($purchase->quantity);

        $this->confirmingItemCreation = false;
        $this->emitTo('purchases.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Purchase $purchase): void
    {
      
     $product=Product::find($purchase->product_id);
        $this->authorize('update',$purchase);
        $this->resetErrorBag();
        $this->item = $purchase;
        $this->quantity=$product->stock();
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('name')->get();

        $this->vendors = Vendor::orderBy('name')->get();
    }

    public function editItem(Purchase $purchase): void
    {
       
        $Product=Product::find( $this->item->id);
        $this->authorize('update',$purchase);
        $this->validate();
        $this->item->save();
        $Product->setStock($this->item->quantity);
        $this->confirmingItemEdit = false;
        $this->item= '';
        $this->emitTo('purchases.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
