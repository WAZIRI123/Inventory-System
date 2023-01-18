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
        'item.quantity' => ['required',new Instock($this->quantiy)],
        ];
    }

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.product_id' => 'Product Id',
        'item.employee_id' => 'Employee Id',
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
    }

    public function deleteItem(): void
    {
        $this->sale->delete();
        $this->confirmingItemDeletion = false;
        $this->sale = '';
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
    }

    public function createItem(): void
    {
        $this->validate();
        $product = Product::find($this->item['product_id']);
        
        $product ->decreaseStock($this->item['quantity']);
 
        $this->item['employee_id']=auth()->user()->id;

        $item = Sale::create([
            'employee_id' => $this->item['employee_id'] , 
            'quantity' => $this->item['quantity'] , 
            'product_id' => $this->item['product_id'] , 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('sales-table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Sale $sale): void
    {
        $this->resetErrorBag();

        $this->item = $sale;
        $this->oldQuantity=$sale->quantity;
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('name')->get();

        $this->employees = Employee::orderBy('user_id')->get();
    }


    public function editItem(): void
    {
        $this->validate();
        $product = Product::find($this->item['product_id']);

        $oldQuantity = $this->oldQuantity;
        $newQuantity = $this->item['quantity'];
        $difference = $newQuantity - $oldQuantity;


        if($difference > 0) {
            if (!$product->inStock($difference)) {
                throw new OutOfStockException('product is out of stock');
                return;
            }

            $product->decreaseStock($difference);
        } elseif ($difference < 0) {
            $product->increaseStock(abs($difference));

        }
        $this->item->save();



        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('sales-table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
