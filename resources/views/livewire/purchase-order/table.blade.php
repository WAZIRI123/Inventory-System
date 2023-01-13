<div class="h-full bg-gray-200 p-8">
<div class="mt-8 min-h-screen">
    @livewire('livewire-toast')
    <div class="flex justify-between">
        <div class="text-2xl">Purchases</div>
        <button type="submit" wire:click="$emitTo('purchase-order.create', 'showCreateForm');" class="text-blue-500">
            <x-tall-crud-icon-add />
        </button> 
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div class="flex">
                <x-tall-crud-input-search />
            </div>
            <div class="flex">

                <x-tall-crud-page-dropdown />
            </div>
        </div>
        <table class="w-full whitespace-no-wrap mt-4 shadow-2xl text-xs" wire:loading.class.delay="opacity-50">
            <thead>
                <tr class="text-left font-bold bg-blue-400">
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('id')">Id</button>
                        <x-tall-crud-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('vendor_id')">Vendor Id</button>
                        <x-tall-crud-sort-icon sortField="vendor_id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >Order Date</td>
                <td class="px-3 py-2" >Delivery Date</td>
                <td class="px-3 py-2" >Vendor</td>
                <td class="px-3 py-2" >Items</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->vendor_id }}</td>
                    <td class="px-3 py-2" >{{ $result->order_date }}</td>
                    <td class="px-3 py-2" >{{ $result->delivery_date }}</td>
                    <td class="px-3 py-2" >{{ $result->vendor?->name }}</td>
                    <td class="px-3 py-2" >{{ $result->items->implode('name', ',') }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$emitTo('purchase-order.create', 'showEditForm', {{ $result->id}});" class="text-green-500">
                            <x-tall-crud-icon-edit />
                        </button>
                        <button type="submit" wire:click="$emitTo('purchase-order.create', 'showDeleteForm', {{ $result->id}});" class="text-red-500">
                            <x-tall-crud-icon-delete />
                        </button>
                    </td>
               </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $results->links() }}
    </div>
    @livewire('purchase-order.create')
 
</div>
</div>