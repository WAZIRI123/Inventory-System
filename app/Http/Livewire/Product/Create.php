<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
use AuthorizesRequests;

    public $item;

    public $quantity=0;

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];

    public $product;


    /**
     * @var array
     */
    protected $rules = [
        'item.name' => 'required|string',
        'item.sale_price' => 'required|numeric',
       
        ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.sale_price' => 'Sale Price',

   
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    /**
     * @var string | int
     */
    public $primaryKey;

    public $oldQuantity;

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
        return view('livewire.product.create');
    }

    public function showDeleteForm(Product $product): void
    {
        $this->authorize('delete',$product);
        $this->confirmingItemDeletion = true;
        $this->product = $product;
    }

    public function deleteItem(Product $product): void
    {
        $this->authorize('delete',$product);
        $this->product->delete();
         $this->product->clearStock();
        $this->confirmingItemDeletion = false;
        $this->product = '';
        $this->reset(['item']);
        $this->emitTo('product.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->authorize('create',[Product::class]);
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

    }

    public function createItem(): void
    {
        $this->authorize('create',[Product::class]);
        $this->validate();
        
        $product = Product::create([
            'name' => $this->item['name'], 
            'sale_price' => $this->item['sale_price'],  
    
        ]);

    

        $this->confirmingItemCreation = false;
        $this->emitTo('product.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Product $product): void
    {
        $this->authorize('update',$product);
        $this->resetErrorBag();
        $this->item = $product;
        $this->confirmingItemEdit = true;

    }

    public function editItem(Product $product): void
    {
        $this->authorize('update',$product);
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->emitTo('product.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
