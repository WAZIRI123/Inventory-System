<?php

namespace App\Http\Livewire\Sales;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use App\Exceptions\OutOfStockException;
use App\Rules\Instock;

class Create extends Component
{

    public $itemCount = 1;
    public $item;
     
    public $quantiy=null;

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
     * @var bool
     */
    public $confirmingItemDeletion = false;

    public $sale;
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
        return view('livewire.sales.create');
    }
    public function incrementItemCount()
    {
        $this->itemCount++;
    }

    public function decreamentItemCount()
    {
        $this->itemCount--;
    }
    
    public function showDeleteForm(Sale $sale): void
    {
       
        $this->confirmingItemDeletion = true;

        $this->sale = $sale;
        $this->oldQuantity=$sale->quantity;
       
    }

    public function deleteItem(): void
    {
        $product = Product::find($this->sale->product_id);
        $this->sale->delete();
        $product->increaseStock($this->oldQuantity);
        $this->confirmingItemDeletion = false;
        $this->sale = '';
        $this->reset(['item']);
        $this->emitTo('sales.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void

    {
        $this->confirmingItemCreation = true;
        $this->reset('itemCount');
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products= Product::orderBy('id')->get();
    }

    public function createItem(): void
    {
        for ($i = 1; $i <= $this->itemCount; $i++) {

        $this->validate([
            " item.{$i}.product_id" => 'required',
            "item.{$i}.quantity" => 'required|numeric|min:1',
        ]);
        $product = Product::find($this->item[$i]['product_id']);

        if (!$product->inStock($this->item[$i]['quantity'])) {


          session()->flash('error', 'The provided quantity exceeds the stock quantity.');  

          return;

        }else{
            $product->decreaseStock($this->item[$i]['quantity']);
 
            $this->item[$i]['employee_id'] = auth()->user()->id;
    
    
            Sale::create([
                'employee_id' => $this->item[$i]['employee_id'] , 
                'quantity' => $this->item[$i]['quantity'] , 
                'product_id' => $this->item[$i]['product_id'] , 
            ]);
        }
            $this->confirmingItemCreation = false;
            $this->emitTo('sales.table', 'refresh');
            $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
        }
        

    }
 
    public function showEditForm(Sale $sale): void
    {
        $this->resetErrorBag();
        $this->oldQuantity=$sale->quantity;
        $this->item = $sale;
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('id')->get();

        $this->employees = Employee::orderBy('user_id')->get();
    }


    public function editItem(): void
    {
     
        $product = Product::find($this->item['product_id']);
         
         $product->increaseStock($this->oldQuantity);
    
        if (!$product->inStock($this->item['quantity'])) {
           
            $product->decreaseStock($this->oldQuantity);

          session()->flash('error', 'The provided quantity exceeds the stock quantity.');  
           

        }
        else {
            $product->decreaseStock($this->item['quantity']);
            $this->item->save();
            $this->confirmingItemEdit = false;
            $this->primaryKey = '';
            $this->emitTo('sales.table', 'refresh');
            $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
        }
       
    }

}
