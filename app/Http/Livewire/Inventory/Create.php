<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;

class Create extends Component
{

    public $item;

    /**
     * @var array
     */
    protected $listeners = [
        'showEditForm',
        'showDeleteForm',
        'showCreateForm',
    
    ];

    /**
     * @var array
     */
    public $purchaseOrders = [];
    /**
     * @var array
     */
    public $checkedPurchaseOrders = [];

    /**
     * @var array
     */
    public $salesOrders = [];
    /**
     * @var array
     */
    public $checkedSalesOrders = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.name' => '',
        'item.description' => '',
        'item.quantity' => '',
        'item.unit' => '',
        'item.location' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.description' => 'Description',
        'item.quantity' => 'Quantity',
        'item.unit' => 'Unit',
        'item.location' => 'Location',
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
        return view('livewire.inventory.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Inventory::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('inventory.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->purchaseOrders = PurchaseOrder::orderBy('vendor_id')->get();
        $this->checkedPurchaseOrders = [];

        $this->salesOrders = SalesOrder::orderBy('customer_name')->get();
        $this->checkedSalesOrders = [];
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Inventory::create([
            'name' => $this->item['name'] ?? '', 
            'description' => $this->item['description'] ?? '', 
            'quantity' => $this->item['quantity'] ?? '', 
            'unit' => $this->item['unit'] ?? '', 
            'location' => $this->item['location'] ?? '', 
        ]);
        $item->purchaseOrders()->attach($this->checkedPurchaseOrders);
        $item->salesOrders()->attach($this->checkedSalesOrders);

        $this->confirmingItemCreation = false;
        $this->emitTo('inventory.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Inventory $inventory): void
    {
        $this->resetErrorBag();
        $this->item = $inventory;
        $this->confirmingItemEdit = true;
       
        $this->checkedPurchaseOrders = $inventory->purchaseOrders->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->purchaseOrders = PurchaseOrder::orderBy('vendor_id')->get();

        $this->checkedSalesOrders = $inventory->salesOrders->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->salesOrders = SalesOrder::orderBy('customer_name')->get();

    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();

        $this->item->purchaseOrders()->sync($this->checkedPurchaseOrders);
        $this->checkedPurchaseOrders = [];

        $this->item->salesOrders()->sync($this->checkedSalesOrders);
        $this->checkedSalesOrders = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('inventory.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
