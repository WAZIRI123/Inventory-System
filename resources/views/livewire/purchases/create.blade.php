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

    <x-tall-crud-dialog-modal wire:model="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>

        <x-slot name="content">
        <div class="grid grid-cols-2 gap-8">
           
            <div class="mt-4">
                <x-tall-crud-label>Quantity</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.quantity" />
                @error('item.quantity') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
     
                <div class="mt-4">
                    <x-tall-crud-label>Product</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.product_id">
                        <option value="">Please Select</option>
                        @foreach($products as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.product_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
        </div>
                <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-tall-crud-label>Vendor</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.vendor_id">
                        <option value="">Please Select</option>
                        @foreach($vendors as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.vendor_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemCreation', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>

    <x-tall-crud-dialog-modal wire:model="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content">
        <div class="grid grid-cols-2 gap-8">
          
            <div class="mt-4">
                <x-tall-crud-label>Quantity</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.quantity" />
                @error('item.quantity') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
   

          
                <div class="mt-4">
                    <x-tall-crud-label>Product</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.product_id" disabled>
                        <option value="" disabled>Please Select</option>
                        @foreach($products as $c)
                        <option value="{{$c->id}}" disabled>{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.product_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
        </div>
        <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-tall-crud-label>Vendor</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.vendor_id">
                        <option value="">Please Select</option>
                        @foreach($vendors as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.vendor_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
