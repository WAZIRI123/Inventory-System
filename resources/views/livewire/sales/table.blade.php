<div class="h-full bg-gray-200 p-8">
<div class="mt-8 min-h-screen">
      @livewire('livewire-toast')
    <div class="flex justify-between">
        <div class="text-2xl">Sales</div>
        <button type="submit" wire:click="$emitTo('sales.create', 'showCreateForm');" class="text-blue-500">
            <x-tall-crud-icon-add />
        </button> 
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div class="flex">

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
                <td class="px-3 py-2" >Product Id</td>
                <td class="px-3 py-2" >Customer Id</td>
                <td class="px-3 py-2" >Quantity</td>
                <td class="px-3 py-2" >Customer</td>
                <td class="px-3 py-2" >Product</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->product_id }}</td>
                    <td class="px-3 py-2" >{{ $result->employee_id }}</td>
                    <td class="px-3 py-2" >{{ $result->quantity }}</td>
                    <td class="px-3 py-2" >{{ $result->customer?->name }}</td>
                    <td class="px-3 py-2" >{{ $result->product?->name }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$emitTo('sales.create', 'showEditForm', {{ $result->id}});" class="text-green-500">
                            <x-tall-crud-icon-edit />
                        </button>
                        <button type="submit" wire:click="$emitTo('sales.create', 'showDeleteForm', {{ $result->id}});" class="text-red-500">
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
    @livewire('sales.create')
  
</div>
</div>