<div class="h-full bg-gray-200 p-8">
    <div class="mt-8 min-h-screen">
          @livewire('livewire-toast')
        <div class="flex justify-between">
            <div class="text-2xl">Sales</div>

                <div class="grid grid-cols-3 gap-6 items-center">
                <div class="mt-4">
                    <x-tall-crud-label>Start Date</x-tall-crud-label>
                    <x-tall-crud-input class="block mt-1 w-full" type="date" wire:model="startDate" />
                </div>
                <div class="mt-4">
                    <x-tall-crud-label>End Date</x-tall-crud-label>
                    <x-tall-crud-input class="block mt-1 w-full" type="date" wire:model="endDate" />
                </div>
                <div class="mt-4">
                <x-tall-crud-label>Print</x-tall-crud-label>
                <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Report</x-tall-crud-button>
            </div>
            </div>
           </div>

        <div class="mt-2">
            <div class="flex justify-between">
                <div class="flex">

                </div>
            </div>
            <table class="w-full whitespace-no-wrap mt-0 shadow-2xl text-xs" wire:loading.class.delay="opacity-50">
                <thead>
                    <tr class="text-left font-bold bg-blue-400">
                    <td class="px-3 py-2" >
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">Id</button>
                            <x-tall-crud-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </td>
                    <td class="px-3 py-2" >Product</td>
                    <td class="px-3 py-2" >Quantity</td>
                    <td class="px-3 py-2" >Employee</td>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-400">
                @if ($results->count())
                @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->product?->name }}</td>
                    <td class="px-3 py-2" >{{ $result->quantity }}</td>
                    <td class="px-3 py-2" >{{ $result->employee->user?->name }}</td>
               </tr>
               @endforeach

               @else
               <tr >
               <td class="px-3 py-2 text-center ">No Data found ..</td>
               </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

