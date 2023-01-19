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
     * @var array
     */
    protected function rules()
    {
        return ['item.product_id' => 'required|exists:products,id',
            'item.quantity' => ['required','numeric'],
        ];
    }

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.product_id' => 'Product Id',
        'item.employee_id' => 'Employee Id',
        'validation.stock' => 'The provided quantity exceeds the stock quantity.'
    ];

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
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products= Product::orderBy('id')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $product = Product::find($this->item['product_id']);

        if (!$product->inStock($this->item['quantity'])) {


          session()->flash('error', 'The provided quantity exceeds the stock quantity.');  

           
        }else{
            $product ->decreaseStock($this->item['quantity']);
 
            $this->item['employee_id']=auth()->user()->id;
    
    
            $item = Sale::create([
                'employee_id' => $this->item['employee_id'] , 
                'quantity' => $this->item['quantity'] , 
                'product_id' => $this->item['product_id'] , 
            ]);
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
        $this->validate();
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
