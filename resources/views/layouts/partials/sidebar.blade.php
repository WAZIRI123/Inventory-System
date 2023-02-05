<!-- start::Black overlay -->
<div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false"
    class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
<!-- end::Black overlay -->
<aside :class="menuOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 bg-secondary overflow-y-auto lg:translate-x-0 lg:inset-0 custom-scrollbar">
    <!-- start::Logo -->
    <div class="flex items-center justify-center bg-black bg-opacity-30 h-16">
        <h1 class="text-gray-100 text-lg font-bold uppercase tracking-widest">
            Inventory System
        </h1>
    </div>
    <!-- end::Logo -->

    <!-- start::Navigation  -->
    <nav class="py-10 custom-scrollbar">
        <!-- start::Menu link -->
        <x-side-menu.div-link route="dashboard.index" title="Dashboard" />
        <!-- end::Menu link -->

        <p class="text-xs text-gray-600 mt-10 mb-2 px-6 uppercase">Inventory activities</p>

        {{-- start menu wrapper --}}

        <!-- start::Menu link  -->
        <x-side-menu.div-link route="sales" title="Sales" />
        <!-- end::Menu link -->
        <!-- start::Menu link  -->
        <x-side-menu.div-link route="purchases" title="Purchases" />
        <!-- end::Menu link -->

        @if (auth()->user()->hasRole('Admin'))
        <!-- start::Menu link  -->
        <x-side-menu.div-link route="product" title="products" />
        <!-- end::Menu link -->
        <!-- start::Menu link  -->
        <x-side-menu.div-link route="employee" title="Employees" />
        <!-- end::Menu link -->

        {{-- start menu wrapper --}}
        <div x-data="{ linkHover: false, linkActive: false }">
            <div @mouseover="linkHover = true" @mouseleave="linkHover = false" @click="linkActive = !linkActive"
                class="{{ (request()->is('report/*')) ? 'bg-black bg-opacity-30' : '' }} flex items-center justify-between text-gray-400 hover:text-gray-100 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                        :class=" linkHover || linkActive ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="ml-3">Reports</span>
                </div>
                <svg class="w-3 h-3 transition duration-300" :class="linkActive ? 'rotate-90' : ''" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <!-- start::Submenu -->
            <ul x-show="linkActive" x-collapse.duration.300ms="" class="text-gray-400"
                style="overflow: hidden; height: 0px;">

                <!-- start::Submenu link -->
                <x-side-menu.div-link route="sale-report" title="Sale Report" />

                <!-- end::Submenu link -->

            </ul>
            <!-- end::Submenu  graduations-->
        </div>
        {{-- end menu wrapper --}}
        @endif


        <p class="text-xs text-gray-600 mt-10 mb-2 px-6 uppercase">Account</p>

        <!-- start::Menu link -->
        <a x-data="{ linkHover: false }" @mouseover="linkHover = true" @mouseleave="linkHover = false"
            class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
            href="{{ route('profile.update') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                Profile
            </span>
        </a>
        <!-- end::Menu link  -->

        <!-- start::Menu link -->
        <form method="POST" action="{{ route('logout') }}" class="grid gap-2">
            @csrf
            <a x-data="{ linkHover: false }" @mouseover="linkHover = true" @mouseleave="linkHover = false"
                href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                    :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                    Logout
                </span>
            </a>
        </form>
        <!-- end::Menu link -->

    </nav>
    <!-- end::Navigation -->
</aside>