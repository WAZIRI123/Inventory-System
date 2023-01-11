<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\User;

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
    protected $rules = [
        'item.name' => '',
        'item.email' => '',
        'item.email_verified_at' => '',
        'item.password' => '',
        'item.deleted_at' => '',
        'item.remember_token' => '',
        'item.created_at' => '',
        'item.updated_at' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.email' => 'Email',
        'item.email_verified_at' => 'Email Verified At',
        'item.password' => 'Password',
        'item.deleted_at' => 'Deleted At',
        'item.remember_token' => 'Remember Token',
        'item.created_at' => 'Created At',
        'item.updated_at' => 'Updated At',
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
        User::destroy($this->primaryKey);
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
    }

    public function createItem(): void
    {
        $this->validate();
        $item = User::create([
            'name' => $this->item['name'] ?? '', 
            'email' => $this->item['email'] ?? '', 
            'email_verified_at' => $this->item['email_verified_at'] ?? '', 
            'password' => $this->item['password'] ?? '', 
            'deleted_at' => $this->item['deleted_at'] ?? '', 
            'remember_token' => $this->item['remember_token'] ?? '', 
            'created_at' => $this->item['created_at'] ?? '', 
            'updated_at' => $this->item['updated_at'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('wert', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Record Added Successfully');
    }
 
    public function showEditForm(User $user): void
    {
        $this->resetErrorBag();
        $this->item = $user;
        $this->confirmingItemEdit = true;
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
