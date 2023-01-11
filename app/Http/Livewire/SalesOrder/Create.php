<?php

namespace App\Http\Livewire\SalesOrder;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\SalesOrder;
use App\Models\Inventory;

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
    protected $rules = [
        'item.customer_name' => '',
        'item.order_date' => '',
        'item.delivery_date' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.customer_name' => 'Customer Name',
        'item.order_date' => 'Order Date',
        'item.delivery_date' => 'Delivery Date',
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
        return view('livewire.sales-order.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        SalesOrder::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('sales-order.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->items = Inventory::orderBy('name')->get();
        $this->checkedItems = [];
    }

    public function createItem(): void
    {
        $this->validate();
        $item = SalesOrder::create([
            'customer_name' => $this->item['customer_name'] ?? '', 
            'order_date' => $this->item['order_date'] ?? '', 
            'delivery_date' => $this->item['delivery_date'] ?? '', 
        ]);
        $item->items()->attach($this->checkedItems);

        $this->confirmingItemCreation = false;
        $this->emitTo('sales-order.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(SalesOrder $salesorder): void
    {
        $this->resetErrorBag();
        $this->item = $salesorder;
        $this->confirmingItemEdit = true;

        $this->checkedItems = $salesorder->items->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->items = Inventory::orderBy('name')->get();

    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();

        $this->item->items()->sync($this->checkedItems);
        $this->checkedItems = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('sales-order.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
