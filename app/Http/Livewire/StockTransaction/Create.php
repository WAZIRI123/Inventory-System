<?php

namespace App\Http\Livewire\StockTransaction;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class Create extends Component
{

    public $item;
    public $oldQuantity;

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
        'item.product_id' => 'required|integer|exists:products,id',
        'item.employee_id' => 'required|integer|exists:employees,id',
        'item.quantity' => 'required|integer|min:1',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.product_id' => 'Product',
        'item.employee_id' => 'Employee',
        'item.quantity' => 'Quantity',
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
        return view('livewire.stock-transaction.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        StockTransaction::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('stock-transaction.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }

    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products = Product::orderBy('name')->get();

        $this->employees = Employee::with('user')->orderBy('user_id')->get();
    }

    public function createItem(): void
    {
        $this->validate();

        if ($this->item['product_id']) {
            $product = Product::find($this->item['product_id']);

            if ($product->inStock($this->item['quantity'])) {
                 StockTransaction::create([
                    'quantity' => $this->item['quantity'],
                    'product_id' => $this->item['product_id'],
                    'employee_id' => $this->item['employee_id'],
                ]);
                $product->decreaseStock($this->item['quantity']);
            } else {

                session()->flash('error', 'The provided quantity exceeds the stock quantity.');

                return;
            }
        }
        $this->confirmingItemCreation = false;
        $this->emitTo('stock-transaction.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }

    public function showEditForm(StockTransaction $stocktransaction): void
    {
        $this->resetErrorBag();
        $this->item = $stocktransaction;
        $this->confirmingItemEdit = true;
        $this->oldQuantity = (int)$this->item->quantity;
        $this->products = Product::orderBy('name')->get();

        $this->employees = Employee::with('user')->orderBy('user_id')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        DB::transaction(function () {
            $product = Product::find($this->item->product_id);
            $newQuantity = (int)$this->item->quantity;
            $difference = $newQuantity - $this->oldQuantity;
        
            if ($this->item['quantity'] > $this->oldQuantity) {
                $difference = $this->item['quantity'] - $this->oldQuantity;
        
                if (!$product->inStock($difference)) {
                    session()->flash('error', 'The provided quantity exceeds the stock quantity.');
                    return;
                } else {
                    $product->decreaseStock($difference);
                    $this->item->save();
                }
            } elseif ($this->item['quantity'] < $this->oldQuantity) {
                $difference = $this->oldQuantity - $this->item['quantity'];
                $product->increaseStock($difference);
                $this->item->save();
            }
            $this->confirmingItemEdit = false;
            $this->primaryKey = '';
            $this->emitTo('stock-transaction.table', 'refresh');
            $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
        });
        
    }
}
