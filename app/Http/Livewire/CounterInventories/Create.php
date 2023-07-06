<?php

namespace App\Http\Livewire\CounterInventories;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\CounterInventory;
use App\Models\Product;

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
    protected $rules = [
        'item.product_id' => '',
        'item.quantity' => '',
        'item.product_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
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
        return view('livewire.counter-inventories.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        CounterInventory::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('wertwert', 'refresh');
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
        $item = CounterInventory::create([
            'product_id' => $this->item['product_id'] ?? '', 
            'quantity' => $this->item['quantity'] ?? '', 
            'product_id' => $this->item['product_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('wertwert', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(CounterInventory $counterinventory): void
    {
        $this->resetErrorBag();
        $this->item = $counterinventory;
        $this->confirmingItemEdit = true;

        $this->products = Product::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('wertwert', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
