<template>

         <!-- start::Menu link -->
          <router-link :to="{ path: '/path',params: { userId: 123 } }"  class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"> 
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                    :class="linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
                <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                    Logout
                </span></router-link>

            <!-- end::Menu link -->

</template>

<script setup>

</script>