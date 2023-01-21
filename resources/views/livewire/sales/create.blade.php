<div>

    <x-tall-crud-confirmation-dialog wire:model="confirmingItemDeletion">
        <x-slot name="title">
            Delete Record
        </x-slot>

        <x-slot name="content">
            Are you sure you want to Delete Record?
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemDeletion', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Delete</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-confirmation-dialog>
@if ($confirmingItemCreation)

    <x-tall-crud-dialog-modal wire:model="confirmingItemCreation">
        <x-slot name="title" >
            Add Record
        </x-slot>
     
        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            @for ($i = 1; $i <= $itemCount; $i++)
            <div class="mt-4">
                <x-tall-crud-label>Quantity</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.{{ $i }}.quantity"  name="item[{{$i}}][quantity]" wire:key="item[quantity][{{$i}}]"  />
                @error('item.'.$i.'.quantity')
                <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message>
                @enderror
    @if (session()->has('error.'.$i))
    <x-tall-crud-error-message>{{ session()->get('error.'.$i) }}</x-tall-crud-error-message>
    @endif
            </div>

                <div class="mt-4">
                    <x-tall-crud-label>Product</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.{{ $i }}.product_id" name="item[product_id][{{$i}}]" wire:key="item[product_id][{{$i}}]">
                        <option value="">Please Select</option>
                        @foreach($products as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.'.$i.'.product_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
                @endfor
            <div class="grid grid-cols-2 gap-8">

        </x-slot>
  

        <x-slot name="footer">
            <x-tall-crud-button wire:click="decrementItemCount">Remove</x-tall-crud-button>
            <x-tall-crud-button wire:click="incrementItemCount">Add More</x-tall-crud-button>
            <x-tall-crud-button wire:click="$set('confirmingItemCreation', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
        
@endif

    <x-tall-crud-dialog-modal wire:model="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">

            <div class="mt-4">
                <x-tall-crud-label>Quantity</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.quantity" />
                @error('item.quantity') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            @if (session('error'))
            <x-tall-crud-error-message>{{session('error')}}</x-tall-crud-error-message>
            @endif
            </div>

                <div class="mt-4">
                    <x-tall-crud-label>Product</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.product_id" >
                        <option value="">Please Select</option>
                        @foreach($products as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.product_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror


                </div>
          </div>
            
            <div class="grid grid-cols-2 gap-8 mt-5">

        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
