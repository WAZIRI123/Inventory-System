<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Financial;
use App\Models\Invoice;

class WertChild extends Component
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
    public $invoices = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.invoice_id' => 'required',
        'item.revenue' => '',
        'item.expenses' => '',
        'item.profit' => '',
        'item.invoice_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.invoice_id' => 'Invoice Id',
        'item.revenue' => 'Revenue',
        'item.expenses' => 'Expenses',
        'item.profit' => 'Profit',
        'item.invoice_id' => 'Invoice',
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
        return view('livewire.wert-child');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Financial::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('wert', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->invoices = Invoice::orderBy('id')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Financial::create([
            'invoice_id' => $this->item['invoice_id'] ?? '', 
            'revenue' => $this->item['revenue'] ?? '', 
            'expenses' => $this->item['expenses'] ?? '', 
            'profit' => $this->item['profit'] ?? '', 
            'invoice_id' => $this->item['invoice_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('wert', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Financial $financial): void
    {
        $this->resetErrorBag();
        $this->item = $financial;
        $this->confirmingItemEdit = true;

        $this->invoices = Invoice::orderBy('id')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('wert', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
