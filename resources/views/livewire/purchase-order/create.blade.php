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
            <div class="mt-4">
                <x-tall-crud-label>Vendor Id</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.vendor_id" />
                @error('item.vendor_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Order Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.order_date" />
                @error('item.order_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Delivery Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.delivery_date" />
                @error('item.delivery_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <h2 class="mt-4">Items</h2>
            <div class="grid grid-cols-3">
                @foreach( $items as $c)
                <x-tall-crud-checkbox-wrapper class="mt-4">
                    <x-tall-crud-label>{{$c->name}}</x-tall-crud-label>
                    <x-tall-crud-checkbox value="{{ $c->id }}" class="ml-2" wire:model.defer="checkedItems" />
                </x-tall-crud-checkbox-wrapper>
                @endforeach
            </div>

            <div class="grid grid-cols-3">
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
            <div class="mt-4">
                <x-tall-crud-label>Vendor Id</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.vendor_id" />
                @error('item.vendor_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Order Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.order_date" />
                @error('item.order_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Delivery Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.delivery_date" />
                @error('item.delivery_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <h2 class="mt-4">Items</h2>
            <div class="grid grid-cols-3">
                @foreach( $items as $c)
                <x-tall-crud-checkbox-wrapper class="mt-4">
                    <x-tall-crud-label>{{$c->name}}</x-tall-crud-label>
                    <x-tall-crud-checkbox value="{{ $c->id }}" class="ml-2" wire:model.defer="checkedItems" />
                </x-tall-crud-checkbox-wrapper>
                @endforeach
            </div>

            <div class="grid grid-cols-3">
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
