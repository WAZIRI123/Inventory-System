<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\PurchaseOrder;
use App\Models\Inventory;
use App\Models\Vendor;

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
    public $items = [];
    /**
     * @var array
     */
    public $checkedItems = [];

    /**
     * @var array
     */
    public $vendors = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.vendor_id' => '',
        'item.order_date' => '',
        'item.delivery_date' => '',
        'item.vendor_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.vendor_id' => 'Vendor Id',
        'item.order_date' => 'Order Date',
        'item.delivery_date' => 'Delivery Date',
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
        return view('livewire.purchase-order.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        PurchaseOrder::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('purchase-order.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->items = Inventory::orderBy('name')->get();
        $this->checkedItems = [];

        $this->vendors = Vendor::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = PurchaseOrder::create([
            'vendor_id' => $this->item['vendor_id'] ?? '', 
            'order_date' => $this->item['order_date'] ?? '', 
            'delivery_date' => $this->item['delivery_date'] ?? '', 
            'vendor_id' => $this->item['vendor_id'] ?? 0, 
        ]);
        $item->items()->attach($this->checkedItems);

        $this->confirmingItemCreation = false;
        $this->emitTo('purchase-order.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(PurchaseOrder $purchaseorder): void
    {
        $this->resetErrorBag();
        $this->item = $purchaseorder;
        $this->confirmingItemEdit = true;

        $this->checkedItems = $purchaseorder->items->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->items = Inventory::orderBy('name')->get();


        $this->vendors = Vendor::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();

        $this->item->items()->sync($this->checkedItems);
        $this->checkedItems = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('purchase-order.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
