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
                <x-tall-crud-label>Invoice Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.invoice_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.invoice_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Revenue</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.revenue" />
                @error('item.revenue') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Expenses</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.expenses" />
                @error('item.expenses') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Profit</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.profit" />
                @error('item.profit') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Invoice</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.invoice_id">
                        <option value="">Please Select</option>
                        @foreach($invoices as $c)
                        <option value="{{$c->id}}">{{$c->id}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.invoice_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
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
                <x-tall-crud-label>Invoice Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.invoice_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.invoice_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Revenue</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.revenue" />
                @error('item.revenue') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Expenses</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.expenses" />
                @error('item.expenses') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Profit</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.defer="item.profit" />
                @error('item.profit') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Invoice</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.defer="item.invoice_id">
                        <option value="">Please Select</option>
                        @foreach($invoices as $c)
                        <option value="{{$c->id}}">{{$c->id}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.invoice_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
