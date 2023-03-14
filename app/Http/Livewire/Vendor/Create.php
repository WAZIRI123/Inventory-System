<?php

namespace App\Http\Livewire\Vendor;

use Livewire\Component;
use \Illuminate\View\View;
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
    protected $rules = [
        'item.name' => '',
  
        'item.contact_email' => '',
        'item.contact_phone' => '',

    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',

        'item.contact_email' => 'Contact Email',
        'item.contact_phone' => 'Contact Phone',
   
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
        return view('livewire.vendor.create');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Vendor::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('vendor.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Deleted Successfully');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Vendor::create([
            'name' => $this->item['name'] ?? '',  
            'contact_email' => $this->item['contact_email'] ?? '', 
            'contact_phone' => $this->item['contact_phone'] ?? '', 
            
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('vendor.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(Vendor $vendor): void
    {
        $this->resetErrorBag();
        $this->item = $vendor;
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('vendor.table', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Updated Successfully');
    }

}
