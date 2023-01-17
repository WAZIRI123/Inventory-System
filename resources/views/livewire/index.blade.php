<div>
    <!-- start:Page content -->
    <div class="h-full bg-gray-200 p-8">
        <!-- start::Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">
            <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-sm text-indigo-600">Total Revenue</span>
                    <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">Today</span>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div>
                        <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-2xl 2xl:text-4xl font-bold">{{ $totalRevenue }}</span>
                            <div class="flex items-center ml-2 mb-1">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                <span class="font-bold text-sm text-gray-500 ml-0.5">Tsh</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-sm text-indigo-600">Total Products</span>
                    <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">Today</span>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div>
                        <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-2xl 2xl:text-4xl font-bold">{{ $totalProducts}}</span>
                            <div class="flex items-center ml-2 mb-1">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                <span class="font-bold text-sm text-gray-500 ml-0.5">In Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-sm text-indigo-600">Out of Stock</span>
                    <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">Today</span>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div>
                        <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-2xl 2xl:text-4xl font-bold">{{$outOfStock}}</span>
                            <div class="flex items-center ml-2 mb-1">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                <span class="font-bold text-sm text-gray-500 ml-0.5">In Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-sm text-indigo-600">Employee</span>
                    <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">Today</span>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div>
                        <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-2xl 2xl:text-4xl font-bold">{{$totalEmployees}}</span>
                            <div class="flex items-center ml-2 mb-1">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                <span class="font-bold text-sm text-gray-500 ml-0.5"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end::Stats -->
        <!-- start::Table -->
        <div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
          
       

        </div>
        <!-- end::Table -->

    </div>
    <!-- end:Page content -->
    </div>